<?php
namespace App\Controllers;
use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class Employee extends Controller 
{

    public function index(){
        $data = [];
        helper(['form']);

        $emplModel = new EmployeeModel();
        $returnData['employee'] = $emplModel->orderBy('id','DESC')->findAll();

        echo view('templates/header', $data);
        echo view('employee/listing', $returnData);
        echo view('templates/footer');


    }

    public function add(){
        $data = [];
        helper(['form']);

        $session = session();
        $session->setFlashdata('success', 'Successful Registration');
       
        echo view('templates/header', $data);
        echo view('employee/add');
		echo view('templates/footer');
    }

    public function save(){
        $data = [];
        helper(['form']);

        $emplModel = new EmployeeModel();
        $insertData =[
            'emp_code'=> $this->request->getVar('emp_code'),
            'emp_fname'=> $this->request->getVar('emp_fname'),
            'emp_lname'=> $this->request->getVar('emp_lname'),
            'emp_email'=> $this->request->getVar('emp_email'),
            'emp_phone'=> $this->request->getVar('emp_phone'),
            'emp_phone'=> $this->request->getVar('emp_phone'),
        ];
        $emplModel->insert($insertData);

        echo view('templates/header', $data);
        return $this->response->redirect(site_url('/employee'));
        echo view('templates/footer');

    }

    public function delete($id = null){
        $data = [];
        helper(['form']);

        $emplModel = new EmployeeModel();
        $emplModel->where('id',$id)->delete($id);

        echo view('templates/header', $data);
        return $this->response->redirect(site_url('/employee'));
        echo view('templates/footer');

    }

    public function edit($id = null){
    
        helper(['form']);
        $data["id"]=$id;
        $emplModel = new EmployeeModel();
        $data['employee'] = $emplModel->where('id', $id)->first();

        echo view('templates/header', $data);
        return view('employee/edit');
        echo view('templates/footer');

    }
    public function update($id){
        $data = [];
        helper(['form']);
    
        $emplModel = new EmployeeModel();        
        $updateData = [
            'emp_code'=> $this->request->getVar('emp_code'),
            'emp_fname'=> $this->request->getVar('emp_fname'),
            'emp_lname'=> $this->request->getVar('emp_lname'),
            'emp_email'=> $this->request->getVar('emp_email'),
            'emp_phone'=> $this->request->getVar('emp_phone'),
        ];
        $emplModel->update($id,$updateData);

        echo view('templates/header', $data);
        return $this->response->redirect(site_url('/employee'));
        echo view('templates/footer');

}
}
