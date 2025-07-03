<?php

require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';
require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';
require_once '../src/utis/Default.php';
require_once '../src/controllers/controlUser.php'; // <----- crt user

require_once '../src/controllers/controlPostes.php'; // <----- crt user

define('BASE_PATH',  dirname(__DIR__));

$crtUser = new ControlUser();

$method = $_SERVER['REQUEST_METHOD'];
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$def = new FuncoesPadroes();
$aut = new AuxJWT();
$user = new ControlUser() ;
$post = new ControlPostes() ;



if ($method === 'GET') {


// ----------- PAGINAS && FIles ----------

    header('Content-Type: text/html'); 
    
    if ($url === '/pg/inicio') {
        http_response_code(200);
        require_once BASE_PATH . '/src/web/pg1.php';
        exit; 
    }


// -------------- APIS -------------
	header('Content-Type: Application/json');

    if( $url === '/user/list/self'){

		$auth = $aut->validaHeadToken(); 
		$list = [$auth['cpf']] ; 
		
		$def->executarSeValido(
			$list  , $user->listSelf($list)
		);
    }

// -------------- ativos  -------------
    
    if( $url === '/usuarios/list/onlyUsers'){ // <<< 
    	

    	$id = $_GET['id'] ?? null ;

    	$def->validaCampoObrigatorio( $id ) ;

		
		$id = isset($id)
    	 && is_numeric($id) ? 
    	 (int)$id : null;
		
		$auth = $aut->validaHeadToken();
		
		$list = [ $id ]; 
		$def->executarSeValido(
			$list ,
			$user-> onlyUsers( $list ) 
		);
    }

    if( $url === '/postes/view/all'){

    	$auth = $aut->validaHeadToken(); 
		$list = [ 
			$auth['cpf'] 
		] ;

		$def->executarSeValido(
			$list  , 
			$post->listAllPost(  )
		);
    }

    if( $url === '/postes/view/limit' ){
    	$limit = isset($_GET['limit'])  && 
    	is_numeric($_GET['limit']) ? (int)$_GET['limit'] : null;

		$auth = $aut->validaHeadToken(); 
    	$list = [ 
     		$limit
    	] ; 

    	$def->executarSeValido(
    		$list ,
    		$post->listAllLimit( $list )
    	);
    }


// --------------------------------------------------------
    if( $url === '/postes/view/down/file'){


    	$id_postagem = $_GET['id'];

    	$auth = $aut->validaHeadToken();
 
     	$def->validaCampoObrigatorio( $id_postagem );

    	$list =[
     		$id_postagem , 
    	];

    	// echo json_encode([ "msf" =>"ss"]);
    	// exit ;

    	$def->executarSeValido(
    		$list , $post->dowFilePost( $list ) 
    	);
    }

    // if( $url === '/postes/view/selfPost'){
    // 	$auth = $aut->validaHeadToken();
    // 	$list = [
    // 		$
    // 	]
    
    // }


 

}

// OBS : CRIAR ROTA VER USUARIOS REGISTRADOS NO MODEL USUARIOS
?>
