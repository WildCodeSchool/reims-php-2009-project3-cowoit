<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TripRepository;
use App\Entity\Trip;

class TripController extends AbstractController
{
    /**
     * @Route("/trip", name="trip")
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
}
