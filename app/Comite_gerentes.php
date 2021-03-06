<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comite_gerentes extends Model
{
    protected $table = 'comite_gerentes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nacta','idarea','tema','fecha_hora','idencargado','revision','avances','encargados','fecha_prox_reu','hora'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idcomite';

    public $timestamps = false;

}
