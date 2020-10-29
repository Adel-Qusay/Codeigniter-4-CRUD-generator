<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UsersModel;

class Users extends BaseController
{
	
    protected $usersModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->usersModel = new UsersModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function index()
	{

	    $data = [
                'controller'    	=> 'users',
                'title'     		=> 'Users'				
			];
		
		return view('users', $data);
			
	}

	public function getAll()
	{
 		$response = array();		
		
	    $data['data'] = array();
 
		$result = $this->usersModel->get('id, last_name, first_name, email, birthdate');        
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit('. $value->id .')"><i class="fa fa-edit"></i></button>';
			$ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove('. $value->id .')"><i class="fa fa-trash"></i></button>';
			$ops .= '</div>';
			
			$data['data'][$key] = array(
				$value->id,
				$value->last_name,
				$value->first_name,
				$value->email,
				$value->birthdate,

				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->usersModel->get('*', ['id' => $id]);

			return $this->response->setJSON($data);	
				
		} else {
			
			throw new \CodeIgniter\Router\Exceptions\RedirectException($route, 301);

		}	
		
	}	
	
	public function add()
	{

        $response = array();

        $fields['id'] = $this->request->getPost('id');
        $fields['last_name'] = $this->request->getPost('lastName');
        $fields['first_name'] = $this->request->getPost('firstName');
        $fields['email'] = $this->request->getPost('email');
        $fields['birthdate'] = $this->request->getPost('birthdate');


        $this->validation->setRules([
            'last_name' => ['label' => 'Surname', 'rules' => 'required|max_length[50]'],
            'first_name' => ['label' => 'name', 'rules' => 'required|max_length[50]'],
            'email' => ['label' => 'Email', 'rules' => 'permit_empty|max_length[100]'],
            'birthdate' => ['label' => 'Birth Date', 'rules' => 'required|valid_date'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->usersModel->add($fields)) {
												
                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Insertion error!';
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function edit()
	{

        $response = array();
		
        $fields['id'] = $this->request->getPost('id');
        $fields['last_name'] = $this->request->getPost('lastName');
        $fields['first_name'] = $this->request->getPost('firstName');
        $fields['email'] = $this->request->getPost('email');
        $fields['birthdate'] = $this->request->getPost('birthdate');


        $this->validation->setRules([
            'last_name' => ['label' => 'Surname', 'rules' => 'required|max_length[50]'],
            'first_name' => ['label' => 'name', 'rules' => 'required|max_length[50]'],
            'email' => ['label' => 'Email', 'rules' => 'permit_empty|max_length[100]'],
            'birthdate' => ['label' => 'Birth Date', 'rules' => 'required|valid_date'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->usersModel->edit($fields['id'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = 'Successfully updated';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Update error!';
				
            }
        }
		
        return $this->response->setJSON($response);
		
	}
	
	public function remove()
	{
		$response = array();
		
		$id = $this->request->getPost('id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Router\Exceptions\RedirectException($route, 301);
			
		} else {	
		
			if ($this->usersModel->remove($id)) {
								
				$response['success'] = true;
				$response['messages'] = 'Deletion succeeded';	
				
			} else {
				
				$response['success'] = false;
				$response['messages'] = 'Deletion error!';
				
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
		
}	