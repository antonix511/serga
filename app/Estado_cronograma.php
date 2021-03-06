<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_cronograma extends Model
{
    protected $table = 'estado_cronograma';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['descripcion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idestado_cro';
    public $timestamps = false;
    
}
