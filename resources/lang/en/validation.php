<?php 

return [
    'required'        => 'Field <b>:attribute</b> is required',
    'unique'          => 'Field <b>:attribute</b> used before',
    'min'             => [
        'string'      => 'Field <b>:attribute</b> should be at least :min chararacters',
    ],
    'max'             => [
        'string'      => 'Field <b>:attribute</b> should be maximum :max chararacters',
        'file'        => 'Field <b>:attribute</b> should be maximum :max KB', 
    ],
    'regex'           => 'Field <b>:attribute</b> is not true',
    'nouser'          => 'The username or password is not correct',
    'noextimage'      => 'This file is not an image type or wrong image type',
    'noimage'         => 'Please select an image first',
];

?>