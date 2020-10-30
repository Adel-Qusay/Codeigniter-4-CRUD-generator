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

    /**
     * استخراج أعمدة الجدول.
     */

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

    /**
     * إدخال عمود إلى الجدول.
     */
    public function add(array $data)
    {   
        return $this->db->table($this->table)
            ->insert($data);
    }	
	
    /**
     * تحديث عمود في الجدول.
     */
    public function edit(int $id, array $data)
    {
        return $this->db->table($this->table)
            ->where([$this->primaryKey => $id])
            ->update($data);
    }
	
    /**
     * تحديث عمود في الجدول.
     */
    public function editWhere(array $where, array $data)
    {
        return $this->db->table($this->table)
            ->where($where)
            ->update($data);
    }	
	
    /**
     * حذف عمود من الجدول.
     */
    public function remove(int $id)
    {
        return $this->db->table($this->table)
			->where($this->primaryKey, $id)
		    ->delete();
    }
	
    /**
     * حذف عمود من الجدول.
     */	
    public function removeWhere(array $where)
    {
        return $this->db->table($this->table)
            ->where($where)
		    ->delete();
    }
	
    /**
     * مسح الجدول.
     */
    public function trash()
    {
        return $this->db->table($this->table)
		    ->truncate();
    }

    /**
     * العدد الكلي للأعمدة.
     */
    public function countAll()
    {
        return $this->db->table($this->table)
            ->countAll();
    }
		
}