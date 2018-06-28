<?php

namespace App\Extensions\Partners\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';
    
    public $timestamps = false;
    
    public function delete()
    {
        if($this->filename){
            @unlink('upload/partners/' . $this->filename);
        }
        
        parent::delete();
    }
    
    public function move($direction)
    {
        switch($direction){
            case 'up':
                $this->moveUp();
                break;
            case 'down':
                $this->moveDown();
                break;
        }
    }
    
    public function moveUp()
    {
        $current_order = $this->order;
        
        // get the item with next order
        $partner = Partner::where('order', '=', $current_order - 1)->get()->first();
        if($partner){
            // switch with current item if exists
            $partner->order = $current_order;
            $partner->save();
        }
        
        // check if order < 0
        if($current_order - 1 >= 0){
            $this->order = $current_order - 1;
            $this->save();
        }

        $this->clearOrder();
        return true;
    }
    
    public function moveDown()
    {
        $current_order = $this->order;
        
        // get the item with next order
        $partner = Partner::where('order', '=', $current_order + 1)->get()->first();
        if($partner){
            // switch with current item if exists
            $partner->order = $current_order;
            $partner->save();
        }
        $this->order = $current_order + 1;
        $this->save();

        $this->clearOrder();
        return true;
    }
    
    private function clearOrder($parent_id = NULL)
    {
        // Get parent items
        $partners = Partner::orderBy('order', 'ASC')->get();

        if($partners->count()){
            $count = 0;
            foreach($partners as $partner){
                $partner->order = $count;
                $partner->save();
                $count++;
            }
        }
    }    
}