<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticesType extends Model
{
  protected $table = 'notices_type';

  protected $fillable = ['type_name'];
  public $timestamps = false;
}
