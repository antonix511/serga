<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acta_acuerdo_detalle extends Model
{
    //

    //
     protected $table = 'acta_acuerdo_detalle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idacta_acuerdo','fecha', 'actividad'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idactaacuerdodet';

    public $timestamps = false;
    //foreign key
    public function documento()
    {
        return $this->belongsTo('App\Documento','iddocumento','iddocumento');
    }
}
