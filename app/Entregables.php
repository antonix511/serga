<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entregables extends Model
{
    protected $table = 'entregables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','iddocumento','nombre'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='identregable';

    public $timestamps = false;

    public function proyecto(){
    	return $this->belongsToMany('App\Proyecto','idproyecto');
    }
    public function documento(){
    	return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
}
