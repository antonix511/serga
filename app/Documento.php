<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
     protected $table = 'documento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['documento','abreviatura','idfase'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='iddocumento';

    public $timestamps = false;
    
   public function documento_proyecto(){
    	return $this->hasOne('App\Documento_proyecto','iddocumento');
    }
}
