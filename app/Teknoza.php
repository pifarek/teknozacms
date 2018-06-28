<?php
namespace App;

use App\Models\Locale;

/**
 * Description of Teknoza
 *
 * @author Marcin Piwarski
 */
class Teknoza
{
    public static $instance;
    public $language;
    
    public function __construct()
    {
        $this->language = Locale::where('language', '=', \App::getLocale())->get()->first();
    }
    
    public static function instance()
    {
        if(!self::$instance) {
            self::$instance = new Teknoza();
        }
        
        return self::$instance;
    }
    
    /**
     * Find a page with the current url
     * @param string $url
     * @return \App\Pages\
     */
    public function findRoute($url)
    {
        if(!$url || $url == '/') {
            return new \App\Pages\Index;
        }
		
        $translatedItem = \App\Extensions\Menus\Models\ItemTranslation::whereRaw("LOCATE(route, '$url')>0")->orderBy('id', 'desc')->get()->first();

        if($translatedItem) {
			$params = explode('/', substr(str_replace($translatedItem->route, '', $url), 1));
			
            $class_name = '\App\Pages\\' . ucfirst($translatedItem->item->type);
            $new = new $class_name($translatedItem->item_id);
            $new->params($params);
            $new->title($translatedItem->item->name);
            $new->type($translatedItem->item->type);
            $new->image($translatedItem->item->image?:'');
            $new->type($translatedItem->item->type);
            $new->url($url);
            return $new;
        }
		
		return new \App\Pages\Index;
    }

    /**
     * Read additional route files
     */
    public static function Routes()
    {
        $routes = \Cache::get('routes');
        if(!$routes) {
            $routes = collect();
            $extensions = \File::directories(app_path('Extensions'));
            foreach ($extensions as $extension) {
                if (file_exists($extension . '/routes.web.php')) {
                    $routes->push($extension . '/routes.web.php');
                }
            }
            \Cache::put('routes', $routes);
        }
        return $routes;
    }

    /**
     * Read additional translation files
     */
    public static function Translations()
    {
        $translations = \Cache::get('translations');
        if(!$translations) {
            $translations = collect();
            $extensions = \File::directories(app_path('Extensions'));
            foreach ($extensions as $extension) {
                $translations->push([
                    'path' => $extension . '/lang',
                    'namespace' => strtolower(basename($extension))
                ]);
            }
            \Cache::put('translations', $translations);
        }
        return $translations;
    }

    /**
     * Get extension navigation items
     */
    public static function Navigation()
    {
        $navigation = null; //\Cache::get('$navigation');
        if(!$navigation) {
            $navigation = collect();
            $extensions = \File::directories(app_path('Extensions'));
            foreach ($extensions as $extension) {
                $navigation->push($extension . '/navigation.php');
            }
            \Cache::put('navigation', $navigation);
        }
        return $navigation;
    }

    public static function statisticsCheckCredentialsFile()
    {
        return \Storage::exists('analytics/service-account-credentials.json');
    }
}
