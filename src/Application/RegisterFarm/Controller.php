<?php

declare(strict_types=1);

namespace App\Application\RegisterFarm;

use App\Domain\UseCase\AUserWantsToRegisterANewFarm;
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
     * @Route("/register/farm", methods={"GET", "POST"}, name="register_farm")
     */
    public function register(Request $request): Response
    {
        $form = $this->createForm(Form::class, new FormDto());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FormDto $formData */
            $formData = $form->getData();

            $input = new AUserWantsToRegisterANewFarm\Input($formData->firstname, $formData->lastname, $formData->email, $formData->farmName);
            $this->useCaseBus->dispatch($input);

            return $this->redirectToRoute('register_farm_success');
        }

        return $this->render('app/register_farm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
