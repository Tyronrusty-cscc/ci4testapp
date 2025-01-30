<?php
use PHPUnit\Framework\TestCase;
use App\Models\UserModel;

class UserModelTest extends TestCase
{
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock of the UserModel
        $this->model = $this->getMockBuilder(UserModel::class)
                            ->onlyMethods(['insert','first','save','find'])
                            ->addMethods(['where'])
                            ->getMock();
    }

    public function testUserInsertion()
    {

        $user = [
            'id' => 1,
            'firstname' => 'Jane',
            'lastname' => 'Doeh',
            'email'=>'janedoeh@gmail.com',
            'password' => 'initialpassword',
            'password_confirm' => 'initialpassword'
            
        ];

        $this->model->expects($this->once())
                    ->method('insert')
                    ->with($this->callback(function($input){
                        return $input['password']=== $input['password_confirm']&&
                        strlen($input['firstname']) >=3 &&
                        strlen($input['lastname']) >=3 &&
                        filter_var($input['email'], FILTER_VALIDATE_EMAIL) && 
                        strlen($input['password'])>=8;


                    }))
                    ->willReturn(true);
        
        $result = $this->model->insert($user);
        $this->assertTrue($result, 'the user has been inserted');
    }

    public function testFindingUserByEmail()
    {

        $user = [
            'id' => 1,
            'firstname' => 'Jane',
            'lastname' => 'Doeh',
            'email'=>'janedoeh@gmail.com',
            'password'=> password_hash('initialpassword',PASSWORD_DEFAULT),
        ];

        $this->model->expects($this->once())
                    ->method('where')
                    ->with('email','janedoeh@gmail.com')
                    ->willReturnSelf();
                    
        $this->model->expects($this->once())
                    ->method('first')
                    ->willReturn($user);
        
        $storedUser = $this->model->where('email','janedoeh@gmail.com')->first();
        $this->assertNotNull($storedUser,'find user by email');
    }

    public function testUpdatingUserPassword()
    {

        $user = [
            'id' => 1,
            'firstname' => 'Jane',
            'lastname' => 'Doeh',
            'email'=>'janedoeh@gmail.com',
            'password'=> password_hash('initialpassword',PASSWORD_DEFAULT),
        ];
        
        $updatedPassword =[
            'id'=> 1,
            'password' =>'newpassword'
        ];

        $this->model->expects($this->once())
                    ->method('save')
                    ->with($updatedPassword)
                    ->willReturn(true);
          
        // call the save method to update the passowrd
        $result = $this->model->save($updatedPassword);
        $this->assertTrue($result,'expect the save method to be successful');

        $updatedUser = $user;
        $updatedUser['password'] = password_hash('newpassword', PASSWORD_DEFAULT);

        $this->model->expects($this->once())
                    ->method('find')
                    ->with(1)
                    ->willReturn($updatedUser);
        
        $storedUser = $this->model->find($updatedPassword['id']);
        $this->assertTrue(password_verify('newpassword',$storedUser['password']),'expect the password to have been update and hashed correctly');
    }


    public function testBeforeInsertCallbackHashesPassword()
    {
        $userData = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@gmail.com',
            'password' => 'plainpassword',
        ];

        // Directly call the beforeInsert method to test password hashing
        $processedData = $this->invokeMethod($this->model, 'beforeInsert', [['data' => $userData]]);

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
