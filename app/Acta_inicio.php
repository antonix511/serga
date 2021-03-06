<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acta_inicio extends Model
{
    protected $table = 'acta_inicio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','numero','codigo','descripcion','titular','carpeta','finicio','fentrega','fcierre',
    'bono','bono2','ambito','alcance','metodologia','calidad','cronograma'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //primary key
    protected $primaryKey ='idacta';
    public $timestamps = false;
    
    //foreign key
    public function documento(){
        return $this->belongsTo('App\Documento','iddocumento');
    }
    public function proyecto(){
        return $this->belongsTo('App\Proyecto','idproyecto');
    }
}
