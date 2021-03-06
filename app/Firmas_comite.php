<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firmas_comite extends Model
{
    protected $table = 'firmas_comite';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['iddocumento','idtrabajador','idestadofirma','idcomite'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idfirma';

    public $timestamps = false;

    public function trabajador(){
    	return $this->belongsToMany('App\Trabajador','idpersona');
    }
    public function documento(){
    	return $this->belongsToMany('App\Documento','iddocumento');
    }
    public function estado_firma(){
    	return $this->belongsToMany('App\Estado_firma','idestadofirma');
    }
}
