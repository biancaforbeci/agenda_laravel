<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contact;
use Carbon\Carbon;

class Message extends Model
{

  protected $fillable = [
        'contact_id',
        'description'
    ];


    public function contact(){
          return $this->belongsTo('App\Contact');
   }

   public function getCreatedAtAttribute($date){
    return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
   }

   public function getUpdatedAtAttribute($date){
    return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
   }
}
