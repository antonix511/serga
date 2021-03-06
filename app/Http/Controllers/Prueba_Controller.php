<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use File;

class Prueba_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
		echo date('Y-m-d H:i:s')."\n";
        echo \Mail::send('emails.prueba', ['name' => 'Reynolds'], function ($message) {

            $message->to('rgonzales@jp-planning.com')->subject('Prueba de correo SERGA - Office 365!');
			//$message->to('andrewsmoc@gmail.com')->subject('Prueba de correo SERGA - Office 365!');
        })."\n";
		echo date('Y-m-d H:i:s')."\n";
        echo \Mail::send('emails.prueba', ['name' => 'Reynolds'], function ($message) {

            $message->to('andrewsmoc@gmail.com')->subject('Prueba de correo SERGA - Office 365!');
        })."\n";
		echo date('Y-m-d H:i:s')."\n";
		//phpinfo();
    }


}
