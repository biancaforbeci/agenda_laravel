<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message;

class Contact extends Model
{

  protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone'
    ];

    public function messages(){
            return $this->hasMany('App\Message');
    }
}
