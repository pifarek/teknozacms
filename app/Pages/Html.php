<?php
namespace App\Pages;

use App\Models\Locale;
use Illuminate\Http\Request;

class Html extends Main
{
    public function __construct($item_id = null){
        $this->title = 'HTML Page';
        parent::__construct($item_id);
    }  
    
    public function logic(Request $request)
    {
        // Get the view type
        // 1_column, 2_columns or 3_columns
        $view = $this->getCustom('view')?: '1_column';
        
        // Get current locale
        $locale = Locale::where('language', '=', \App::getLocale())->get()->first();

        // Get the content
        $custom = $this->getCustom('content', $locale->language);
        $content = $custom? $custom : '';

        return view('page.pages.html')->with([
            'content' => $content,
            'view' => $view
        ]);
    }
    
    public function fields()
    {
        return [
            // Textarea where you can enter page content
            (object) ['label' => trans('admin.page_html_content'), 'name' => 'content', 'type' => 'textarea', 'multilanguage' => true, 'rules' => ['required']],
            // You can select how to display content
            (object) ['label' => trans('admin.page_html_view'), 'name' => 'view', 'type' => 'select', 'multilanguage' => false, 'rules' => ['required'], 'options' => [
                    'column_1' => trans('admin.page_html_view_1'),
                    'columns_2' => trans('admin.page_html_view_2'),
                    'columns_3' => trans('admin.page_html_view_3'),
                ]]
        ];
    }
}
