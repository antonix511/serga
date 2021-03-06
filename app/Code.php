<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
 protected $table = 'code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','descripcion','cliente','documento','proyecto','codigo','correlativo', 'idtrabajador_registro'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idcode';

    public $timestamps = false;


    public function proyecto()
    {
        return $this->belongsTo('App\Proyecto','proyecto','idproyecto');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Trabajador','idtrabajador_registro','idtrabajador');
    }

}
