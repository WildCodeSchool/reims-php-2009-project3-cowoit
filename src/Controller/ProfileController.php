<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Form\CommentType;
use App\Entity\Participation;
use App\Form\EditProfileType;
use App\Form\EditPasswordType;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="profile")
     */
    public function profile(
        UserRepository $userRepository,
        ParticipationRepository $participationRepo,
        TripRepository $tripRepository,
        int $id
    ): Response {
        $noteAvg = $participationRepo->avgNote($id);
        $noteCount = $participationRepo->countNote($id);
        $allTrips = $tripRepository->countTrips($id);
        $user = $userRepository->find($id);
        return $this->render('profile/index.html.twig', [
            'noteAvg' => number_format(floatval($noteAvg['note_avg']), 1, '.', ' '),
            'noteCount' => $noteCount['note_count'],
            'allTrips' => $allTrips['all_trips'],
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/edit", name="profile_edit")
     */
    public function edit(Request $request, int $id): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirect($this->generateUrl('profile', ['id' => $id]));
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}/edit/password", name="profile_edit_password")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, int $id): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user == null) {
            throw new Exception();
        }
        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('message', 'Mot de passe mis a jour');
            return $this->redirect($this->generateUrl('profile', ['id' => $id]));
        }

        return $this->render('profile/editPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/nextTrips", name="profile_next_trips")
     */
    public function nextTrips(ParticipationRepository $participationRepo): Response
    {
        $trips = $participationRepo->nextTrips($this->getUser());
        return $this->render('profile/trip.html.twig', ['trips' => $trips]);
    }

    /**
     * @Route("/profile/passedTrips", name="profile_passed_trips")
     */
    public function passedTrips(ParticipationRepository $participationRepo): Response
    {
        $trips = $participationRepo->passedTrips($this->getUser());
        return $this->render('profile/history.html.twig', ['trips' => $trips]);
    }

    /**
     * @Route("/user/{id}/comment/{commentId}", name="profile_comment", methods={"GET","POST"})
     */
    public function newCommment(Request $request, int $id, int $commentId): Response
    {
        $participation = new Participation();
        /** @var \App\Entity\Participation $participation */
        $participation = $this->getDoctrine()->getRepository(Participation::class)->findOneBy(['trip' => $commentId]);
        $form = $this->createForm(CommentType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            $participation = $participation->setComment($form->get('comment')->getData());
            $participation = $participation->setNote($form->get('note')->getData());
            // $entityManager->persist($participation);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('message', 'Commentaire posté');
            return $this->redirect($this->generateUrl('profile', ['id' => $id]));
        }

        return $this->render('profile/addComment.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}/reviews", name="profile_show_comment")
     */
    public function showComment(ParticipationRepository $participationRepo, int $id): Response
    {
        $comments = $participationRepo->comment($id);
        return $this->render('profile/showComment.html.twig', ['comments' => $comments]);
    }

    /**
     * @Route("/user/{id}/driversTrip", name="profile_drivers_trip")
     */
    public function posted(TripRepository $tripRepository, int $id): Response
    {
        $newDriverTrip = $tripRepository->newDriverTrip($id);
        return $this->render('profile/driversTrip.html.twig', ['driversTrips' => $newDriverTrip]);
    }
}
