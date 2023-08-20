<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
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
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    
    public $usersRules = [
        'userEmail' => [
            'rules' => 'required|valid_email|is_unique[users.userEmail]',
            'errors' => [
                'required' => 'Email is required',
                'valid_email' => 'Please enter a valid email address',
                'is_unique' => 'This email is already registered',
            ],
        ],
        'userPassword' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'Password is required',
                'min_length' => 'Password must be at least 8 characters long',
            ],
        ],
        'role_id'=> [
            'rules' => 'required',
            'errors' => [
                'required' => 'Role is required',
                ],
            ],
        'userDNI'=> [
            'rules' => 'required',
            'errors' => [
                'required' => 'User DNI is required',
                ],
            ],
        'userName'=> [
            'rules' => 'required',
            'errors' => [
                'required' => 'Username is required',
                ],
            ],
        'userPhone'=> [
            'rules' => 'required',
            'errors' => [
                'required' => 'User Phone is required',
                ],
            ],
        
        // Agrega aquí más reglas para otros atributos
    ];
}
