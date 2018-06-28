<?php

return [
    ['title' => trans('events::admin.menu_events'), 'icon' => 'calendar-alt', 'url' => '#', 'active' => \Request::is('administrator/events*'), 'items' => [
        ['title' => trans('events::admin.menu_events_manage'), 'url' => 'administrator/events', 'active' => \Request::is('administrator/events')],
        ['title' => trans('events::admin.menu_events_add'), 'url' => 'administrator/events/create', 'active' => \Request::is('administrator/events/create')],
    ]],
];