<?php


namespace UserLoginService\tests\Double;

use Exception;
use UserLoginService\Application\SessionManager;

class MockSessionManager implements  SessionManager{

    private int $times = 0;
    private int $expectedTimes;
    private string $response;
    private string $argument;
    private string $expectedArgument;

    public function getSessions(): int
    {
    }

    public function login(string $userName, string $password): bool
    {
    }

    public function logout(string $getUserName): void
    {
        // TODO: Implement logout() method.
    }

    public function VerifylogoutCalls(int $int):bool{
        //TODO
    }

    public function secureLogin(string $getUserName)
    {
        $this->argument = $getUserName;
        $this->times++;

        throw new Exception($this->response);
    }

    public function times(int $times){
        $this->expectedTimes = $times;
    }

    public function withArguments(string $argument){
        $this->expectedArgument = $argument;
    }

    public function andThrowException(string $errorMessage){
        $this->response = $errorMessage;
    }

    public function verifyValid():bool
    {
        return $this->times == $this->expectedTimes && $this->argument === $this->expectedArgument;
    }
}