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

        if ($form->isSubmitted() && $form->isValid()) {
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
            $trip = $tripRepository->search((string)$date, (string)$addressStart, (string)$addressEnd);
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
}
