<?php

require_once '../src/utis/jwt.php';



Class AuxJWT {


final public function validaHeadToken (){
	$header = getallheaders();

	if(!isset( $header['Authorization']) ){
		http_response_code( 401 );
		echo json_encode( [ 
			'status' => false , 
			'erro' =>  'token ausente ou inválido '
		]);
		exit ;
	}

	$authHeader = $header['Authorization'];

	if (strpos($authHeader, 'Bearer ') !== 0) {
		http_response_code(401);
		echo json_encode(['erro' => 'Formato inválido do token']);
		exit;
	}

	$token = trim(str_replace('Bearer ','' , $authHeader));
	$aut = new AuthJWT();
	$res = $aut->getValidaTk($token);

	if(!$res['valido']){
		http_response_code(401);
		echo json_encode([ 
			'status' => false , 
			'erro' => $res['erro']
		]);
		exit;
	}
    // return json_encode([
    //     'dados' => $res['dados']
    // ]);

    return  $res['dados'] ;
}

final public function newToken ($id , $nome , $cpf ) {
	$payload = ([
		'uid' => $id ,
		'nome' => $nome, 
		'cpf' => $cpf 
		// 'exp' => time() + 3600
	]);

	$aut = new AuthJWT() ;
	return $aut->postNewTk( $payload ) ; 
}


}

?>
