<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matriz_Riesgos extends Model
{
    protected $table = 'matriz_riesgos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','iddocumento','fecha','documento','archivo','descripcion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idmatrizriesgos';

    public $timestamps = false;

    public function proyecto(){
    	return $this->belongsToMany('App\Proyecto','idproyecto');
    }
    public function documento(){
    	return $this->belongsToMany('App\Documento','iddocumento');
    }
}
