<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentDetail extends Model
{
    protected $table = 'component_detail';
    protected $guarded = ['created_at','updated_at'];
    public $timestamps  = true;
    protected $primaryKey = 'com_detail_id';
    public $incrementing = false;

    public function komponen(){
        return $this->belongsTo('App\Component', 'com_cd', 'com_cd');
    }
}
