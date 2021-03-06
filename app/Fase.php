<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
 protected $table = 'fase';

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
    protected $primaryKey ='idfase';

    public $timestamps = false;
    
   public function seguimiento_proyecto(){
    	return $this->hasOne('App\Seguimiento_proyecto','idfase');
    }
   
}
