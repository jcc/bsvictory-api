<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raw extends Model
{
    protected $table = 'raw';

    protected $fillable = ['ip', 'data'];

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
