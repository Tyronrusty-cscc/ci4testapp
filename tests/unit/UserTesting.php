<?php
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserModel;
use App\Controllers\Users;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use Config\App;
use Config\Services;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use PHPUnit\Framework\MockObject\MockObject;
    
    class UserTesting extends CIUnitTestCase {
        use FeatureTestTrait, DatabaseTestTrait;
    
        protected $refresh = true;  // Automatically refresh the database after each test method
        private $userModelMock;

    protected function setUp():void
    {
        parent::setUp();
        $this->userModelMock = $this->createMock(\App\Models\UserModel::class);

    }
    
        /**
         * Test successful registration.
         */
    public function testSuccessfulRegistration() {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirm' => 'password123',
        ];

        // Set up the mock to expect a call to `save` and return true
        $this->userModelMock->expects($this->once())
                            ->method('save')
                            ->with($this->callback(function($arg) use ($data) {
                                // You can add checks here to ensure data is being passed correctly
                                return $arg['firstname'] === $data['firstname']
                                    && $arg['email'] === $data['email'];
                            }))
                            ->willReturn(true);

        // Inject the mock model into the controller
        $usersController = new Users($this->userModelMock);

        // Simulate a POST request
        $this->withRequest($this->request->withMethod('post')->withGlobal('post', $data))
             ->controller($usersController)
             ->execute('store');

        // Check the session flash data
        $this->assertTrue(session()->has('success'));
        $this->assertEquals('Successful Registration', session()->get('success'));

        }
    }