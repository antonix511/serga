<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_documento extends Model
{
   protected $table = 'tipo_documento';

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
    protected $primaryKey ='idtipodocumento';

    public $timestamps = false;
    
    //foreign key
}
