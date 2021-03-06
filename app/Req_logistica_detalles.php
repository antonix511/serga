<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Req_logistica_detalles extends Model
{
    protected $table = 'req_logistica_detalles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idreqlogis','idlogistica','cantidad','idunidad','descripcion','idpersona'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idreqlogisdeta';

    public $timestamps = false;
    public function logistica(){
        return $this->belongsTo('App\Logistica_mantenimiento','idlogistica','idlogistica');
    }

    public function unidad(){
        return $this->belongsTo('App\Unidad_medida','idunidad','idunidad');
    }

    public function persona(){
        return $this->belongsTo('App\Persona','idpersona','idpersona');
    }
    public function trabajador(){
        return $this->belongsTo('App\Trabajador','idpersona','idpersona');
    }
}
