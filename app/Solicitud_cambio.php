<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud_cambio extends Model
{
    //

     protected $table = 'solicitud_cambio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto', 'fecha','motivo_tiempo','motivo_costo','motivo_alcance', 'motivo_sgc','medio','descripcion','nombre','cargo','iddocumento', 'fecha_entrega'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idsolicitud';

    public $timestamps = false;
    //foreign key
    function documento(){
        return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
}
