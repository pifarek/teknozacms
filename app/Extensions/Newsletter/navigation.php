<?php

return [
    ['title' => trans('newsletter::admin.menu_newsletter'), 'icon' => 'envelope', 'url' => '#', 'active' => \Request::is('administrator/newsletter*'), 'items' => [
        ['title' => trans('newsletter::admin.menu_newsletter_mailing'), 'url' => 'administrator/newsletter/send', 'active' => \Request::is('administrator/newsletter/send')],
        ['title' => trans('newsletter::admin.menu_newsletter_manage'), 'url' => 'administrator/newsletter', 'active' => \Request::is('administrator/newsletter')],
        ['title' => trans('newsletter::admin.menu_newsletter_groups'), 'url' => 'administrator/newsletter/groups', 'active' => \Request::is('administrator/newsletter/groups')],
    ]],
];