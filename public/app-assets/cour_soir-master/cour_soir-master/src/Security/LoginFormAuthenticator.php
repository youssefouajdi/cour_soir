<?php


namespace App\Security;


use App\Controller\SecurityController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    private $userRepository;
    private $urlGenerator;
    public function __construct(UserRepository $userRepository,UrlGeneratorInterface $urlGenerator)
    {
        $this->userRepository=$userRepository;
        $this->urlGenerator=$urlGenerator;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_login'
        && $request->isMethod('POST');
    }

    public function authenticate(Request $request): PassportInterface
    {
        // find a user based on an "email" form field
        $user = $this->userRepository->findOneByEmail($request->request->get('email'));
        $request->getSession()->set(SecurityController::LAST_EMAIL,$request->request->get('email'));
        if (!$user) {
            throw new CustomUserMessageAuthenticationException('email not found');
        }

        return new Passport($user, new PasswordCredentials($request->request->get('password')), [
            new CsrfTokenBadge('login_form', $request->request->get('csrf_token')),
            new RememberMeBadge
        ]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $request->getSession()->remove(SecurityController::LAST_EMAIL);
        return new RedirectResponse($this->urlGenerator->generate('professeur_index'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->getFlashBag()->add('error','donne invalide');
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}