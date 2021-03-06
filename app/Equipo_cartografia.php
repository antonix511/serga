<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo_cartografia extends Model
{
    protected $table = 'equipo_cartografia';

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
    protected $primaryKey ='idequipo';

    public $timestamps = false;
}
