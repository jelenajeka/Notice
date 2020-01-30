<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersEdited extends Model
{
  protected $table = 'users_edited';
  protected $fillable = ['notice_id','user_id'];
  public $timestamps = false;

  public function editedby()
  {
    return $this->belongsTo('App\User','user_id');
  }
}
