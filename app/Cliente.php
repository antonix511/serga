<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ruc', 'abreviatura', 'contacto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idcliente';

    public $timestamps = false;
    
    //foreign key
    public function persona(){
    	return $this->belongsTo('App\Persona','idpersona');
    }
     public function proyecto(){
    	return $this->belongsTo('App\Proyecto','idproyecto');
    }

}
