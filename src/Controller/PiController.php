<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PiIteration;

/**
 * Pi Controller.
 * @Route("/api", name="api_")
 */
class PiController
{
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * Return latest Pi Value.
     * @Rest\Get("/pi")
     *
     * @return Response
     */
    public function getLatestPiValue()
    {
        $latestPi = $this->em->getRepository(PiIteration::class)->findByLatestIteration();
        $pi = $latestPi->getPi();

        $sunRadius = 695508; //in km
        bcscale(5);
        $sunCircumference = bcmul(bcmul('2', $pi), $sunRadius);

        $response = [
            'pi' => $pi,
            'sunCircumference' => $sunCircumference,
        ];

        return new Response(json_encode($response));
    }

}
