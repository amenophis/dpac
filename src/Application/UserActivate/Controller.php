<?php

declare(strict_types=1);

namespace App\Application\UserActivate;

use App\Domain\UseCase\AUserWantsToActivateHisAccount;
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
     * @Route("/user/{userId}/verify-email/{activationToken}", methods={"GET", "POST"}, name="user_activate")
     */
    public function register(Request $request, string $userId, string $activationToken): Response
    {
        $form = $this->createForm(Form::class, new FormDto());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FormDto $formData */
            $formData = $form->getData();

            $input = new AUserWantsToActivateHisAccount\Input($userId, $activationToken, $formData->plainPassword);
            $this->useCaseBus->dispatch($input);

            $this->addFlash('success', 'Your user is activated !');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('app/activate_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
