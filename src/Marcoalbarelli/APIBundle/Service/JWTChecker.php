<?php


namespace Marcoalbarelli\APIBundle\Service;


use Firebase\JWT\JWT;

class JWTChecker
{

    /**
     * @var string $secret The secret for this deployment (from parameters.yml)
     */
    private $secret;

    /**
     * @var array $algs The algs for JWT signing (from parameters.yml)
     */
    private $algs;

    public function __construct($secret,$algs){
        $this->secret = $secret;
        $this->algs = $algs;
    }

    public function decodeToken($token){
        try{
            $decodedToken = JWT::decode($token,$this->secret,$this->algs);
            return true;
        } catch (\Exception $e){
            return false;
        }
    }
}