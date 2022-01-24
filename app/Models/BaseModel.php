<?php

namespace App\Models;

use CodeIgniter\Entity\Cast\TimestampCast;
use CodeIgniter\Model;

class BaseModel extends Model
{
    
    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or change a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function change($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function remove($id = null )
    {
        # code...
    }
    
}