<?php

return [
    'per_page' => 50,
    'select' => ['id', 'title', 'image', 'start_date', 'end_date', 'status'],
    'order'    => [
        'end_date' => 'desc',
    ],
    'sidebar' => [
        'weight' => 4,
    ],
];
