<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Trabajador;
use App\Persona;
use App\Proyecto;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    public function ValidarProyectos(){
        $fechafin=date ('Y-m-d',strtotime('+3 day',strtotime (date("Y-m-d")) ) );
        $fechainicio=date ('Y-m-d',strtotime('-4 day',strtotime (date("Y-m-d")) ) );
        $proyecto = Proyecto::select('*')->where('fentrega', '<=', $fechafin)->where('fentrega', '>=', $fechainicio)->where('estado','=',1)->get();
        return $proyecto;
    }
    public function validarLogin(Request $request){
        
        $persona = Trabajador::where('usuario', $request->usuario)->where('estado',1)->first();
        if(empty($persona)):
            return  view('index', ['errorusuario' => 'El usuario no existe']);
        else:
            if($request->clave==$persona->clave):
              
                if($request->remember !=null):
                    Auth::login($persona,true);
                else:
                    Auth::login($persona);
                endif;
                $trabajador= Trabajador::select('foto')->where('usuario', $request->usuario)->where('estado',1)->first();
                session_start();
                $_SESSION['usuario']=$request->usuario;
                $_SESSION['idpersona']=$persona->idpersona;
                $_SESSION['foto']=$trabajador->foto;
                $_SESSION['proyectos']=$this->ValidarProyectos();
                return  redirect('/inicio');
            else:
                return  view('index',['errorcontraseña' => 'La contraseña es incorrecta']);
            endif;
        endif;

        

    }
    public function Cerrarsesion(){
        Auth::logout();
        return redirect()->route('index');

    }

    public function registrarTrabajor(Request $request){



    }

}
