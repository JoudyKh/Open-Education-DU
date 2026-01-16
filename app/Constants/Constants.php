<?php

namespace App\Constants;

class Constants
{
    const ADMIN_ROLE = 'admin';
    const SUPER_ADMIN_ROLE = 'superadmin';
    const EMPLOYEE_ROLE = 'employee';
    const STUDENT_ROLE = 'student';
    const MALE_GENDER = 'male';
    const FEMALE_GENDER = 'female';

    const SYRIAN_NATIONALITY = 'Syrian';
    const ACADEMIC_TYPES = [
        'Institute_and_high_school',
        'High_school',
    ];
    const HIGH_SCHOOL_TYPES = [
        'scientific',
        'literary',
        'legitimate',
    ];

    const SELECTED_LANGUAGE = [
        'english',
        'french',
    ];
    const SECTIONS_TYPES = [
        'sections' => [
            'attributes' => [
                'name',
                'image',
            ],
            'rules' => [
                'create' => [
                    'ar_name' => 'required',
                    'en_name' => 'required',
                    'image' => 'required|mimes:jpeg,png,jpg',
                ],
                'update' => [
                    'ar_name' => 'nullable',
                    'en_name' => 'nullable',
                    'image' => 'mimes:jpeg,png,jpg',
                ],
            ],
        ],
        'brands' => [
            'attributes' => [
                'name',
                'image',
            ],
            'rules' => [
                'create' => [
                    'ar_name' => 'required',
                    'en_name' => 'required',
                    'image' => 'required|mimes:jpeg,png,jpg',
                ],
                'update' => [
                    'ar_name' => 'nullable',
                    'en_name' => 'nullable',
                    'image' => 'mimes:jpeg,png,jpg',
                ],
            ],
        ],

    ];
    const ORDER_STATUSES = [
        'pending' => [
            'ar' => 'معلق',
            'en' => 'pending',
        ],
        'rejected' => [
            'ar' => 'مرفوض',
            'en' => 'rejected',
        ],
        'completed' => [
            'ar' => 'مكتمل',
            'en' => 'completed',
        ],
    ];
    const DOCTOR_ACHIEVEMENTS_TYPE = [
        'books_and_scientific_publications',
        'scientific_research',
        'conferences',
        'teaching_experience',
    ];
    const STUDENTS_TYPES = [
        'old',
        'new',
    ];
}
