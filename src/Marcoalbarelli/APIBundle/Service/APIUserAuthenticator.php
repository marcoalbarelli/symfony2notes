<?php


namespace Marcoalbarelli\APIBundle\Service;


use Firebase\JWT\JWT;
use Marcoalbarelli\APIBundle\Constants;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class APIUserAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var APIUserProviderInterface $userProvider
     */
    private $userProvider;

    /**
     * @var JWTChecker $jwtCheckerService
     */
    private $jwtCheckerService;

    public function __construct(APIUserProviderInterface $userProvider, JWTChecker $jwtCheckerService){
        $this->userProvider = $userProvider;
        $this->jwtCheckerService = $jwtCheckerService;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {

    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        // TODO: Implement supportsToken() method.
    }

    public function createToken(Request $request, $providerKey)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $authorizationHeader = explode(' ',$authorizationHeader);
        if(count($authorizationHeader)!=2){
            throw new BadCredentialsException('Invalid Authorization Header');
        }
        if($authorizationHeader[0] !== "Bearer"){
            throw new BadCredentialsException('Invalid Authorization Header');
        }
        $encodedJWT = $authorizationHeader[1];
        $apiKeyName = Constants::JWT_APIKEY_PARAMETER_NAME;
        $jwt = $this->jwtCheckerService->decodeToken($encodedJWT);
        if( !isset($jwt->$apiKeyName)){
            throw new BadCredentialsException('Invalid JWT');
        }

        $user = $this->userProvider->findUserByAPIKey($jwt->$apiKeyName);

        $token = new PreAuthenticatedToken($user,$encodedJWT,$providerKey);
        return $token;
    }

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response('fail',401);
        // TODO: Implement onAuthenticationFailure() method.
    }


}