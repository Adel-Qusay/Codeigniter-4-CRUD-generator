<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class @@@uModelName@@@ extends Model {
    
	protected $table = '@@@table@@@';
	protected $primaryKey = '@@@primaryKey@@@';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = [@@@allowedFields@@@];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}