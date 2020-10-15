<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Ambulan extends Model
{
    use Uuid;

    protected $primaryKey   = 'ambulan_id';
    protected $guarded      = ['created_at','updated_at'];
    public $timestamps      = true;
    public $incrementing    = false;

    public function instansi()
    {
        return $this->belongsTo('App\Instansi','instansi_id','instansi_id');
    }

    public function statusAmbulan(){
        return $this->belongsTo('App\Component', 'status', 'com_cd');
    }
}
