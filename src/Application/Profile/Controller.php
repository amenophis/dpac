<?php

declare(strict_types=1);

namespace App\Application\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/profile", methods={"GET"}, name="profile")
     */
    public function __invoke(): Response
    {
        return $this->render('app/profile.html.twig');
    }
}
