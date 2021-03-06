<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distrito';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','idprovincia'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='iddistrito';

    public $timestamps = false;

    //provincia tiene iddepartamento, 
    //un departamento puede tener varias provincias
    public function provincia(){
    	return $this->belongsToMany('App\Provincia','idprovincia');
    }
    
    
    public function proyecto(){
        return $this->hasMany('App\Proyecto','idprovincia');
    }
}
