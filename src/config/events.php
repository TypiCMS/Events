<?php

return [
    'linkable_to_page' => true,
    'per_page' => 50,
    'order' => [
        'end_date' => 'desc',
    ],
    'sidebar' => [
        'icon' => '<i class="bi bi-calendar3"></i>',
        'weight' => 50,
    ],
    'permissions' => [
        'read events' => 'Read',
        'create events' => 'Create',
        'update events' => 'Update',
        'delete events' => 'Delete',
    ],
];
