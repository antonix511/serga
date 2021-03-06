<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecciones_aprendidas extends Model
{
    protected $table = 'lecciones_aprendidas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','iddocumento','descripcion_situacion','descripcion','consecuencia','accion','concepto','etapa'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idlecciones';

    public $timestamps = false;

    public function documento(){
    	return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
}
