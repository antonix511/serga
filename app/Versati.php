<?php

namespace App;

use Mail;

class Versati {
 
    public static function _send_sms($celular, $mensaje) {
        if(strlen($celular) < 9){
			return FALSE;
		}else if(strlen($celular) == 9){
			$celular = '51' . $celular;
		}

		$mensaje = substr(self::_clean_string_sms($mensaje),0,160);

		$token = 'dGVzdGluZ0B2Y2MuZGlnaXRhbDpWZTVHRkQ1ZyRV'; 

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "{ \"from\":\"SERGA\", \"to\":\"".$celular."\", \"text\":\"".$mensaje."\" }",
		  CURLOPT_HTTPHEADER => array(
		    "accept: application/json",
		    "authorization: Basic ".$token,
		    "content-type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return FALSE;
		} else {
		  $response = @json_decode($response);
		  if(isset($response->messages[0]->messageId)){
		  	return @$response->messages[0]->messageId;
		  }
		}

		return FALSE;

    }

    public static function _clean_string_sms($string)
	{
	 
	    $string = trim($string);
	 
	    $string = str_replace(
	        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
	        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
	        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
	        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
	        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
	        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
	        $string
	    );
	 
	    $string = str_replace(
	        array('ñ', 'Ñ', 'ç', 'Ç'),
	        array('n', 'N', 'c', 'C',),
	        $string
	    );
	 
	    //Esta parte se encarga de eliminar cualquier caracter extraño
	    $string = str_replace(
	        array("\\", "¨", "º", "~",
	             "#", "@", "|", "!", "\"",
	             "·", "$", "%", "&", "/",
	             "(", ")", "?", "'", "¡",
	             "¿", "[", "^", "<code>", "]", "}", "{", "¨", "´",
	             ">", "< "),
	        '',
	        $string
	    );
	 
	 
	    return $string;
	}

	public static function _send_mail($para, $asunto, $mensaje, $cabecera = '') {
		$envio = Mail::send('emails.html', ['mensaje' => $mensaje, 'para' => $para], function ($message) use ($para) {
            $message->to($para)->subject($asunto);
        });
        return (int)$envio;
	}

 
}