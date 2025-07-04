
<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require BASE_PATH . '/src/rotas/Rotas.php' ;
 

// $method = $_SERVER['REQUEST_METHOD'];
// $url = parse_url ( $_SERVER['REQUEST_URI'] , PHP_URL_PATH);

// $body = json_decode(
// 		file_get_contents("php://input"),
// 		true 
// 	);



// // ------- GET ---------

// if ( $method === 'GET' ) {

// 	  if( $url === '/pg/inicio' ){
// 	  	header('Content-Type: text/html'); 
// 	  	http_response_code(200);
//     	require_once BASE_PATH . '/src/web/pg1.php';
//     	exit;
//     	// http://localhost:8080/api/pag
// 	  }

// 	  if( $url === '/pg/usuario'){
// 	  	header('Content-Type: text/html'); 
//     	require_once BASE_PATH . '/src/web/pg1.php';
//     	exit;
// 	  }
// }


// // ------- POST ---------
// else if ($method === 'POST') {

//     if ($url === '/usuario/novoUsuario') {
//         header('Content-Type: application/json');

//         $nome = $body['nome'] ?? null;
//         $sobrenome = $body['sobrenome'] ?? null;

//         if ($nome && $sobrenome) {
//             http_response_code(200);
//             echo json_encode([
//                 "status" => "success",
//                 "message" => "Usuário enviado com sucesso",
//                 "data" => [
//                     "nome" => $nome,
//                     "sobrenome" => $sobrenome
//                 ]
//             ]);
//             exit;
//         } else {
//             http_response_code(400);
//             echo json_encode([
//                 "status" => "error",
//                 "message" => "Nome e sobrenome são obrigatórios"
//             ]);
//             exit;
//         }
//     }
// }


?>