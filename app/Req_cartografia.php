<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Req_cartografia extends Model
{
    //
    	protected $table = 'req_cartografia';

    	protected $fillable = ['idproyecto','fecha', 'idjefegerente', 'idsolicitante','colaborador','fecha_entrega','iddocumento','numero_requerimiento'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idcartografia';

    public $timestamps = false;
    public function jefe(){
        return $this->belongsTo('App\Persona','idjefegerente','idpersona');
    }

    public function solicitante(){
        return $this->belongsTo('App\Persona','idsolicitante','idpersona');
    }

    public function nomcolabora(){
        return $this->belongsTo('App\Persona','colaborador','idpersona');
    }
    public function apecolabora(){
        return $this->belongsTo('App\Trabajador','colaborador','idpersona');
    }

    public function documento(){
        return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
}
