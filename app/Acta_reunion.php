<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acta_reunion extends Model
{
    //
    protected $table = 'acta_reunion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto', 'nacata','area_proyecto','tema','fecha','idencargado','temas','acciones','fecha_requerida','iddocumento','hora'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idacta_reunion';

    public $timestamps = false;
    //foreign key
    public function trabajador(){
    	return $this->hasOne('App\Persona','idencargado','idpersona');
    }

    public function documento()
    {
        return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
    public function area()
    {
        return $this->belongsTo('App\Area','area_proyecto','idarea');
    }
    //
}
