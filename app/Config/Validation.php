<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $signup = [
        'name'  =>  'required|alpha',
        'phone' =>  'required|min_length[10]|max_length[12]|numeric',
        'email' =>  'required|valid_email|is_unique[users.email]'
    ];

    public $signin = [
        'phone'     =>  'required|min_length[10]|max_length[12]|numeric',
        'email'     =>  'required|valid_email|is_unique[users.email]',
        'password'  =>  'required'
    ];
}
