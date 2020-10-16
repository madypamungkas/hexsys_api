<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Patient extends Model
{

    use Uuid;

    protected $primaryKey   = 'patient_id';
    protected $guarded      = ['created_at','updated_at'];
    public $timestamps      = true;
    public $incrementing    = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
