<?php

declare(strict_types=1);

namespace App\Application\SignupUserWithFarm;

use App\Domain\UseCase\AVisitorWantsToSignupAndRegisterANewFarm;
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
     * @Route("/signup/farm", methods={"GET", "POST"}, name="signup_farm")
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(Form::class, new FormDto());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FormDto $formData */
            $formData = $form->getData();

            $input = new AVisitorWantsToSignupAndRegisterANewFarm\Input($formData->firstname, $formData->lastname, $formData->email, $formData->farmName);
            $this->useCaseBus->dispatch($input);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('app/signup_user_with_farm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
