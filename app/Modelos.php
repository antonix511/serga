<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelos extends Model
{
    protected $table = 'modelos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo','idtipodoc','nombre','archivo','idtipo_modelo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idmodelo';

    public $timestamps = false;

    public function documento(){

        return $this->belongsTo('App\Tipo_documento','idtipodoc','idtipodocumento');
    }
    public function TipoModelo(){

        return $this->belongsTo('App\Tipo_modelo','idtipo_modelo','idtipo_modelo');
    }
    
}
