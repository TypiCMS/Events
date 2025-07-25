<?php

return [
    'linkable_to_page' => true,
    'per_page' => 50,
    'order' => [
        'end_date' => 'desc',
    ],
    'sidebar' => [
        'icon' => '<i class="icon-calendar-range"></i>',
        'weight' => 50,
    ],
    'permissions' => [
        'read events' => 'Read',
        'create events' => 'Create',
        'update events' => 'Update',
        'delete events' => 'Delete',
    ],
];
