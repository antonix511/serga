<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporte_ho extends Model
{
    protected $table = 'reporte_ho';

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
    protected $primaryKey ='idreporteho';

    public $timestamps = false;
    
}
