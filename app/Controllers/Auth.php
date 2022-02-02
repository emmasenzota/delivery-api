<?php

namespace App\Controllers;

use App\Models\Users as ModelsUsers;
use App\Models\Permisions;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestTrait;
use CodeIgniter\Validation\Validation;

class Auth extends ResourceController
{
    # setting up ResponceTrait 
    use RequestTrait;
    use ResponseTrait;

    #global variables 
    public $inputJsonData;
    public $succesResponce;
    public $generalErrors;
    public $customErrors;
    public $validation;
    public $session;
    public $permision;

    /**
     * __constructor()
     * initialize needed libraries like ( forms, urls , json, js, validation)
     */
    public function __construct()
    {
        #start with forms libraries 
        helper(['form','url']);
        $this->validation   =   \Config\Services::validation();
        $this->session      =   \Config\Services::session();
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
        # call models 
        $user               =   new ModelsUsers();
        $this->permision    =   new Permisions();


        # feed input data 
        $this->inputJsonData = $this->request->getVar();

        $validData = $this->dataValidation($this->inputJsonData,'signin');

        #check if phone number or email available in Users table and return userId
        
        if(array_key_exists('phone',$validData)){
            $userArray =  $user->show(['phonenumber' => $validData['phone']]);
        }
        
        elseif (array_key_exists('email',$validData)) {
            $userArray =  $user->show(['email' => $validData['email']]);
        }
        
        else {
            return $this->respond($validData);
        }
        
        # use userId to match user password
        # use  password_verify() if true / false  to verify password 
       if(!empty($userArray)){
            $fromPermision = $this->permision->show(['userId' => $userArray[0]['userId']]);

            #get the hashed password and verify it
            if(password_verify($validData['password'], $fromPermision[0]['password'])){
                $responce = array('message' => 'Successful Loging in');
            } 
            else {
                $responce = array('message' => 'Failure Loging in',
                                    'error' => 'provide correct password');
            }
            return $this->respond($responce);
            
        }
        else {
            return $this->respond('User not found');
        }

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
        // calling user model 
        $user = new ModelsUsers();
        $data = $this->request->getVar();
        $res = $this->dataValidation($data,'signup');
        // traverse the $res array to make sere it match the colum names in database
        $nameArr = explode(" ", $res['name'], 2);
        extract($res);

        //recreate $res
        $res = array(
            'firstname'     => $nameArr[0],
            'lastname'      => $nameArr[1],
            'phonenumber'   => $phone,
            'email'         => $email
        );

        // add user to users table and return userId 
        $userResp = $user->new($res);

        # use $userResp to populate Permissions table with provided password
        # TODO: make sure u add verification by email or sms during registation 
        # for now just trust data given by the user

        #prep data array
        $permisionData = array(
            'userId'    =>  $userResp,
            'role'      =>  'customer',
            'password'  =>  \password_hash($pass,PASSWORD_BCRYPT)
        );

        $parmissionId = $this->permision->new($permisionData);

        return $this->respond($parmissionId); 
        #leave this responce for now but suposse to return message to notify succes
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
                #cleaning validation previous rules and errors 
                $this->validation->reset();

                #set rules here
                $signup = [
                    'name'  =>  'required|alpha_space',
                    'phone' =>  'required|min_length[10]|max_length[12]|numeric',
                    'email' =>  'required|valid_email|is_unique[users.email]',
                    'pass'  =>  'required'];

                $this->validation->setRules($signup); 
                if($this->validation->run($data)){
                    return $data;
                }
                else{
                    return array('flag' => 'failure',
                                 'msg' => 'failure to validate');
                }


                break;
            case 'signin': 
                    # rules for signin validations
                    $signinWithEmail = [
                        'email'     =>  ['rules' => 'required|valid_email',
                                        'errors' => 'fill valid email'],
                        'password'  =>  ['rules' => 'required', 'errors' => 'fill password']
                                         ];
                    
                    $signinWithPhone = [
                        'phone'     =>  ['rules' => 'required|min_length[10]|max_length[12]|numeric',
                                        'errors' => 'fill with valid phone number'],
                        'password'  =>  ['rules' => 'required', 'errors' => 'fill password']
                        ];    

                        if(array_key_exists('email',$data)){
                            return $this->checkSignin($signinWithEmail,$data);
                        }
                        elseif (array_key_exists('phone',$data)) {
                            return $this->checkSignin($signinWithPhone,$data);
                        }
                        else {
                            return array(
                                'flag' => 'failure ( no phone / email)',
                                'data' => $data,
                                'errors' => $this->validation->getErrors()
                            );
                        }
                
                break;
        }
    }

    # breaking unnessesary blocks in dataValidation()
    protected function checkSignin(?array $rules,array $data)       
    {
        #cleaning validation previous rules and errors 
        $this->validation->reset();

        #set rules here
        $this->validation->setRules($rules); 

        if($this->validation->run($data)){
            # it will be better to set a flag pass for readbility
            return $data;
        }
        else {
            return array(
                'flag' => 'failure',
                'data' => $data,
                'errors' => $this->validation->getErrors()
            );
        }
    }
}
