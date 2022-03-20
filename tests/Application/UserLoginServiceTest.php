<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use Mockery\Exception;
use PHPUnit\Framework\TestCase;
use UserLoginService\Application\SessionManager;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Tests\Double\SpySessionManager;
use UserLoginService\Tests\Double\StubSessionManager;
use UserLoginService\Tests\Double\DummySessionManager;
use UserLoginService\Tests\Double\FakeSessionManager;
use UserLoginService\Tests\Double\MockSessionManager;

final class UserLoginServiceTest extends TestCase
{

    /**
     * @test
     */
    public function userIsLoggedInManual()
    {
        $userLoginService=  new UserLoginService(new DummySessionManager());

        $user = new User("Kelly","wakasa");

        $this->assertEquals("user logged", $userLoginService->manualLogin($user));
    }

    /**
     * @test
     */
    public function loggedUsers()
    {
        $userLoginService=  new UserLoginService(new DummySessionManager());

        $user = new User("Alex","1234");

        $this->assertEquals("user logged", $userLoginService->manualLogin($user));
    }

    /**
     * @test
     */
    public function countExternalsSession()
    {

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
        $user = new User("Asta","Yuno");
        $sessionManager = new SpySessionManager();
        $userLoginService=  new UserLoginService($sessionManager);

        $userLoginService->manualLogin($user);

        $this->assertEquals( "OK", $userLoginService->logout($user,1));
    }

    /**
     * @test
     **/
    public function UserNotSecurelyLoggedInIfUserNotExistsInExternalService()
    {
        $user = new User('Asta', 'Yuno');
        $sessionManager = new MockSessionManager();
        $userLoginService = new UserLoginService($sessionManager);

        $sessionManager->times(1); //increment calls in 1
        $sessionManager->withArguments('Asta');  //set expected argument Asta
        $sessionManager->andThrowException('User does not exist');

        $secureLoginResponse = $userLoginService->secureLogin($user);

        //if stuff that we want to happen actually happened
        $this->assertTrue($sessionManager->verifyValid());
        //if the response is what we expected
        $this->assertEquals('User does not exist', $secureLoginResponse);
    }

    /**
     * @test
     **/
    public function UserNotSecurelyLoggedInIfCredentialsIncorrect()
    {
        $user = new User('Asta', 'Yuno');
        $sesionManager = new MockSessionManager();
        $userLoginService = new UserLoginService($sesionManager);

        $sesionManager->times(1);
        $sesionManager->withArguments('Asta');
        $sesionManager->andThrowException('User incorrect credentials');

        $secureLoginResponse = $userLoginService->secureLogin($user);

        $this->assertTrue($sesionManager->verifyValid());
        $this->assertEquals('User incorrect credentials', $secureLoginResponse);
    }

    /**
     * @test
     **/
    public function UserNotSecurelyLoggedInIfExternalServiceNotResponding()
    {
        $user = new User('Asta', 'Yuno');
        $sesionManager = new MockSessionManager();
        $userLoginService = new UserLoginService($sesionManager);

        $sesionManager->times(1);
        $sesionManager->withArguments('Asta');
        $sesionManager->andThrowException('Service not responding');

        $secureLoginResponse = $userLoginService->secureLogin($user);

        $this->assertTrue($sesionManager->verifyValid());
        $this->assertEquals('Service not responding', $secureLoginResponse);
    }

    /**
     * @test
     **/
    public function userIsLoggedInManualMockery()
    {
        $user = new User("Kelly","Wakasa");

        $sessionManager = \Mockery::mock(SessionManager::class);
        $userLoginService=  new UserLoginService($sessionManager);

        $this->assertEquals("user logged", $userLoginService->manualLogin($user));
    }

    /*
    /**
     * @test
     **/
    /*
    public function logOutSuccessMockery()
    {
        $user = new User("Asta","Yuno");
        $sessionManager = \Mockery::spy(SessionManager::class);
        $userLoginService=  new UserLoginService($sessionManager);



        $sessionManager->shouldReceive('logout')
                        ->once();
        //\Mockery::close();

        $userLoginService->manualLogin($user);

        $this->assertEquals( "OK", $userLoginService->logout($user,1));
    }*/

    /**
     * @test
     **/
        public function UserNotSecurelyLoggedInIfUserNotExistsInExternalServiceMockery()
        {
            $user = new User('Asta', 'Yuno');
            $sessionManager = \Mockery::mock(SessionManager::class);
            $sessionManager
              ->expects('secureLogin')
              ->with('Asta')
              ->once() // times(1) is the same
              ->andThrow(new Exception('User does not exist'));

            $userLoginService = new UserLoginService($sessionManager);

            $this->assertEquals('User does not exist', $userLoginService->secureLogin($user));

        }

    /**
     * @test
     **/
    public function UserNotSecurelyLoggedInIfUserNotExistsInExternalServiceWithMockery()
    {
        $user = new User('Asta', 'Yuno');
        $sessionManager = \Mockery::mock(SessionManager::class);
        $sessionManager
            ->shouldReceive('secureLogin')
           ->times(1) //once is the same
           ->with('Asta')
            ->andThrow(new \Exception('User does not exist'));

        $userLoginService = new UserLoginService($sessionManager);

        $this->assertEquals('User does not exist', $userLoginService->secureLogin($user));
    }

}
