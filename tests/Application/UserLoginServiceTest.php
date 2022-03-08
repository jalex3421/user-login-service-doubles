<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Tests\Double\StubSessionManager;
use UserLoginService\Tests\Double\DummySessionManager;
use UserLoginService\Tests\Double\FakeSessionManager;
use UserLoginService\Tests\Double\SpySessionManager; //prueba que algo ha ocurrido !!

final class UserLoginServiceTest extends TestCase
{
    /**
     * @setUp
     */
    /*
    protected function setUp():void{
        parent::setUp();
        $this->userLoginService=  new UserLoginService();
    }
    */

    /**
     * @test
     */
    public function userIsLoggedInManual()
    {
        $userLoginService=  new UserLoginService(new DummySessionManager());

        $user = new User("Kelly");

        $this->assertEquals("user logged", $userLoginService->manualLogin($user));
    }

    /**
     * @test
     */
    public function loggedUsers()
    {
        $userLoginService=  new UserLoginService(new DummySessionManager());

        $user = new User("Alex");

        $this->assertEquals("user logged", $userLoginService->manualLogin($user));
    }

    /**
     * @test
     */
    public function countExternalsSession()
    {
        //stub
        $userLoginService=  new UserLoginService(new StubSessionManager());

        $this->assertEquals( 2, $userLoginService->countExternalsSession());
    }

    /**
     * @test
     */
    public function userIsLoggedInExternalService()
    {
        $userLoginService=  new UserLoginService(new FakeSessionManager());

        $this->assertEquals( "Login correcto", $userLoginService->login("Asta","Yuno"));
    }

    /**
     * @test
     */
    public function userIsNotLoggedInExternalService()
    {
        $userLoginService=  new UserLoginService(new FakeSessionManager());


        $this->assertEquals( "Login incorrecto", $userLoginService->login("Alex","777"));
    }

    /**
     * @test
     */
    public function logOutSuccess()
    {
        $userLoginService=  new UserLoginService(new DummySessionManager());

        $user = new User("Asta","Yuno");
        $userLoginService->manualLogin($user);

        $this->assertEquals( "OK", $userLoginService->logout($user));
    }

    /**
     * @test
     */
    public function userNotLoggedOutUserNotBeingLogged()
    {
        $userLoginService=  new UserLoginService(new DummySessionManager());
        $user= new User("Kelly","1234");
        $this->assertEquals( "Usuario no logeado", $userLoginService->logout($user));
    }

}
