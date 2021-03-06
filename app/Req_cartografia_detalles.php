<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Req_cartografia_detalles extends Model
{
    //
    protected $table = 'req_cartografia_detalles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idreqcartografia','cantidad','fecha_devolucion','idequipo','observaciones'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idreqcartodeta';

    public $timestamps = false;
    public function equipo(){
        return $this->belongsTo('App\Equipo_cartografia','idequipo','idequipo');
    }

}
