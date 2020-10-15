<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $table = 'component';
    protected $guarded = ['created_at','updated_at'];
    public $timestamps  = true;
    protected $primaryKey = 'com_cd';
    public $incrementing = false;
}
