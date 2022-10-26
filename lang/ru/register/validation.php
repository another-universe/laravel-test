<?php

declare(strict_types=1);

return [
    'messages' => [
        'required' => 'Укажите :attribute.',
        'string' => 'Значение поля :attribute должно быть строкой.',
        'email' => 'Некорректный формат :attribute.',
        'unique_user_email' => 'Пользователь с таким :attribute уже существует.',
        'unique_user_nick_name' => 'Такой :attribute уже занят.',
        'min' => ':Attribute должен состоять минимум из :min символов.',
        'max' => ':Attribute может состоять максимум из :max символов.',
    ],

    'attributes' => [
        'nick_name' => 'ник',
        'email' => 'email',
        'password' => 'пароль',
    ],
];
