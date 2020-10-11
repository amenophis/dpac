<?php

declare(strict_types=1);

namespace App\Application\Supplier\RegisterSuccess;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    /**
     * @Route("/register/supplier/success", name="register_supplier_success")
     */
    public function registerSuccess(): Response
    {
        return $this->render('supplier/register_success.html.twig');
    }
}
