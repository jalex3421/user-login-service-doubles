<?php


namespace UserLoginService\tests\Double;

use UserLoginService\Application\SessionManager;


class FakeSessionManager implements SessionManager
{
    private  $Users = "Asta";
    private  $Passwords = "Yuno";

    public function login(string $userName, string $password): bool
    {
        if(($userName == $this->Users) && ($password == $this->Passwords)){return true;}
        else{return false;}
    }

    public function getSessions(): int
    {
        //Imaginad que esto en realidad realiza una llamada al API de Facebook
        return 2;
    }

    public function logout(string $getUserName):void{
        //TODO
    }

    public function VerifylogoutCalls(int $int):bool
    {
        //TODO
    }
}