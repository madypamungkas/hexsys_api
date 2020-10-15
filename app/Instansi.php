<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Instansi extends Model
{
    use Uuid;

    protected $primaryKey   = 'instansi_id';
    protected $guarded      = ['created_at','updated_at'];
    public $timestamps      = true;
    public $incrementing    = false;

    public function ambulans()
    {
        return $this->hasMany('App\Ambulan','instansi_id','instansi_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function statusInstansi(){
        return $this->belongsTo('App\Component', 'status', 'com_cd');
    }
}
