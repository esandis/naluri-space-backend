<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController
{
    /**
     * @Route("/", name="Homepage")
     */
    public function indexAction()
    {
        return new Response('API Only');
    }
}
