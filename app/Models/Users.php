<?php

namespace App\Models;

use App\Models\BaseModel;

class Users extends BaseModel
{
    # global variabless 
    protected $table      = 'users';
    protected $primaryKey = 'userId';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['userId','firstname','lastname','phonenumber', 'email'];

    
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;  
}