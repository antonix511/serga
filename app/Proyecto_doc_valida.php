<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto_doc_valida extends Model
{
   	protected $table = 'proyecto_doc_valida';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idproyecto','iddocumento', 'valida'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey = ['idproyecto', 'iddocumento'];

    public $timestamps = false;

    public $incrementing = false;
    
    //foreign key
    


}
