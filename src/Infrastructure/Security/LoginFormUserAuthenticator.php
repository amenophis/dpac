<?php

namespace App\Infrastructure\Security;

use App\Domain\Data\Model\Exception\UserNotFound;
use App\Domain\Data\Repository\Users;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class LoginFormUserAuthenticator extends AbstractAuthenticator
{
    public const LOGIN_ROUTE = 'login';

    private Users $users;
    private RouterInterface $router;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(Users $users, RouterInterface $router, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->users = $users;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request): ?bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST')
        ;
    }

    public function authenticate(Request $request): PassportInterface
    {


        try {
            $user = User::createFromUser($this->users->getByEmail($request->request->get('email')));

            return new Passport($user, new PasswordCredentials($request->request->get('password')), [
//                // and CSRF protection using a "csrf_token" field
//                new CsrfTokenBadge('loginform', $request->get('csrf_token')),
//
//                // and add support for upgrading the password hash
//                new PasswordUpgradeBadge($request->get('password'), $this->userRepository)
            ]);

        } catch (UserNotFound $e) {
            throw new CustomUserMessageAuthenticationException('Email could not be found.', [], 0, $e);
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('homepage'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }
}
