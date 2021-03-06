<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilegio_modulo extends Model
{
    protected $table = 'privilegio_modulo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idprivilegio','idmodulo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idprivmodulo';
    
    public $timestamps = false;
    public function modulos(){
        return $this->belongsTo('App\Modulo','idmodulo','idmodulo');
    }
    public function Privilegio(){
        return $this->belongsTo('App\Privilegio','idprivilegio','idprivilegio');
    }
}
