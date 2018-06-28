<?php

return [
    ['title' => trans('sliders::admin.menu_sliders'), 'icon' => 'images', 'url' => '#', 'active' => \Request::is('administrator/sliders*'), 'items' => [
        ['title' => trans('sliders::admin.menu_sliders_manage'), 'url' => 'administrator/sliders', 'active' => \Request::is('administrator/sliders')],
        ['title' => trans('sliders::admin.menu_sliders_add'), 'url' => 'administrator/sliders/slides/create', 'active' => \Request::is('administrator/sliders/slides/create*')],
    ]],
];