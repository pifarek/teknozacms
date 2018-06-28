<?php

return [
    ['title' => trans('contacts::admin.menu_contacts'), 'icon' => 'users', 'url' => '#', 'active' => \Request::is('administrator/contacts*'), 'items' => [
        ['title' => trans('contacts::admin.menu_contacts_manage'), 'url' => 'administrator/contacts', 'active' => \Request::is('administrator/contacts')],
        ['title' => trans('contacts::admin.menu_contacts_add'), 'url' => 'administrator/contacts/create', 'active' => \Request::is('administrator/contacts/create')],
    ]],
];