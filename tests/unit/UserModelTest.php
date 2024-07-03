<?php

namespace Tests\Support\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\Fabricator;
use App\Models\UserModel;

class UserModelTest extends CIUnitTestCase
{
    protected $userModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userModel = new UserModel();
    }

    public function testInsertUser()
    {
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'password' => 'plainpassword',
        ];

        // Insert the user
        $this->userModel->insert($data);
        $user = $this->userModel->where('email', 'johndoe@gmail.com')->first();

        // Ensure the user is found
        $this->assertNotNull($user);
        
        // check the fields 
        $this->assertEquals('John',$user['firstName']);
        $this->assertEquals('Doe',$user['lastName']);
        $this->assertEquals('johndoe@gmail.com',$user['email']);
        

        // Ensure the password is hashed
        $this->assertTrue(password_verify('plainpassword', $user['password']));
    }

    public function testUpdateUser()
    {
        // Insert a user first
        $data = [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'janedoe@example.com',
            'password' => 'initialpassword',
        ];

        $this->userModel->insert($data);
        $user = $this->userModel->where('email', 'janedoe@example.com')->first();

        // Ensure the user is found
        $this->assertNotNull($user);

        // Update the user's password
        $updateData = [
            'id' => $user['id'],
            'password' => 'newpassword',
        ];
        $this->userModel->save($updateData);

        // Retrieve the updated user
        $updatedUser = $this->userModel->find($user['id']);

        // Ensure the password is hashed
        $this->assertTrue(password_verify('newpassword', $updatedUser['password']));
    }
}