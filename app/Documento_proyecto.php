<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento_proyecto extends Model
{
    protected $table = 'documento_proyecto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['iddocumento','idproyecto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='iddocumentoproyecto';

    public $timestamps = false;
    
   public function proyecto(){
    	return $this->belongsTo('App\Proyecto','idproyecto');
    }
    public function documento(){
    	return $this->belongsTo('App\Documento','iddocumento');
    }
}
