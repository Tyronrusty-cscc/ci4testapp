<?php
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserModel;
use App\Controllers\Users;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use Config\App;
use ReflectionClass;
class UserModelTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        helper(['form']);
    }

    public function testRegisterSuccess()
    {
            // Create a mock request
        $uri = new URI('http://example.com');
        $request = new IncomingRequest(new App(), $uri, null, new UserAgent());
        $request->setMethod('post');
        $request->setGlobal('post', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'validpassword',
            'password_confirm' => 'validpassword'
        ]);

        // Create a mock response
        $response = new Response(new App());

        // Mock the UserModel
        $mockUserModel = $this->createMock(UserModel::class);
        $mockUserModel->method('save')->willReturn(true);

        // Create the controller instance with the mocked UserModel
        $controller = new Users($mockUserModel);

        // Use reflection to set the protected request property
        $reflection = new ReflectionClass($controller);
        $requestProperty = $reflection->getProperty('request');
        $requestProperty->setAccessible(true);
        $requestProperty->setValue($controller, $request);

        // Use reflection to set the protected response property
        $responseProperty = $reflection->getProperty('response');
        $responseProperty->setAccessible(true);
        $responseProperty->setValue($controller, $response);

        // Call the register method and capture the result
        $result = $controller->register();

        // Log the POST data and validation errors
        log_message('debug', 'Request POST data: ' . print_r($request->getPost(), true));
        if (isset($controller->validator)) {
            log_message('debug', 'Validation errors: ' . print_r($controller->validator->getErrors(), true));
        }

        // Output the result during the test
        echo 'Register method result: ';
        print_r($result);

        // Debugging output to check where the flow breaks
        if ($result === null) {
            echo "Register method returned null. Check validation and logic flow.";
        } elseif ($result instanceof \CodeIgniter\HTTP\RedirectResponse) {
            echo "Register method succeeded.";
        } else {
            echo "Register method returned an unexpected type.";
        }

        // Assert that the result is not null (indicating that the validation passed and the method proceeded)
        $this->assertNotNull($result, 'Validation failed, method returned null.');
        // Assert that the result is a RedirectResponse
      //  $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $result);
      //  $this->assertEquals('/',$result->getHeaderLine('location'));
        }

}