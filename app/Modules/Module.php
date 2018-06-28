<?php

namespace App\Modules;

class Module{
    protected $view;
    protected $params;
    
    public function __construct($params = []){
        $this->params = $params;

        if(isset($this->params['view'])){
            $this->view = $this->view . '_' . $this->params['view'];
        }
    }
    
    public function display(){
        return view($this->view)->with($this->logic());
    }
    
    public function logic(){
        return [];
    }
}