<?php

namespace Tests\App\Models;

use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Config\Services;
use App\Controllers\Users;

class UserModelTester extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

 
 public function testRegister()
 {
    $body =[
        'firstname' =>'john',
        'lastname' =>'doe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password123',
        'password_confirm' => 'password123',
    ];

    $result = $this->withBody(http_build_query($body))
                   ->withURI('https://webdev.cscc.edu/trtest3/register')
                   ->controller(\App\Controller\Users::class)
                   ->execute('register');
    $this->assertTrue($result->isOK());
    $this->assertTrue($result->isRedirect());
    $this->assertSessionHas('success','Sucessful Registration');
    
 }

}