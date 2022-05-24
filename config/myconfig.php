<?php

return [
    'default_password' => env('DEFAULT_PASSWORD'),
    'role' => [
        'verificator_with_location' => env('ROLE_AS_VERIFICATOR_WITH_LOCATION'),
        'verificator_without_location' => env('ROLE_AS_VERIFICATOR_WITHOUT_LOCATION'),
        'verificator' => env('ROLE_AS_VERIFICATOR'),
        'verificator_with_location_without_rayon' => env('ROLE_AS_VERIFICATOR_WITH_LOCATION_WITHOUT_RAYON'),
        'verificator_without_rayon' => env('ROLE_AS_VERIFICATOR_WITHOUT_RAYON'),
        'approve_or_correction_concept_admin' => env('ROLE_AS_APPROVE_OR_CORRECTION_CONCEPT_ADMIN'),
        'compose_survey_fisik' => env('ROLE_AS_COMPOSE_SURVEY_FISIK'),
        'head_of_cktr' => env('ROLE_AS_HEAD_OF_CKTR'),
    ],
    'generate_code' => [
        'admin' => [
            'perstek' => [
                'template_utama' => env('TEMPLATE_UTAMA_PERSTEK_ADMIN'),
                'template_no_seq' => env('TEMPLATE_NO_SEQ_PERSTEK_ADMIN'),
            ]
        ],
        'fisik' => [
            'perstek' => [
                'template_utama' => env('TEMPLATE_UTAMA_PERSTEK_FISIK'),
                'template_no_seq' => env('TEMPLATE_NO_SEQ_PERSTEK_FISIK'),
            ]
        ]
    ],
    'scheduler' => [
        'auto_approve_admin' => env('SCHEDULE_AUTO_APPROVE_ADMIN'),
        'auto_approve_fisik' => env('SCHEDULE_AUTO_APPROVE_FISIK'),
        'ssw_admin' => env('SCHEDULE_SSW_ADMIN'),
        'ssw_fisik' => env('SCHEDULE_SSW_FISIK'),
        'late_notif_admin' => env('SCHEDULE_LATE_NOTIF_ADMIN'),
        'late_notif_fisik' => env('SCHEDULE_LATE_NOTIF_FISIK'),
    ],
    'integrator' => [
        'kominfo' => [
            'url' => env('URL_KOMINFO'),
            'username' => env('USERNAME_KOMINFO'),
            'password' => env('PASSWORD_KOMINFO'),
        ],
    ],
    'static_token' => env('TOKEN_STATIS'),
];