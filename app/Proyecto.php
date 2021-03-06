<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
   	protected $table = 'proyecto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ndocumento',
        'code',
        'fecha',
        'idcliente',
        'contacto',
        'nombre',
        'idservicio',
        'descripcion',
        'iddepartamento',
        'idprovincia',
        'iddistrito',
        'gerente',
        'jefe',
        'presupuesto',
        'idmoneda',
        'idtipoproyecto',
        'idtipocontrato',
        'faceptacion',
        'finicio',
        'fentrega',
        'centrodecosto',
        'presupuestoadicional',
        'observacion',
        'idtrabajador',
        'correo',
        'idtrabajador2',
        'correo2',
        'notificar',
        'anio',
        'correlativo'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idproyecto';

    public $timestamps = false;
    
    //foreign key
    public function cliente(){
    	return $this->belongsTo('App\Cliente','idcliente');
    }
    public function servicio(){
        return $this->belongsTo('App\Servicio','idservicio');
    }
    public function ubicacion(){
        return $this->belongsTo('App\Ubicacion','idubicacion');
    }
    public function gerente(){
        return $this->belongsTo('App\Trabajador','idpersona');
    }
    public function jefe(){
        return $this->belongsTo('App\Trabajador','idpersona');
    }
    public function tipo_proyecto(){
        return $this->belongsTo('App\Tipo_proyecto','idtipoproyecto');
    }
    public function tipo_contrato(){
        return $this->belongsTo('App\Tipo_contrato','idtipocontrato');
    }
    public function trabajador(){
        return $this->belongsTo('App\Trabajador','idpersona');
    }
    public function seguimiento_proyecto(){
        return $this->hasMany('App\Seguimiento_proyecto','idproyecto');
    }
    public function documento_proyecto(){
        return $this->hasMany('App\Documento_proyecto','idproyecto');
    }
    public function persona(){
        return $this->belongsTo('App\Persona','idcliente','idpersona');
    }
    public function distrito(){
        return $this->belongsTo('App\Distrito','iddistrito','iddistrito');
    }
    public function departamento(){
        return $this->belongsTo('App\Departamento','iddepartamento','iddepartamento');
    }
    public function provincia(){
        return $this->belongsTo('App\Provincia','idprovincia','idprovincia');
    }
    public function retornar_gerente(){
        return $this->belongsTo('App\Persona','gerente','idpersona');
    }
    public function retornar_jefe(){
        return $this->belongsTo('App\Persona','jefe','idpersona');
    }
    public function retornar_gerente_apellido(){
        return $this->belongsTo('App\Trabajador','gerente','idpersona');
    }
    public function retornar_jefe_apellido(){
        return $this->belongsTo('App\Trabajador','jefe','idpersona');
    }
    public function retornar_tipProyecto(){
        return $this->belongsTo('App\Tipo_proyecto','idtipoproyecto','idtipoproyecto');
    }
    public function retornar_tipContrato(){
        return $this->belongsTo('App\Tipo_contrato','idtipocontrato','idtipocontrato');
    }
    public function notificado1(){
        return $this->belongsTo('App\Persona','idtrabajador','idpersona');
    }
    public function notificado2(){
        return $this->belongsTo('App\Persona','idtrabajador2','idpersona');
    }

    public function cronograma()
    {
        return $this->hasMany(Cronograma::class, 'idproyecto');
    }

}
