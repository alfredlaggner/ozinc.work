<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public function customer()
    {
        return $this->hasOne('App\Customer','ext_id_contact','ext_id');
    }
}
