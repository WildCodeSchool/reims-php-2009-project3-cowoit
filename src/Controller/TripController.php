<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Form\CreateTripType;
use App\Entity\Participation;
use App\Repository\TripRepository;
use App\Repository\ParticipationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TripController extends AbstractController
{
    /**
     * @Route("/trip", name="trip_index")
     */
    public function index(): Response
    {
        $trips = $this->getDoctrine()
        ->getRepository(Trip::class)
        ->findAll();

        return $this->render('trip/index.html.twig', [
            'trips' => $trips,
        ]);
    }

    /**
     * @Route("/trip/new", name="trip_new")
     */
    public function new(Request $request): Response
    {
        $trip = new Trip();
        $form = $this->createForm(CreateTripType::class, $trip);
        $form-> handleRequest($request);
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $trip->setDriver($user);
            $entityManager = $this->getDoctrine()
            ->getManager();
            $entityManager->persist($trip);
            $entityManager->flush();
            return $this->redirectToRoute('trip_search');
        }
        return $this->render('trip/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="trip_search")
     */
    public function search(Request $request, TripRepository $tripRepository): Response
    {
        $trip = new Trip();
        $form = $this->createForm(TripType::class, $trip);
        $form-> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $trip->getDate();
            $addressStart = $trip->getAddressStart();
            $addressEnd = $trip->getAddressEnd();
            $currentUser = $this->getUser();
            $trip = $tripRepository->search(
                (string)$date,
                (string)$addressStart,
                (string)$addressEnd,
                $currentUser
            );
        }

        return $this->render('trip/search.html.twig', [
            'trips' => $trip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trip/history", name="trip_history")
     */
    public function history(TripRepository $tripRepository): Response
    {
        $history = $tripRepository->history();

        return $this->render('trip/history.html.twig', [
            'history' => $history
        ]);
    }

    /**
     * @Route("/trip/map", name="trip_map")
     */
    public function map(): Response
    {
        return $this->render('trip/map.html.twig');
    }

    /**
     * @Route("/trip/{id}", name="trip_show", methods={"GET"})
     */
    public function show(Trip $trip): Response
    {
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
        ]);
    }

    /**
     * @Route("/trip/reserved/{id}", name="trip_reserved", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function reserved(
        TripRepository $tripRepository,
        Participationrepository $participationRepo,
        int $id,
        Trip $trip
    ): Response {
        $participation = new Participation();
        $tripId = $tripRepository->find($trip->getId());
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $verifTrip = $participationRepo->findBy(['trip' => $tripId, 'passenger' => $user]);

        if ($verifTrip != null) {
            $this->addFlash('message', 'Trajet déjà réservé');
            return $this->redirect($this->generateUrl('trip_show', ['id' => $id]));
        } else {
            $participation->setPassenger($user);
            $participation->setTrip($tripId);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participation);
            $entityManager->flush();

            $trip = $trip->setNbPassengers($trip->getNbPassengers() - 1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trip);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('profile', ['id' => $user->getId()]));
        }
    }
}
