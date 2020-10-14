<?php

declare(strict_types=1);

namespace App\Application\RegisterFarmSuccess;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/register/farm/success", methods={"GET"}, name="register_farm_success")
     */
    public function registerSuccess(): Response
    {
        return $this->render('app/register_farm_success.html.twig');
    }
}
