<?php

declare(strict_types=1);

return [
    'messages' => [
        'required' => 'Введите :attribute.',
        'filled' => 'Поле :attribute не должно быть пустым, если оно присутствует в запросе.',
        'present' => 'Поле :attribute должно присутствовать в запросе, но может быть пустым.',
        'string' => 'Значение поля :attribute должно быть строкой.',
        'max' => 'Значение поля :attribute может содержать максимум :max символов.',
        'title_not_unique' => 'Вы уже добавляли рецепт с таким названием.',
    ],

    'attributes' => [
        'title' => 'название',
        'short_description' => 'краткое описание',
        'text' => 'описание',
    ],
];
