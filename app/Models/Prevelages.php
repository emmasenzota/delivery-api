<?php

namespace App\Models;

use App\Models\BaseModel;

class Prevelages extends BaseModel
{
    # global variables 
    protected $prevelagesId; 
    public $userId;             # foreign key from users table
    public $packageId;          # from packages table
    public $profile;            # all users to their profiles filter btn admins and users 
                                # also prohibits admins to acces user sensitive data 
    
    # constructor
     public function __construct(int $id = null) # all who acces this class must be assignies an id ( user id else kick out of the system)
     {
         # code...
     }                             


    
}