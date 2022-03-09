<?php

namespace UserLoginService\Application;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\Infrastructure;

class UserLoginService
{
    const LOGIN_CORRECTO = "Login correcto";
    const LOGIN_INCORRECTO = "Login incorrecto";
    const USUARIO_NO_LOGEADO = "Usuario no logeado";
    const OK = "OK";
    private array $loggedUsers = [];
    private SessionManager $sessionManager;

    //se pasa dependencia por constructor
    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function manualLogin(User $user): string
    {
        if(!empty($user->getUserName())){
            array_push($this->loggedUsers,$user->getUserName());
            return "user logged";
        }
        return "error";
    }

    public function countExternalsSession():int
    {
        return  $this->sessionManager->getSessions();
    }

    public function login(string $username, string $password):string{
        if($this->sessionManager->login($username,$password)) {
            $user = new User($username,$password);
            array_push($this->loggedUsers,$user->getUserName());
            return self::LOGIN_CORRECTO;
        }else{
            return self::LOGIN_INCORRECTO;
        }
    }

    public function logout(User $user,int $numberOfCalls):string{
        if(in_array($user->getUserName(),$this->loggedUsers)){
            $this->sessionManager->logout($user->getUserName());
            if($this->sessionManager->VerifylogoutCalls($numberOfCalls)) {
                return self::OK;
            }
        }
        return self::USUARIO_NO_LOGEADO;
    }





}