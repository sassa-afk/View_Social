<?php


if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}


require_once '../src/controllers/controlUser.php';
require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';
require_once '../src/utis/Default.php';

$aut = new AuxJWT();
$def = new FuncoesPadroes();
$user = new ControlUser ();

$body = json_decode(
	file_get_contents("php://input"),
	true
);

// header('Content-Type: application/json'); 

$method = $_SERVER['REQUEST_METHOD'];

$url = parse_url( $_SERVER['REQUEST_URI'] , PHP_URL_PATH );

// ----------------- ROTAS ----------------------
// ----------------------------------------------
 
if($method === 'POST'){


	// -------------- ROTA NOVO USUARIO
	if( $url === '/user/newUser'){
		$cpf = $body['cpf'] ?? null;
		$def->validaCampoObrigatorio( $cpf ) ;

		$nome = $body['nome'] ?? null;
		$def->validaCampoObrigatorio( $nome ) ;

		$email = $body['email'] ?? null;
		$def->validaCampoObrigatorio( $email ) ;

		$telefone = $body['telefone'] ?? null;
		$def->validaCampoObrigatorio( $telefone ) ;

		// $caminho_foto = $body['caminho_foto'] ?? 'caminho da pasta'; 

		$sexo = $body['sexo'] ?? null;
		$def->validaCampoObrigatorio( $sexo ) ;

		$funcao_na_empresa = $body['funcao_na_empresa'] ?? null;
		$def->validaCampoObrigatorio( $funcao_na_empresa ) ;

		$senha = $body['senha'] ?? null ;
		$def->validaCampoObrigatorio( $senha ) ;
		$senhaHash = password_hash($senha, PASSWORD_DEFAULT);


		$list = [
		    $cpf,
		    $nome,
		    $email,
		    $telefone,
		    "padrao vais ser",
		    $sexo,
		    $funcao_na_empresa,
		    $senhaHash
		];

		$def->executarSeValido(
			$list ,
			$user->addUsuario( $list ) 
		);
	}
	// -------------- ROTA LOGAR
	if ($url === '/user/login') {
	    $login = $body['user'];
		$def->validaCampoObrigatorio( $login ) ;

	    $senha = $body['pass'];
		$def->validaCampoObrigatorio( $senha ) ;

	    $list = [ $login, $senha ];  

	    $def->executarSeValido(
	        $list,
	        $user->loginAuth($list)
	    );
	}
	// -------------- ROTA ADD POST COMENTARDO
	if ( $url === '/user/add/newPostComentario'){

		$ret_auth = $aut->validaHeadToken(); 

		$legenda = $body['legenda'] ?? null;
 		$def->validaCampoObrigatorio( $legenda ) ;
 		$id = $ret_auth['uid'] ;

		$list = [ 
			$id,
			$legenda ,
		] ; 

		$def->executarSeValido(
			$list  , $user->addPost($list)
		);
	}
	// -------------- ROTA ADD POST COM IMAGEM
	if ( $url === '/user/add/newPostFile'){

	    $legenda = $_POST['legenda'] ?? 'sem legenda';
		$file = $_FILES['arquivo'] ?? null ;  

		$ret_auth = $aut->validaHeadToken(); 

		$def->validaCampoObrigatorio( $legenda );
		$def->validaCampoObrigatorio( $file );
		
		$id = $ret_auth['uid'] ;
		$cpf = $ret_auth['cpf'];

		$list = [ 
			$id,
			$legenda ,
			$file ,
			$cpf ,

		] ; 

		$def->executarSeValido(
			$list  , $user->addPostFile($list)
		);
	}

	



}


?>
