<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acta_cierre extends Model
{
    //
     protected $table = 'acta_cierre';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto', 'descripcion','titular','gerente','jefe','finicio','fentrega','fcierre','iddocumento','resultado','etapa','descripcion2','consecuencia','accion','observaciones'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idacta_cierre';

    public $timestamps = false;
    //foreign key
    public function documento()
    {
        return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
    //
}
