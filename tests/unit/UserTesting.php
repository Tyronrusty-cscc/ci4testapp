<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use App\Models\UserModel;
use App\Controllers\Users;

class UserTesting extends CIUnitTestCase
{
    use FeatureTestTrait;

    private $userModelMock;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $config = config('App');
        $config->baseURL ='https://webdev.cscc.edu/trtest3/register';
        // Mock the UserModel to avoid database interaction
        $this->userModelMock = $this->createMock(UserModel::class);
        $this->controller = new Users($this->userModelMock);

    }

   

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRegisterSuccess()
    {
        $formData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'validPassword123',
            'password_confirm' => 'validPassword123',
        ];

        // Proceed with your test case
        $result = $this->withHeaders([
            'Host' => 'webdev.cscc.edu'
        ])->post('/register', $formData);

        $this->assertTrue($result->isRedirect());
        $this->assertRedirectTo('/trtest3/');
        $this->assertSessionHas('success', 'Successful Registration');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRegisterFailure()
    {
        $formData = [
            'firstname' => 'Jo',
            'lastname' => 'D',
            'email' => 'notanemail',
            'password' => 'short',
            'password_confirm' => 'short123',
        ];

        // Proceed with your test case
        $result = $this->withHeaders([
            'Host' => 'webdev.cscc.edu'
        ])->post('/register', $formData);

        $this->assertFalse($result->isRedirect());
        $this->see('The email field must contain a valid email address.');
        $this->see('The password field must be at least 8 characters in length.');
    }
}
