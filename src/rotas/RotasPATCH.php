<?php

require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';
require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';
require_once '../src/utis/Default.php';
require_once '../src/controllers/controlUser.php'; // <----- crt user

$method = $_SERVER['REQUEST_METHOD'];
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$body = json_decode(
	file_get_contents("php://input"),
	true
);

if($method === 'PATCH'){
	// ** USUARIO **

	// -------------- ROTA EDITAR DADOS DO PROPIO USUARIO
	if( $url === '/user/update/selfPerfil' ){
		
		$campo = $body['campo'] ?? null ;
		$def->validaCampoObrigatorio( $campo ) ;
		
		$novoDados = $body['dados'] ?? null ; 
		$def->validaCampoObrigatorio( $novoDados ) ;

		$auth = $aut->validaHeadToken(); 

	    if(
	    	!in_array( $campo, 
	    		["nome","sexo", "email", "telefone", "funcao_na_empresa"]
	    	)
		)

		{
			$def->returnJSON(401, [
		        'status' => false,
		        'erro' => 'Esta rota não permite editar este campo'
		    ]);
		    exit ;
		}

		$list = [ 
			$campo ?? null , 
			$novoDados ?? null , 
			$auth['cpf'] ?? null 
		];



		$def->executarSeValido( 
			$list , $user->updateUser( $list ) 
		);
	}
	// -------------- ROTA TROCAR SENHA
	if( $url === '/user/update/selfPass' ){
		$pass = $body['pass'] ?? null ;
		$def->validaCampoObrigatorio( $pass ) ;
		$passHash = password_hash( $pass, PASSWORD_DEFAULT );
		$auth = $aut->validaHeadToken();
		$list = [
			$passHash , 
			$auth['cpf']
		];

		$def->executarSeValido( 
			$list , $user->newPass( $list ) 
		);
	}	


	// -------------- 


}


 

?>
