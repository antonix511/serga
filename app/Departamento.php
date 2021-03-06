<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamento';

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
    protected $primaryKey ='iddepartamento';

    public $timestamps = false;
    
    //iddepartamento esta en Proyecto
    //un proyecto tienen un solo departamento
    public function proyecto(){
        return $this->hasMany('App\Proyecto','iddepartamento');
    }
}
