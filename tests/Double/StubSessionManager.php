<?php


namespace UserLoginService\tests\Double;

use UserLoginService\Application\SessionManager;

class StubSessionManager implements SessionManager
{

    public function login(string $userName, string $password): bool
    {
        //Imaginad que esto en realidad realiza una llamada al API de Facebook
        //TODO
    }

    public function getSessions(): int
    {
        //Imaginad que esto en realidad realiza una llamada al API de Facebook
        return 2;
    }

    public function logout(string $getUserName):string{
        //TODO
    }
}