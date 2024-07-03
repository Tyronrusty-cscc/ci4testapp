<?php
namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Models\EmployeeModel;
use config\Services;


Class EmployeeControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected $DBGroup = 'tests';

    public function testIndex()
    {
        // Mock the EmployeeModel
        $mockEmployeeModel = $this->getMockBuilder(EmployeeModel::class)
                                  ->onlyMethods(['orderBy'])
                                  ->getMock();
        
        // Set up the mock to return self for orderBy method
        $mockEmployeeModel->method('orderBy')
                          ->willReturnSelf();

        // Set up the mock to return a predefined array for findAll method
        $mockEmployeeModel->method('findAll')
                          ->willReturn([
                              [
                                  'id' => 1,
                                  'emp_code' => 'E001',
                                  'emp_fname' => 'John',
                                  'emp_lname' => 'Doe',
                                  'emp_email' => 'john@example.com',
                                  'emp_phone' => '1234567890',
                                  'password' => 'hashed_password'
                              ],
                              [
                                  'id' => 2,
                                  'emp_code' => 'E002',
                                  'emp_fname' => 'Jane',
                                  'emp_lname' => 'Doe',
                                  'emp_email' => 'jane@example.com',
                                  'emp_phone' => '0987654321',
                                  'password' => 'hashed_password'
                              ]
                          ]);

        // Inject the mock into the service container
        Services::injectMock('models', [
            'employeemodel' => $mockEmployeeModel
        ]);

        // Call the controller method
        $result = $this->withURI('http://localhost/employee')
                       ->controller(Employee::class)
                       ->execute('index');

        // Assert the response status is 200 OK
        $result->assertStatus(200);

        // Assert that the views are loaded with the expected data
        $result->assertSee('John');
        $result->assertSee('Jane');
    }


}