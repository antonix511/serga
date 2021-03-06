<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    //
    protected $table = 'provincia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','iddepartamento'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idprovincia';

    public $timestamps = false;

    //provincia tiene iddepartamento, 
    //un departamento puede tener varias provincias
    public function departamento(){
    	return $this->belongsToMany('App\Departamento','iddepartamento');
    }
    
    //idprovincia esta en Distrito

    public function distrito(){
        return $this->hasOne('App\Distrito','idprovincia');
    }
    public function proyecto(){
        return $this->hasMany('App\Proyecto','idprovincia');
    }
}
