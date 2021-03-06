<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notificacion_centro_costos extends Model
{

	protected $table = 'notificacion_centro_costos';
	    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto', 'idtrabajador', 'correo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idnotificacion';

    public $timestamps = false;

    //foreign key
    public function trabajador(){
    	return $this->belongsTo('App\Trabajador','idtrabajador','idpersona');
    }

    public function persona(){
        return $this->belongsTo('App\Persona','idtrabajador','idpersona');
    }

}
