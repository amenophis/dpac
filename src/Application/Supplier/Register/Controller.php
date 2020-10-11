<?php

declare(strict_types=1);

namespace App\Application\Supplier\Register;

use App\Domain\UseCase\ASupplierWantsToRegister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    private MessageBusInterface $useCaseBus;

    public function __construct(MessageBusInterface $useCaseBus)
    {
        $this->useCaseBus = $useCaseBus;
    }

    /**
     * @Route("/register/supplier", name="register_supplier")
     */
    public function register(Request $request): Response
    {
        $form = $this->createForm(Form::class, new FormDto());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FormDto $supplierData */
            $supplierData = $form->getData();

            $input = new ASupplierWantsToRegister\Input($supplierData->name, $supplierData->email);
            $this->useCaseBus->dispatch($input);

            return $this->redirectToRoute('register_supplier_success');
        }

        return $this->render('supplier/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
