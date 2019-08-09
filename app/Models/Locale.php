<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $table = 'locales';

    /**
     * Return all accepted language codes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accept()
    {
        return $this->hasMany(LocaleAccept::class, 'locale_id', 'id');
    }

    /**
     * @param array $acceptCodes
     */
    public function assignAccept(array $acceptCodes = [])
    {
        foreach($this->accept as $accept) {
            if(false === array_search($accept->name, $acceptCodes)) {
                $accept->delete();
            }
        }

        foreach($acceptCodes as $accept) {
            $check = $this->accept()->where('name', $accept)->first();
            if(!$check) {
                $this->accept()->create(['name' => $accept]);
            }
        }
    }
}
