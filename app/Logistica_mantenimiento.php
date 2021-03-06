<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logistica_mantenimiento extends Model
{
    protected $table = 'logisitica_mantenimiento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idlogistica';

    public $timestamps = false;
    
    //iddepartamento esta en Proyecto
    //un proyecto tienen un solo departamento
    public function req_logistica_detalles(){
        return $this->hasMany('App\Req_logistica_detalles','idlogistica');
    }
}
