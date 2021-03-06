<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialSeguimiento extends Model
{
    protected $table = 'historial_seguimiento';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_seguimiento',
        'fecha_seguimiento',
        'costo_avance',
        'vc',
        'p_vc',
        'idc',
        'vs',
        'p_vs',
        'ids',
        'comentario',
        'ev',
        'ac',
        'pv',
        'estado'
    ];

    public $timestamps = false;

    public function seguimiento()
    {
        return $this->belongsTo(Seguimiento_proyecto::class, 'id_seguimiento');
    }
}
