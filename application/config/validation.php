<?php
$config['forms'] = [
    
    [
        'field' => 'phone_number',
        'label' => 'Phone Number',
        'rules' => 'required|min_length[9]|max_length[14]|regex_match[/^[0-9]{9,14}$/]',
        'errors' => ['required' => 'phone number required'],
    ],
    [
        'field' => 'country_code',
        'label' => 'Country Code',
        'rules' => 'required|regex_match[/^\+[0-9]{1,6}$/]',
        'errors' => ['required' => 'country code required'],
    ],

];

$config['otp'] = [
    [
        'field' => 'otp',
        'label' => 'OTP',
        'rules' => 'required|regex_match[/^[0-9]{4}$/]',
        'errors' => ['required' => 'Otp is Required'],
    ],
];

$config['registration'] = [
    [
        'field' => 'email',
        'label' => 'Email',
        'rules' => 'required|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/]',
        'errors' => ['required' => 'Email is Required'],
    ],
    [
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z ]*$/]',
        'errors' => ['required' => 'Name is Required'],
    ],

];

$config['update_details'] = [
    [
        'field' => 'email',
        'label' => 'Email',
        'rules' => 'required|regex_match[/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/]|max_length[50]',
        'errors' => ['required' => 'Email is Required'],
    ],
    [
        'field' => 'name',
        'label' => 'Name',
        'rules' => 'required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z ]*$/]',
        'errors' => ['required' => 'Name is Required'],
    ],
    [
        'field' => 'phone_number',
        'label' => 'Phone Number',
        'rules' => 'required|min_length[9]|max_length[14]|regex_match[/^[0-9]{9,14}$/]',
        'errors' => ['required' => 'phone number required'],    
    ],
    [
        'field' => 'country_code',
        'label' => 'Country Code',
        'rules' => 'required|regex_match[/^\+[0-9]{1,6}$/]',
        'errors' => ['required' => 'country code required'],
    ],

];

$config['login'] = [
    [
        'field' => 'username',
        'label' => 'Username',
        'rules' => 'trim|required|min_length[3]|max_length[50]|regex_match[/^[a-zA-Z ]*$/]',
        'errors' => ['required' => 'Username is Required'],
    ],
    [
        'field' => 'password',
        'label' => 'Password',
        'rules' => 'trim|required|min_length[4]|max_length[16]',
        'errors' => ['required' => 'Password required'],    
    ],
];
?>