<?php


class AuthJWT { 


    private static $chave = 'chave_muito_secreta';
// -----------------------------------------------------------------
    private  function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private  function base64url_decode($data) {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
// -----------------------------------------------------------------

    private function newToken( $payload){

        $header = ['typ' => 'JWT', 'alg' => 'HS256'];

        $b64Header  = $this->base64url_encode( json_encode($header) );
        $b64Payload = $this->base64url_encode( json_encode($payload) );

        $assin = hash_hmac( 'sha256' , "$b64Header.$b64Payload" , $this->chave , true  );

        $base64Assinatura = $this->base64url_encode($assin);

		return  "$b64Header.$b64Payload.$base64Assinatura";
    }

    private function validaToken( $token ){

    	$token_dividido = explode('.',$token);

		if (count($token_dividido) !== 3) {
    		return [
    			'valido' => false ,
    			'error' => 'Token malformado'
    		];
    	}

    	list($b64Header, $b64Payload, $b64Assinatura) = $token_dividido;
    	
    	$assinaturaCheck = hash_hmac(
    		'sha256', 
    		"$b64Header.$b64Payload", 
    		$this->chave, true
    	);
		
		$assinaturaCheckEncoded = $this->base64url_encode($assinaturaCheck);

        if ($b64Assinatura !== $assinaturaCheckEncoded) {
            return [
                'valido' => false,
                'erro' => 'Assinatura inválida'
            ];
        }

        $payload = json_decode($this->base64url_decode($b64Payload), true);

        if (isset($payload['exp']) && time() > $payload['exp']) {
            return [
                'valido' => false,
                'erro' => 'Token expirado'
            ];
        }

        return [
            'valido' => true,
            'dados' => $payload ,
            'cpf' => $payload['cpf']
        ];
    }

// -----------------------------------------------------------------

    public function postNewTk( $payload ){
    	//payload = ([
    	//'uid' => 1,
    	//'nome' => 'Lucas',
    	// 'exp' => time() + 3600
    	// ]);
        // return  json_encode([ "mesage" => "olamundo"]);
    	$token = $this->newToken($payload);
        return $this->newToken($payload);
    }

    public function getValidaTk( $token ){
    	return $this->validaToken($token);
    }


} 




?>
