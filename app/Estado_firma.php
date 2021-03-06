<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado_firma extends Model
{
   protected $table = 'estado_firma';

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
    protected $primaryKey ='idestadofirma';

    public $timestamps = false;
    
   public function seguimiento_proyecto(){
    	return $this->hasMany('App\Firmas','idestadofirma');
    }
}
