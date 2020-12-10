<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Repository\TripRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $form = $this->createForm(TripType::class, $trip);
        $form-> handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()
            ->getManager();
            $entityManager->persist($trip);
            $entityManager->flush();
            return $this->redirectToRoute('trip_index');
        }
        return $this->render('trip/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
