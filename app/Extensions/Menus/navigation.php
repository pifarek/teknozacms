<?php

return [
    ['title' => trans('menus::admin.menu_menus'), 'icon' => 'bars', 'url' => '#', 'active' => \Request::is('administrator/menus*'), 'items' => [
        ['title' => trans('menus::admin.menu_menus_manage'), 'url' => 'administrator/menus', 'active' => \Request::is('administrator/menus*')],
    ]],
];