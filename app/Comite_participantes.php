<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comite_participantes extends Model
{
    protected $table = 'comite_participantes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idcomite','idparticipante','cargo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idcomite_participantes';

    public $timestamps = false;

    function nompa()
    {
        return $this->belongsTo('App\Persona','idparticipante','idpersona');
    }
    function apepa()
    {
        return $this->belongsTo('App\Trabajador','idparticipante','idpersona');
    }


}
