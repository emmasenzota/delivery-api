<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestTrait;

class Auth extends ResourceController
{
    # setting up ResponceTrait 
    use RequestTrait;

    #global variables 
    public $inputJsonData;
    public $succesResponce;
    public $generalErrors;
    public $customErrors;
    public $validation;

    /**
     * __constructor()
     * initialize needed libraries like ( forms, urls , json, js, validation)
     */
    public function __construct()
    {
        #start with forms libraries 
        helper(['form','url']);
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        return $this->respond("nothig");
    }

    /**
     * works with signin mechanisim
     * 
     * takes validated json object form dataValidation()
     * read from DB through models
     */
    public function signin()
    {
        $this->inputJsonData = $this->request->getVar();








        # just show it works 
        if(isset($this->inputJsonData)){
            $res = [
                'flag' => 'sucess',
                'message' => 'data  input is populated'
            ];
        }else{
            $res = [
                'flag' => 'failure',
                'message' => 'data  input is not populated'
            ];
        }
        return $this->respond($res);
    }

    /**
     * works with create mechanisim
     * 
     * takes validated json from dataValidation()
     * write to DB through models
     * @return bool
     */
    public function create()
    {
        $data = $this->request->getVar();
        $res = $this->dataValidation($data,'signup');

        return $this->respond($res);
    }

    /**
     * signout() invalidate session 
     * 
     * @param $userSession, $userId
     * 
     * saves timeout, pages visited and other analytics
     * 
     * @return bool true when succesful  
     */
    public function signout(int $userId = null, $UserSession)
    {
        # code...
    }

    # validation methods 
    /**
     * @method dataValidation(mixed $data)
     * 
     * clean unwanted data, empty strings, and special characters
     * @param $data have form data 
     * @param $form have form name 
     * 
     * @return mixed $cleanFormdata 
     */
    protected function dataValidation( $data,$form):array 
    {
        # switch for appropriate validation
        switch($form){
            case 'signup' : # set rules for signup validation

                if($this->validation->run($data , 'signup')){
                    return $data;
                }
                else{
                    return array('flag' => 'failure',
                                 'msg' => 'failure to validate');
                }


                break;
            case 'signin': # rules for signin validation

                break;
        }
    }
}
