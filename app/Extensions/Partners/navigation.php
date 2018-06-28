<?php

return [
    ['title' => trans('partners::admin.menu_partners'), 'icon' => 'suitcase', 'url' => '#', 'active' => \Request::is('administrator/partners'), 'items' => [
        ['title' => trans('partners::admin.menu_partners_manage'), 'url' => 'administrator/partners', 'active' => \Request::is('administrator/partners*')],
    ]],
];