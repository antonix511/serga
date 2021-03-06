<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud_ac extends Model
{
    protected $table = 'solicitud_ac';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','nombre','direccion','iddocumento'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idsolicitudac';

    public $timestamps = false;
}
