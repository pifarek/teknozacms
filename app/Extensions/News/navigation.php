<?php

return [
    ['title' => trans('news::admin.menu_news'), 'icon' => 'newspaper ', 'url' => '#', 'active' => \Request::is('administrator/news') or \Request::is('administrator/news/*'), 'items' => [
        ['title' => trans('news::admin.menu_news_news'), 'url' => 'administrator/news', 'active' => \Request::is('administrator/news')],
        ['title' => trans('news::admin.menu_news_add'), 'url' => 'administrator/news/create', 'active' => \Request::is('administrator/news/create')],
        ['title' => trans('news::admin.menu_news_categories'), 'url' => 'administrator/news/categories', 'active' => \Request::is('administrator/news/categories')],
    ]]
];