<?php

namespace App\Models;

use App\Models\BaseModel;

class Users extends BaseModel
{
    # global variabless 
    public $userId;
    public $fitstName;
    public $lastName;
    protected $phoneNumber;
    protected $email;


    # constrictor 
    public function __construct(int $id = null) # only use without id if for logging in and checking uniqueness
    {
        # code...
    }
}