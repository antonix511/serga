<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Req_logistica extends Model
{
    protected $table = 'req_logistica';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','nrequerimiento','fecha','fecha_entrega','idjefegerente','idsolicitante','observacion','iddocumento'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idreqlogis';

    public $timestamps = false;
    
    public function jefe(){
        return $this->belongsTo('App\Persona','idjefegerente','idpersona');
    }


    public function solicitante(){
        return $this->belongsTo('App\Persona','idsolicitante','idpersona');
    }
    public function apejefe(){
        return $this->belongsTo('App\Trabajador','idjefegerente','idpersona');
    }
    

    public function apesolicitante(){
        return $this->belongsTo('App\Trabajador','idsolicitante','idpersona');
    }

    public function documento(){
        return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
    
}
