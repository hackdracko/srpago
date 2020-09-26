<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    public $table = 'zip_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zip_code',
        'settling',
        'type_settling',
        'municipality',
        'state',
        'city',
        'settling_zip_code',
        'key_entity',
        'office_zip_code',
        'empty_zip_code',
        'key_municipality',
        'settling_id',
        'settling_zone',
        'key_city',
    ];
}
