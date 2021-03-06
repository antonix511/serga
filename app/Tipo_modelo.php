<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_modelo extends Model
{
    protected $table = 'tipo_modelo';

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
    protected $primaryKey ='idtipo_modelo';

    public $timestamps = false;

    
}
