<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\@@@uModelName@@@;

class @@@uControlerName@@@ extends BaseController
{
	
    protected $@@@modelName@@@;
    protected $validation;
	
	public function __construct()
	{
	    $this->@@@modelName@@@ = new @@@uModelName@@@();
       	$this->validation =  \Config\Services::validation();	
	}
	
	public function index()
	{

	    $data = [
                'controller'    	=> '@@@controlerName@@@',
                'title'     		=> '@@@crudTitle@@@'				
			];
		
		return view('@@@controlerName@@@', $data);
			
	}

	public function getAll()
	{
 		$response = array();		
		
	    $data['data'] = array();
 
		$result = $this->@@@modelName@@@->get('@@@ciSelect@@@');        
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit('. $value->@@@primaryKey@@@ .')"><i class="fa fa-edit"></i></button>';
			$ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove('. $value->@@@primaryKey@@@ .')"><i class="fa fa-trash"></i></button>';
			$ops .= '</div>';
			
			$data['data'][$key] = array(
@@@ciDataTable@@@
				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('@@@primaryKey@@@');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->@@@modelName@@@->get('*', ['@@@primaryKey@@@' => $id]);

			return $this->response->setJSON($data);	
				
		} else {
			
			throw new \CodeIgniter\Exceptions\PageNotFoundException();

		}	
		
	}	
	
	public function add()
	{

        $response = array();

@@@ciFields@@@

        $this->validation->setRules([
@@@ciValidation@@@
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->@@@modelName@@@->add($fields)) {
												
                $response['success'] = true;
                $response['messages'] = 'تم إدراج البيانات بنجاح';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'خطأ في عملية الإدراج !';
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function edit()
	{

        $response = array();
		
@@@ciFields@@@

        $this->validation->setRules([
@@@ciValidation@@@
        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->@@@modelName@@@->edit($fields['@@@primaryKey@@@'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = 'تم تحديث البيانات بنجاح';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'خطأ في عملية التحديث !';
				
            }
        }
		
        return $this->response->setJSON($response);
		
	}
	
	public function remove()
	{
		$response = array();
		
		$id = $this->request->getPost('@@@primaryKey@@@');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->@@@modelName@@@->remove($id)) {
								
				$response['success'] = true;
				$response['messages'] = 'تمت عملية الحذف بنجاح';	
				
			} else {
				
				$response['success'] = false;
				$response['messages'] = 'خطأ في عملية الحذف !';
				
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
		
}	