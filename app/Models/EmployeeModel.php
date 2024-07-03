<?php
namespace App\Models;
use CodeIgniter\Model;
class EmployeeModel extends Model
{
    protected $DBgroup = 'default';
    protected $table = 'employee';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDelete = false;
    protected $allowedFields = [
        'emp_code',
        'emp_fname',
        'emp_lname',
        'emp_email',
        'emp_phone',
        'password'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    /*validation rules*/
    protected $validationRules =[];
    protected $validationMessage =[];
    protected $skipValidation = false ;
    protected $cleanValidationRules = true;

    /* callbacks definition */
    protected $allowCallbacks = false;
    protected $beforeInsert =["beforeInsert"];

    protected function beforeInsert(array $params)
    {
        $params = $this->passwordHash($params);
        return $params;
    }
    protected function passwordHash(array $params)
    {
        if(isset($params['data']['password'])){
            $params['data']['password'] = password_hash($params['data']['password'],PASSWORD_DEFAULT);
        } return $params;
    }
}