<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{

	protected $table = 'persona';
	    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'correo', 'telefono','direccion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idpersona';

    public $timestamps = false;

    //foreign key
    public function trabajador(){
    	return $this->hasOne('App\Trabajador','idpersona');
    }
    public function cliente(){
        return $this->hasOne('App\Cliente','idpersona');
    }

}
