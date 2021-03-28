<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguimiento_proyecto extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seguimiento_proyecto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idfase',
        'idproyecto',
        'vs',
        'p_vs',
        'vc',
        'p_vc',
        'idc',
        'ids',
        'pv_total',
        'fecha_registro',
        'fecha_seguimiento',
        'ultimo_int',
        'estado'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idseguimiento';

    public $timestamps = false;
    
    //foreign key
    public function proyecto () {
    	return $this->belongsTo('App\Proyecto','idproyecto');
    }
    public function fase () {
        return $this->belongsTo('App\Fase','idfase');
    }

    public function historial()
    {
        return $this->hasMany(HistorialSeguimiento::class, 'id_seguimiento');
    }
}
