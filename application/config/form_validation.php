<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(
        'login' => array(
                array(
                        'field' => 'username',
                        'label' => 'Username',
                        'rules' => 'required|alpha_numeric',
                        'errors'=> array(
                                        'required'      => 'You have not provided %s.'
                                    )
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'required',
                        'errors'=> array( 
                                        'required'      => 'You have not provided %s.'
                                    )
                )
        ),
        'website_login' => array(
                array(
                        'field' => 'mobile',
                        'label' => 'Mobile',
                        'rules' => 'required|numeric|exact_length[10]',
                        'errors'=> array(
                                    'required'      => 'You have not provided %s.',
                                    'numeric'       => '%s must contain only numbers.',
                                    'exact_length'  => '%s must be exactly 10 digits.'
                                    )
                )
        ),
        'website_register' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|custom_alpha_space',
                        'errors'=> array(
                                    'required'      => 'You have not provided %s.'
                                    )
                ),
                array(
                        'field' => 'mobile',
                        'label' => 'Mobile',
                        'rules' => 'required|numeric|exact_length[10]',
                        'errors'=> array(
                                    'required'      => 'You have not provided %s.',
                                    'numeric'       => '%s must contain only numbers.',
                                    'exact_length'  => '%s must be exactly 10 digits.'
                                    )
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|valid_email',
                        'errors'=> array(
                            'required'     => 'You have not provided %s.',
                            'valid_email'  => 'Please enter a valid %s address.'
                        )
                )
        ),
        'language' => array(
                array(
                        'field' => 'language',
                        'label' => 'Language',
                        'rules' => 'required|alpha|checkLanguage',//is_unique[languages.language]',
                        'errors'=> array(
                                        'required'      => 'You have not provided %s.'
                                    )
                )
        ),
        'mood' => array(
                array(
                        'field' => 'mood',
                        'label' => 'Mood',
                        'rules' => 'required|custom_alpha_space|checkMood',//is_unique[moods.mood]',
                        'errors'=> array(
                                        'required'  => 'You have not provided %s.'
                                    )
                )
        ),
        'genre' => array(
                array(
                        'field' => 'genre',
                        'label' => 'Genre',
                        'rules' => 'required|custom_alpha_space|checkGenre',//is_unique[moods.mood]',
                        'errors'=> array(
                                        'required'  => 'You have not provided %s.'
                                    )
                )
        ),
        'label' => array(
                array(
                        'field' => 'name',
                        'label' => 'Label',
                        'rules' => 'required|alpha_numeric_dash_space|checkLabel',//is_unique[moods.mood]',
                        'errors'=> array(
                                        'required'  => 'You have not provided %s.'
                                    )
                )
        )
);
