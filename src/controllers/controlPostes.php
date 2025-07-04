<?php

require_once '../src/models/postagens.php';
require_once '../src/utis/Default.php';
require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';

class ControlPostes {

	private $conx ;
	private $def ; 

    function __construct() {
        $this->conx = new Postagens ();
        $this->def = new FuncoesPadroes() ;
    }

	public function  listAllPost ( ) {
		$ret = $this->conx->getListAllPostes();

		header('Content-Type: application/json');
		
		$this->def->condicoesIfReturnJSON (
			$ret['status'] === true ,
			[ "message" => "Retorno da consulta" ,"data" => $ret['data'] ?? null ] ,
			[ "message" => "Erro no processo " ,"data" => $ret['data'] ?? null ]
		);
	}
 
	public function  listAllLimit ( $list ) {
		$ret = $this->conx->getListAllLimit( $list  )  ;
		$this->def->condicoesIfReturnJSON (
			$ret['status'] === true ,
			[ "message" => "Retorno da consulta" ,"data" => $ret['data'] ?? null ] ,
			[ "message" => "Erro no processo " ,"data" => $ret['data'] ?? null ]
		);
	}

	public function dowFilePost( $list ){

		$ret = $this->conx->getFileDownPost( [ $list ]  )  ;

		$this->def->condicoesIfReturnJSON ( 
			$ret['status'] === true ,
			[ "message" => "Retorno da consulta","data" => $ret['data'][0]['caminho_arquivo'] ] ,
			[ "message" => "Erro no processo " ,"data" => $ret['data'] ?? null ]
		); 

	}


}

?>
