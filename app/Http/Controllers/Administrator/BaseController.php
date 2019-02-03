<?php
namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $settings;
    protected $administratorLocale;
    protected $availableAdministratorLocales;
    
    public function __construct(Request $request)
    {
        // Set the available administrator locales
        $this->availableAdministratorLocales = collect(['en']);

        // Share the available administrator locales
        \View::share('admin_locales', $this->availableAdministratorLocales);

        // Set the administrator language
        $this->administratorLocale = $request->cookie('administrator_locale', 'en');
        \App::setLocale($this->administratorLocale); \Date::setLocale($this->administratorLocale);
        
        if (\Auth::guard('administrator')->user()) {
            // Update user last active date
            \Auth::guard('administrator')->user()->updateActive();
        }

        // Share the current locale
        $locale = \App::getLocale();
        \View::share('tpl_locale', $locale);

        // Set the Google Analytics View ID if set
        config(['analytics.view_id' => \Settings::get('analytics_view_id')], '');

        // Share the list of menus
        \View::share('nav_menu', $this->navigationMenu());
        
        $this->settings = [
            [
                'label' => 'Page Title',
                'name' => 'title',
                'multilanguage' => true,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'Page Description',
                'name' => 'description',
                'multilanguage' => true,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'Default Newsletter Group',
                'name' => 'newsletter_default_group',
                'multilanguage' => false,
                'type' => 'select',
                'rules' => [],
                'options' => $this->getNewsletterGroups()
            ],
            [
                'label' => 'Global e-mail address',
                'name' => 'email',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => ['email']
            ],
            [
                'label' => 'Facebook URL',
                'name' => 'facebook',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'Google+ URL',
                'name' => 'google',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'Youtube',
                'name' => 'youtube',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'Twitter Username',
                'name' => 'twitter',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'SMTP Hostname',
                'name' => 'smtp_host',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'SMTP Username',
                'name' => 'smtp_user',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'SMTP Password',
                'name' => 'smtp_pass',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'SMTP Port',
                'name' => 'smtp_port',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ],
            [
                'label' => 'SMTP From E-mail',
                'name' => 'smtp_from',
                'multilanguage' => false,
                'type' => 'text',
                'rules' => []
            ]
        ];
    }

    /**
     * Create an array with main navigation elements
     * @return array
     */
    private function navigationMenu()
    {
        $default =  [
            ['title' => trans('admin.menu_dashboard'), 'icon' => 'home', 'url' => 'administrator', 'items' => [], 'active' => \Request::is('administrator')],
        ];

        $extensionsNavigation = \Teknoza::navigation();
        foreach($extensionsNavigation as $trans) {
            $array = include $trans;
            $default = array_merge($default, $array);
        }

        $default[] = ['title' => 'Page Settings', 'icon' => 'cog', 'url' => '#', 'active' => \Request::is('administrator/settings*'), 'items' => [
            ['title' => trans('admin.menu_settings_global'), 'url' => 'administrator/settings/global', 'active' => \Request::is('administrator/settings/global')],
            ['title' => trans('admin.menu_settings_statistics'), 'url' => 'administrator/settings/statistics', 'active' => \Request::is('administrator/settings/statistics')],
            ['title' => trans('admin.menu_settings_users'), 'url' => 'administrator/settings/users/list', 'active' => \Request::is('administrator/settings/users')],
            ['title' => trans('admin.menu_settings_locales'), 'url' => 'administrator/settings/locales/list', 'active' => \Request::is('administrator/settings/locales*')],
            ['title' => trans('admin.menu_settings_translations'), 'url' => 'administrator/settings/translations', 'active' => \Request::is('administrator/settings/translations')],
        ]];

        return $default;
    }
    
    /**
     * Retrieve all the newsletter groups
     * @return type
     */
    private function getNewsletterGroups()
    {
        $newsletterExtensionEnabled = class_exists('\App\Extensions\Newsletter\Controllers\IndexController');
        if($newsletterExtensionEnabled) {
            $groups = \App\Extensions\Newsletter\Models\Group::pluck('name', 'id');
            if ($groups) {
                return $groups->toArray();
            }
        }
        return [];
    }
}
