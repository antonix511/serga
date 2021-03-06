<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acta_acuerdo extends Model
{
    //
     protected $table = 'acta_acuerdo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto', 'fecha_hora','tema','revision','acuerdos','iddocumento','fecha_prox_reu', 'numero_acta','cronograma','hora'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idacta_acuerdo';

    public $timestamps = false;
    //foreign key
    public function documento()
    {
        return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
    
    //
}
