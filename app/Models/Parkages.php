<?php

namespace App\Models;

use App\Models\BaseModel;

class Parkages extends BaseModel
{
    # start with global variables 
    public $packageId;
    public $senderId;
    public $receiverId;         # this comes from users table 
    public $fromid;             # this comes from Location tables 
    public $toId;               # from Location tables 
    public $senderTrackId;      # parkage tables generated must be unique 
    public $receiverTrackId;    # parkage tables generated must be unique
    
    # now the constructor -- keep empty for now
    public function __construct(int $id = null)
    {
        # code...
    }
}