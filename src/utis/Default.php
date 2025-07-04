<?php

class FuncoesPadroes {
	// Valida se há agum valor nulo 
	public function validaCampoObrigatorio ( $valor ){

		if(  !isset($valor ) ){
			$this->returnJSON(401, [
		        'status' => false,
		        'erro' => 'Campo(s) do obrigatorio(s) body nulo(s)'
		    ]);
		    exit ;
		}

	}
 
	public function valorNull ( $vetor ){

		foreach ( $vetor as $itens){
			$aux = $itens ;
			if( !isset($itens) || empty( $itens ) || $itens === null || $itens === '' ){
				return false ;
			}
		}
		return true ; 
	}


	// Retorno josn status 
	public function returnJSON ( $cod , $descricaoRetorno  ){
		http_response_code( $cod );
		echo json_encode( $descricaoRetorno );
		exit;
	} 
	// Valida o body e executa a função, se for válido.
	public function executarSeValido ($listBody, callable $callback) {
		header('Content-Type: application/json');


	    if ($this->valorNull( $listBody) === true) {
	        return $callback($listBody); 
	        
	    }

	    $this->returnJSON(401, [
	        'status' => false,
	        'erro' => 'Corpo do body incorreto ou nulo'
	    ]);

	    exit;
	}
	// Retorno 401 para processos invalidos
	public function ret_json_401_Classcontrol ( $mesageErr , $dataDetalhe ){
		
		$this->returnJSON(
		    401,
		    [	
		        'status' => false, 
		        'message' => $mesageErr ,
		        'data' => $dataDetalhe ?? null
		    ]
		);
		exit;
	}
	// Retorno 200 para processos validados
	public function ret_json_200_Classcontrol( $msg , $ret ){
		($this->returnJSON(
		        200,
		        [	
		            'status' => true, 
		            'message' => $msg ,
		            'data' => $ret
		        ]
		    )
		);
	    exit;
	}

	public function condicoesIfReturnJSON ( $condicaoIF , $jsonT , $jsonF ){
		if( is_callable($condicaoIF)){
			$condicaoIF = $condicaoIF() ; 
		}

		if( $condicaoIF ){
			header('Content-Type: application/json');
 		 	http_response_code( 200 );
  		 	echo json_encode( $jsonT );
  		 	exit ;
		}

		header('Content-Type: application/json');
  		http_response_code( 500 );
		echo json_encode( $jsonF );
		exit ; 
	}


}

?>
