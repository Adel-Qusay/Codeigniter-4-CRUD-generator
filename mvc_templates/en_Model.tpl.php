<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class @@@uModelName@@@ extends Model {
    
	protected $table = '@@@table@@@';
	protected $primaryKey = '@@@primaryKey@@@';
	protected $returnType = 'array';
	protected $useSoftDeletes = false;
	protected $allowedFields = [@@@allowedFields@@@];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    

    public function get(string $select = '*', array $where = null, string $order = 'ASC')
    {
	    if (is_null($where))
		{ 	
			return $this->db->table($this->table)
				->select($select)			
				->orderBy($this->primaryKey, $order)		
				->get()
				->getResult();	
		}
		else
		{
			return $this->db->table($this->table)
				->select($select)			
				->where($where)				
				->get()			
				->getRow();		
		}							
    }

    public function add(array $data)
    {   
        return $this->db->table($this->table)
            ->insert($data);
    }	
	
    public function edit(int $id, array $data)
    {
        return $this->db->table($this->table)
            ->where([$this->primaryKey => $id])
            ->update($data);
    }
	
    public function editWhere(array $where, array $data)
    {
        return $this->db->table($this->table)
            ->where($where)
            ->update($data);
    }	
	
    public function remove(int $id)
    {
        return $this->db->table($this->table)
			->where($this->primaryKey, $id)
		    ->delete();
    }
	
    public function trash()
    {
        return $this->db->table($this->table)
		    ->truncate();
    }

    public function countAll()
    {
        return $this->db->table($this->table)
            ->countAll();
    }		
}
