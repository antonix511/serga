<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firmas extends Model
{
    protected $table = 'firmas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = ['idproyecto','iddocumento','idtrabajador','idestadofirma','idacta'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idfirma';

    public $timestamps = false;

    public function proyecto(){
    	return $this->belongsToMany('App\Proyecto','idproyecto');
    }
    public function trabajador(){
    	return $this->belongsToMany('App\Trabajador','idpersona');
    }
    public function documento(){
    	return $this->belongsToMany('App\Documento','iddocumento');
    }
    public function estado_firma(){
    	return $this->belongsToMany('App\Estado_firma','idestadofirma');
    }
    public function proyecto_firma(){
        return $this->belongsTo('App\Proyecto','idproyecto');
    }
    public function trabajador_firma(){
        return $this->belongsTo('App\Trabajador','idpersona','idtrabajador');
    }
    public function documento_firma(){
        return $this->belongsTo('App\Documento','iddocumento');
    }
    public function estado_firma_firma(){
        return $this->belongsTo('App\Estado_firma','idestadofirma');
    }
}
