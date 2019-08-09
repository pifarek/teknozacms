<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocaleAccept extends Model
{
    protected $table = 'locales_accept';
    public $timestamps = false;

    protected $fillable = ['name'];

    /**
     * Return locale
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locale()
    {
        return $this->belongsTo(Locale::class, 'locale_id', 'id');
    }
}
