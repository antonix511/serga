<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_contrato extends Model
{
     protected $table = 'tipocontrato';

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
    protected $primaryKey ='idtipocontrato';

    public $timestamps = false;
    
    //foreign key

     public function proyecto(){
    	return $this->belongsTo('App\Proyecto','idproyecto');
    }
}
