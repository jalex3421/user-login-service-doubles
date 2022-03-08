<?php
namespace UserLoginService\tests\Double;

use UserLoginService\Application\SessionManager;

class DummySessionManager  implements SessionManager
{
    public function login(string $userName, string $password): bool
    {
        //Imaginad que esto en realidad realiza una llamada al API de Facebook
        //TODO
    }

    public function getSessions(): int
    {
        //Imaginad que esto en realidad realiza una llamada al API de Facebook
        //TODO
    }

    public function logout(string $getUserName):string{

    }
}
