<?php
ob_start();

require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';
require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';
require_once '../src/utis/Default.php';
require_once '../src/controllers/controlUser.php'; // <----- crt user
require_once '../src/controllers/controlPostes.php'; // <----- crt post


if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}


$crtUser = new ControlUser();

$method = $_SERVER['REQUEST_METHOD'];
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$def = new FuncoesPadroes();
$aut = new AuxJWT();
$user = new ControlUser() ;
$post = new ControlPostes() ;


// ----------- PAGINAS && FIles ----------

// if ($method === 'GET') {

//     if ($url === '/pg/inicio') {
// 	    header('Content-Type: text/html'); 
//         http_response_code(200);
//         require_once BASE_PATH . '/src/web/pg1.php';
//         exit; 
//     }

// }


if ($method === 'GET') {
	// -------------- APIS -------------

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
     		$id_postagem 
    	];

    	$def->executarSeValido(
    		$list , $post->dowFilePost( $list ) 
    	);
    }
}

ob_end_flush();

?>
