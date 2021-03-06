<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo_trabajo extends Model
{
   protected $table = 'equipo_trabajo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','idtrabajador'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idequipo';

    public $timestamps = false;

    public function proyecto(){
    	return $this->belongsToMany('App\Proyecto','idproyecto');
    }
    public function trabajador(){
    	return $this->belongsToMany('App\Trabajador','idpersona');
    }
    public function nombre(){
        return $this->belongsTo('App\Persona','idtrabajador','idpersona');
    }
    public function apellido(){
        return $this->belongsTo('App\Trabajador','idtrabajador','idpersona');
    }
}
