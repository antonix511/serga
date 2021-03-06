<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
   protected $table = 'puesto';

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
    protected $primaryKey ='idpuesto';
 
}
