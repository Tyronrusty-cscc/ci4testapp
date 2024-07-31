<?php

namespace Tests\App\Models;

use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class UserModelTest extends CIUnitTestCase
{
 private $userModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userModel = new UserModel();
    }

    public function testBeforeInsertCallbackHashesPassword()
    {
        $userData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'plainpassword',
        ];

        // Directly call the beforeInsert method to test password hashing
        $processedData = $this->invokeMethod($this->userModel, 'beforeInsert', [['data' => $userData]]);

        // Assertions
        $this->assertNotEquals('plainpassword', $processedData['data']['password']);
        $this->assertTrue(password_verify('plainpassword', $processedData['data']['password']));
    }

    protected function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
