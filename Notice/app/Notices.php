<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notices extends Model
{
  protected $table = 'notices';

  protected $fillable = ['title', 'text', 'type', 'user_id', 'img', 'attach' ];
  public $timestamps = false;

  public function noticeby()
  {
    return $this->belongsTo('App\User','user_id');
  }

  public function noticetype()
  {
    return $this->belongsTo('App\NoticesType','type');
  }

}
