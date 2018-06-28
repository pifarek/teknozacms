<?php

return [
    ['title' => trans('projects::admin.menu_projects'), 'icon' => 'archive', 'url' => '#', 'active' => \Request::is('administrator/projects*'), 'items' => [
        ['title' => trans('projects::admin.menu_projects_manage'), 'url' => 'administrator/projects', 'active' => \Request::is('administrator/projects')],
        ['title' => trans('projects::admin.menu_projects_tags'), 'url' => 'administrator/projects/tags', 'active' => \Request::is('administrator/projects/tags*')],
    ]],
];