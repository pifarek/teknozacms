<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Locale extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['language'];

    public static function all($columns = ['*'])
    {
        if (!Cache::has('localesSeeder')) {

            $value = parent::orderBy('id', 'DESC')->get($columns);

            Cache::put('localesSeeder', $value, 1440);

            return $value;

        } else {

            return parent::orderBy('id', 'DESC')->get($columns);
        }
    }
}