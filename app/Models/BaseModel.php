<?php

namespace App\Models;

use CodeIgniter\Entity\Cast\BooleanCast;
use CodeIgniter\Entity\Cast\TimestampCast;
use CodeIgniter\Model;

class BaseModel extends Model
{   

    /**
     * Return the properties of a resource object
     * this will return single resorces queries only 
     *@param $id
     *
     * @return mixed
     */
    public function show($id = null):array
    {
        //if parameter is null show all , if populated check the id 
        // take mixed for our convinience 
        if(is_integer($id)){
            #use this to get users, and priKeys of tables {must return mixed }
            $result = $this->where($this->primaryKey,$id)->find();
        }
        elseif (is_array($id)) {
            # use this to get parkages,transactions, 
            $result = $this->where($id)->find(); // making sure array only reach here
        }
        elseif (is_String($id) && !empty($id)) {
            # login functionality id the email 
            $result = $this->find($id); 
        }
        else{
            $result = gettype($id);
        }
        # check for empty arrays 

        return empty($result) ? "array is empty " :  $result ;

    }

    /**
     * this will return multiple resorces queries only 
     *@param array $id
     *
     * @return mixed
     
    public function show(array $id = null):mixed
    {
        //if parameter is null show all , if populated check the id 
        // take 
        if(isset($id)){
            $this->find($id);
        }

    }*/

    /**
     * Return a new resource object, with default properties
     * 
     * adds a record to the table
     * @param array $newRecord
     *
     * @return bool
     */
    public function new(array $newRecord)
    {
        # insert a single record to DB 
        # TODO: allow inser of multiple values per requirement of other classes
        return $this->insert($newRecord,true);
    }

    /**
     * update existing data in the table
     * @param int $id this should be priKey
     * @param array $dataToUpdate a key must be similar to the column to be affected
     *
     * @return mixed
     */
    public function change(int $id = null, array $dataToUpdate)
    {
       return $this->update($id,$dataToUpdate);
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