<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'The :attribute must be a valid email address.',
    'filled'               => 'The :attribute field is required.',
    'exists'               => 'The selected :attribute is invalid.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'avatar-filename' => [
            'required' => 'You need to upload your profile picture'
        ],
        'id_number' => [
            'unique' => 'ID number already exist',
            'required' => 'You need to enter valid ID number',
            'min' => 'ID number must be at least 11 characters long',
            'max' => 'ID number must be maximum 11 characters long',
            'turkish_identification_number' => 'ID number not validate. please enter name, surname, birthdate enter true.',
            'turkish_identification_unique' => 'ID number already exist. you can try again.',
            'turkish_identification_exist' => 'ID number already exist. not request',
        ],
        'name' => [
            'required' => 'You need to enter your name'
        ],
        'surname' => [
            'required' => 'You need to enter your surname'
        ],
        'birthdate-day' => [
            'required' => 'Your birth day can\'t be empty',
            'numeric' => 'Your birth day must be valid number',
            'min' => 'Your birth day must be from 1 to 31',
            'max' => 'Your birth day must be from 1 to 31',
        ],
        'birthdate-month' => [
            'required' => 'Your birth month can\'t be empty',
            'numeric' => 'Your birth month must be valid number',
            'min' => 'Your birth month must be from 1 to 12',
            'max' => 'Your birth month must be from 1 to 12',
        ],
        'birthdate-year' => [
            'required' => 'Your birth year can\'t be empty',
            'numeric' => 'Your birth year must be valid number',
            'min' => 'Your birth year must be from 1980 to 2000',
            'max' => 'Your birth year must be from 1980 to 2000',
        ],
        'gender' => [
            'required' => 'You need to select your gender',
        ],
        'email' => [
            'required' => 'You must enter a valid e-mail address',
            'email' => 'You must enter a valid e-mail address',
            'unique' => 'Sorry but we have already account with that e-mail',
        ],
        'old_password' => [
            'password' => 'You must enter a valid password',
        ],
        'password' => [
            'required' => 'You need to enter your password',
            'same' => 'The passwords doesn\'t match',
            'min' => 'Your password must be at least :min characters long'
        ],
        'repassword' => [
            'required' => 'You need to retype your password'
        ],
        // ========================
        'address_type' => [
            'required' => 'You need to select your address type'
        ],
        'address' => [
            'required' => 'You need to enter your address',
        ],
        'region' => [
            'required' => 'You need to select your province',
            'numeric' => 'You need to select your province',
            'exists' => 'You need to select your province',
            'min' => 'You need to select your province',
        ],
        'city' => [
            'required' => 'You need to select your city',
            'numeric' => 'You need to select your city',
            'exists' => 'You need to select your city',
            'min' => 'You need to select your city',
        ],
        'mobile_phone' => [
            'required' => 'You need to enter your mobile phone number',
            'regex' => 'You need to enter your mobile phone number',
        ],
        'fixed_phone' => [
            'regex' => 'Phone number isn\'t valid',
        ],
        // =========================
        'university' => [
            'required' => 'You need to select your university',
            'numeric' => 'You need to select your university',
            'min' => 'You need to select your university',
            'exists' => 'You need to select your university',
        ],
        'faculty' => [
            'required' => 'You need to select your faculty',
            'numeric' => 'You need to select your faculty',
            'min' => 'You need to select your faculty',
            'exists' => 'You need to select your faculty',
        ],
        'course' => [
            'required' => 'You need to select your course',
            'numeric' => 'You need to select your course',
            'min' => 'You need to select your course',
            'exists' => 'You need to select your course',
        ],
        'class' => [
            'required' => 'You need to select your class number',
            'numeric' => 'You need to select your class number',
        ],
        'student_number' => [
            'numeric' => 'You need to enter a valid number',
        ],
        'student_points_select' => [
            'required' => 'You need to select points system',
            'numeric' => 'You need to select points system',
            'min' => 'You need to select points system',
            'max' => 'You need to select points system',
        ],
        'student_points' => [
            'required' => 'You need to enter your points',
            'numeric' => 'You need to enter your points',
            'min' => 'The points must be greater then :min',
            'max' => 'The points must be lower then :max',
        ],
        'student_position' => [
            'required' => 'You need to enter your position',
            'numeric' => 'You need to enter your position',
        ],
        'secondary_school' => [
            'required' => 'You need to enter name of your secondary school'
        ],
        'diploma_score_select' => [
            'required' => 'You need to select diploma points system',
            'numeric' => 'You need to select diploma points system',
            'min' => 'You need to select diploma points system',
            'max' => 'You need to select diploma points system',
        ],
        'diploma_score_1' => [
            'required' => 'You need to enter your diploma score',
            'numeric' => 'You need to enter your diploma score',
            'min' => 'Your diploma score must be greater then :min',
            'max' => 'Your diploma score must be lower then :max',
        ],
        'diploma_score_2' => [
            'required' => 'You need to enter your diploma score',
            'numeric' => 'You need to enter your diploma score',
            'min' => 'Your diploma score must be greater then :min',
            'max' => 'Your diploma score must be lower then :max',
        ],
        // ==========================
        'father_name' => [
            'required' => 'You need to enter your father\'s name',
        ],
        'father_alive' => [
            'required' => 'You need to select if your father alive',
            'numeric' => 'You need to select if your father alive',
            'min' => 'You need to select if your father alive',
        ],
        'father_marital' => [
            'required' => 'You need to select your father\'s marital status',
            'numeric' => 'You need to select your father\'s marital status',
            'min' => 'You need to select your father\'s marital status',
        ],
        'father_job' => [
            'required' => 'Select your father\'s job',
            'numeric' => 'Select your father\'s job',
            'exists' => 'Select your father\'s job',
            'min' => 'Select your father\'s job',
        ],
        'father_company' => [
            'required' => 'Enter your father\'s company name',
        ],
        'father_mobile' => [
            'required' => 'Enter a valid phone number',
            'regex' => 'Enter a valid phone number',
        ],
        'father_income' => [
            'required' => 'Enter your father\'s monthly income',
            'numeric' => 'Enter your father\'s monthly income',
            'max' => 'Enter your father\'s monthly income'            
        ],
        'mother_name' => [
            'required' => 'You need to enter your mother\'s name',
        ],
        'mother_alive' => [
            'required' => 'You need to select if your mother alive',
            'numeric' => 'You need to select if your mother alive',
            'min' => 'You need to select if your mother alive',
        ],
        'mother_marital' => [
            'required' => 'You need to select your mother\'s marital status',
            'numeric' => 'You need to select your mother\'s marital status',
            'min' => 'You need to select your mother\'s marital status',
        ],
        'mother_job' => [
            'required' => 'Select your mother\'s job',
            'numeric' => 'Select your mother\'s job',
            'exists' => 'Select your mother\'s job',
            'min' => 'Select your mother\'s job',
        ],
        'mother_company' => [
            'required' => 'Enter your mother\'s company name',
        ],
        'mother_mobile' => [
            'required' => 'Enter a valid phone number',
            'regex' => 'Enter a valid phone number',
        ],
        'mother_income' => [
            'required' => 'Enter your mother\'s monthly income',
            'numeric' => 'Enter your mother\'s monthly income',
            'max' => 'Enter your mother\'s monthly income'            
        ],
        'family_address' => [
            'required' => 'You need to enter your address',
        ],
        'family_region' => [
            'required' => 'You need to select your province',
            'numeric' => 'You need to select your province',
            'exists' => 'You need to select your province',
            'min' => 'You need to select your province',
        ],
        'family_city' => [
            'required' => 'You need to select your city',
            'numeric' => 'You need to select your city',
            'exists' => 'You need to select your city',
            'min' => 'You need to select your city',
        ],
        'siblings' => [
            'required' => 'How many siblings do you have?',
            'numeric' => 'How many siblings do you have?',
        ],
        'other_income' => [
            'required' => 'Enter other income',
            'income' => 'Enter other income',
            'max' => 'Enter other income',
        ],
        'transcript' => [
            'mimes' => 'You need to upload JPEG, PNG, DOC, XLS or PDF file.',
            'max' => 'Sorry but your file is too big.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
