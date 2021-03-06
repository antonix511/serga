<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Trabajador extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trabajador';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['dni','apellidos','idarea','idpuesto','usuario','idprivilegio','foto','firma','clave','abreviatura'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    //primary key
    protected $primaryKey ='idtrabajador';

    public $timestamps = false;

    //foreign key
    public function persona(){
    	return $this->belongsTo('App\Persona','idpersona');
    }

    public function area(){
    	return $this->belongsTo('App\Area','idarea');
    }

    public function puesto(){
    	return $this->belongsTo('App\Puesto','idpuesto');
    }

    public function privilegio(){
    	return $this->belongsTo('App\Privilegio','idprivilegio');
    }

    public function setAttribute($key, $value)
  {
    $isRememberTokenAttribute = $key == $this->getRememberTokenName();
    if (!$isRememberTokenAttribute)
    {
      parent::setAttribute($key, $value);
    }
  }


}
