<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

	protected $table = 'area';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'descripcion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idarea';

    public $timestamps = false;
    //foreign key
    public function trabajador(){
    	return $this->hasOne('App\Trabajador','idarea');
    }
    //
}
