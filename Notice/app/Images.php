<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
  protected $table = 'images';
  protected $fillable = ['img'];
  public $timestamps = false;
}