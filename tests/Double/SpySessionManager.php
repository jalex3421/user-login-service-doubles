<?php


namespace UserLoginService\tests\Double;

use UserLoginService\Application\SessionManager;
use function PHPUnit\Framework\throwException;

class SpySessionManager implements  SessionManager
{
    const INCORRECT_NUMBER_OF_FUNCTION_CALLS = "Incorrect number of function calls";
    private int $calls= 0;

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

    public function logout(string $getUserName):void{
        $this->calls+=1;
    }


    public function VerifylogoutCalls(int $int):bool
    {
        if($this->calls!==$int){
            throw new Exception(self::INCORRECT_NUMBER_OF_FUNCTION_CALLS);
        }
        else{
            return true;
        }
    }
}