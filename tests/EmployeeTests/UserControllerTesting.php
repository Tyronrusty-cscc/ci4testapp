<?php
namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

Class UserControllerTesting extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function testIndex(){
        $result = $this->withUri('https://webdev.cscc.edu/trtest3/register')
                      ->controller(\App\Controllers\Users::class)
                      ->execute('register');

        $this->assertTrue($result->isOk());
        $this->assertStringContainsString('<form',$result->getBody());
    }

    // public function testingRegistration()
    // {
    //     $result = $this->withUri('https://webdev.cscc.edu/trtest3/register')
    //                    ->withMethod('post')
    //                    ->withBody([
    //                     'firstname' => 'jo',
    //                     'lastname'=>'doe',
    //                     'email'=>'someEmail',
    //                     'password'=>'short',
    //                     'password_confirm'=>'different'
    //                    ])
    //                 ->controller(App\Controllers\Users::class)
    //                 ->execute('register');

    //     $this->assertTrue($result->isOk());
    //     $this->assertStringContainsString('The Email field must contain a valid email address.', $result->getBody());
    //     $this->assertStringContainsString('The password field must be at least 8 characters in length.', $result->getBody());
    //     $this->assertStringContainsString('The password Confirm field does not match the password field.', $result->getBody());



    // }

}