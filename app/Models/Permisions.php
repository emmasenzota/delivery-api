<?php

namespace App\Models;

use App\Models\BaseModel;

class Permisions extends BaseModel
{

    # global variabless 
    protected $table      = 'permissions';
    protected $primaryKey = 'permissionId';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['permissionId','userId','role','password'];

    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted_at';
    

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

 
}