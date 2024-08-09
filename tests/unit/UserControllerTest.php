<?php

namespace Tests\App\Controllers;


use App\Controllers\Users;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Config\Services;

class UserControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        // Start the session manually
        $this->mockSession();
    }



    public function testRegisterSuccess()
    {
        // Set up mock POST data with valid inputs
        $postData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirm' => 'password123',
        ];

        // Create a mock request with the POST data
        $result = $this->withRequest($this->createRequest($postData))
                       ->controller(Users::class)
                       ->execute('register');

        // Check for a successful registration
        $this->assertTrue($result->isOK(), 'Registration did not succeed as expected.');
        $this->assertTrue(session()->has('success'), 'Success message not found in session.');
        $this->assertEquals('Successful Registration', session()->get('success'), 'Unexpected success message.');
    }

    private function createRequest(array $postData)
    {
        $request = Services::request();
        $request->setMethod('post');
        $request->setGlobal('post', $postData);
        return $request;
    }

    protected function mockSession()
    {
        $_SESSION = [];
        Services::injectMock('session', \Config\Services::session());
        Services::session()->start();
    }
}
