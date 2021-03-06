<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centro_costos extends Model
{
    protected $table = 'centro_costos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','numero','observaciones'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idcentro';

    public $timestamps = false;

    public function proyecto(){
    	return $this->belongsToMany('App\Proyecto','idproyecto');
    }
}
