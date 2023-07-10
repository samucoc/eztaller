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
    // Agrega las reglas personalizadas para la creación de usuarios aquí
    public $createUser = [
        'role_id' => 'required',
        'company_id' => 'required',
        'userDNI' => 'required',
        'userName' => 'required|min_length[2]|max_length[50]',
        'userEmail' => 'required|valid_email|is_unique[users.userEmail]',
        'userPassword' => 'required|min_length[8]',
    ];
    public $createApplicationCategoryGroup = [
        'application_id', 'categoryGroup_id'

    ];
    public $createApplicationCategory = [
        'application_id'    => 'required',
        'category_id'  => 'required',
    ];

    
    public $createApplicationFile = [
        'application_id'  => 'required', 'file_id'  => 'required',

    ];

    public $createApplication = [
        'company_id'  => 'required',
        'companyUser_id'  => 'required',
        'user_id'  => 'required',
        'contest_id'  => 'required',
        'applicationTitle'  => 'required',
        'applicationDescription'  => 'required',
        'applicationBenefits'  => 'required',
        'applicationImplementationDate'  => 'required',
        'applicationStatusDraft'  => 'required',
        'applicationStatusAfterDraft'  => 'required',
        'applicationStatusPreselection'  => 'required',
        'applicationStatusFinalist'  => 'required',
        'applicationStatusFinal'  => 'required',
        'applicationStatusEditedByCompany'  => 'required',
        'applicationStatusEditedByCompanyDateTime'  => 'required',
        'applicationStatusEditedByAdmin'  => 'required',
        'applicationStatusEditedByAdminDateTime'  => 'required',
        'sapplicationStatusPublished'  => 'required',
    ];

    public $createApplicationTag = [
        'application_id'  => 'required', 'tag_id'  => 'required',

    ];

    public $createBusinessRole = [
        'businessRoleName'  => 'required',

    ];

    public $createCategory = [
        'categoryName'  => 'required','categoryGroup_id'  => 'required','categoryType'    => 'required',

    ];

    public $createCategoryGroup = [
        'categoryGroupName'  => 'required','contest_id'  => 'required',

    ];

    public $createCity = [
        'cityName'  => 'required', 'state_id'  => 'required',

    ];

    public $createCompany = [
        'state_id'  => 'required',
        'city_id'  => 'required',
        'companyName'  => 'required',
        'companyDNI'  => 'required',
        'companyAddress'  => 'required',
        'companyManagerName'  => 'required',
        'companyManagerPhone'  => 'required',
        'companyManagerEmail'  => 'required',
    ];

    public $createCompanyUser = [
        'businessRole_id'  => 'required',
        'company_id'  => 'required',
        'companyUserEmail'  => 'required',
        'companyUserPassword'  => 'required',
        'companyUserPasswordRecoveryToken'  => 'required',
        'companyUserPasswordRecoveryTokenExpirationDateTime'  => 'required',
        'companyUserFullName'  => 'required',
        'companyUserDNI'  => 'required',
        'companyUserPhone'  => 'required',
    ];

    public $createContest = [
        'contestName'  => 'required', 'contestDescription'  => 'required',

    ];

    public $createContestFile = [
        'contest_id'  => 'required', 'file_id'  => 'required',

    ];

    public $createFile = [
        'fileName'  => 'required', 'fileExtension'  => 'required', 'fileURL'  => 'required', 'fileSource'  => 'required',

    ];

    public $createRole = [
        'roleName'  => 'required',

    ];

    public $createState = [
        'stateName'  => 'required',

    ];

    public $createTag = [
        'tagName'  => 'required','category_id'  => 'required',

    ];

    public $createTicket = [
        'companyUser_id'  => 'required',
        'company_id'  => 'required',
        'application_id'  => 'required',
        'user_id'  => 'required',
        'ticketStatus'  => 'required',
        'ticketTitle'  => 'required', 
        'ticketDescription'  => 'required',
    ];

    public $createTicketFile = [
        'ticket_id'  => 'required', 'file_id'  => 'required',

    ];

    public $createTicketResponse = [
        'ticket_id'  => 'required',
        'companyUser_id'  => 'required', 
        'user_id'  => 'required', 
        'ticketResponseSource'  => 'required', 
        'ticketResponseData'   => 'required', 
    ];

    public $createTicketResponseFile = [
        'ticketResponse_id'  => 'required','file_id'  => 'required',

    ];

}
