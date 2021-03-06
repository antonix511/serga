<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    protected $table = 'cronograma';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = ['idproyecto','version','nombre','archivo','por_planificado','por_anterior','por_actual','idestado_cro'];
    protected $fillable = [
        'idproyecto',
        'version',
        'nombre',
        'archivo',
        'vp_archivo',
        'nro_intervalos',
        'nro_tareas',
        'nro_dias'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idcronograma';

    public $timestamps = false;

    public function proyecto(){
    	return $this->belongsTo('App\Proyecto','idproyecto');
    }

//    public function estado_cro(){
//        return $this->belongsTo('App\Estado_cronograma','idestado_cro','idestado_cro');
//    }
}
