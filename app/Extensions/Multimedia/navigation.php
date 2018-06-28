<?php

return [
    ['title' => trans('multimedia::admin.menu_multimedia'), 'icon' => 'film', 'url' => '#', 'active' => \Request::is('administrator/multimedia*'), 'items' => [
        ['title' => trans('multimedia::admin.menu_multimedia_list'), 'url' => 'administrator/multimedia', 'active' => \Request::is('administrator/multimedia')],
    ]]
];