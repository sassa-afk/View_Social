<?php
require_once '../src/models/usuario.php';
require_once '../src/utis/Default.php';
require_once '../src/utis/jwt.php';
require_once '../src/rotas/RotasJWT.php';

class ControlUser  {
 
	private $user ;
 	private $def ;

    function __construct() {
        $this->user = new Usuario();
        $this->def = new FuncoesPadroes();
    }
 
    //--------- GET
    public function seleAl (){
    	(new FuncoesPadroes ())->ret_json_200_Classcontrol(
    		'Dados filtrados' ,
		    $this->user->seleAll()  
    	);
    }

    public function listSelf ($list){
 		$ret = $this->user->getListSelf( $list[0] );

 		$this->def->condicoesIfReturnJSON (
			isset( $ret['status'] ) && $ret['status'] === true,
			[ "message" => "Dados encontrados" , "data" => $ret['data']   ] ,
			[ "message" => "Erro ao realizar o processo" , "data" => $ret['data']   ]
		);
 	}

    //--------- POST 

	public function addUsuario($list){
	    $ret = $this->user->setAdd($list);	
	    $this->def->condicoesIfReturnJSON (
			isset( $ret['status'] ) && $ret['status'] === true,
			[ "message" => "Usuário adicionado com sucesso" , "data" => []   ] ,
			[ "message" => "Erro ao realizar o processo" , "data" => $ret['data']   ]
		);
	}

	public function loginAuth($list) {
	    $ret = $this->user->setLoginAuth( [$list[0]] ); 

	    if (
	        $ret['status'] === true &&
	        isset($ret['data'][0]['senha']) &&
		    password_verify( $list[1] , $ret['data'][0]['senha'])
	    ) {
	        $payload = [
	            'uid' => $ret['data'][0]['id'],
	            'cpf' => $list[0],
	            'id' => $ret['id']
	        ];

	        (new FuncoesPadroes())->ret_json_200_Classcontrol(
	            'Autenticação realizada com sucesso',
	            (new AuthJWT())->postNewTk($payload)
	        );
	    }

	    (new FuncoesPadroes())->ret_json_401_Classcontrol(
	        'Erro ao logar',
	        'Senha ou usuário incorretos'
	    );
	}

	public function addPost ( $list ){
		$ret = $this->user->setNewPost( $list );
		$this->def->condicoesIfReturnJSON (
			isset( $ret['status']) && $ret['status'] === true,
			[ "message" => "Postagem adicionado com sucesso" , "data" => $ret['data'] ],
			[ "message" => "Erro ao realizar o processo" , "data" => $ret['data']   ]
		);
	}

	public function addPostFile ( $list   ){ // <-----  

		$ret = $this->user->setNewPostFile( $list );
		$this->def->condicoesIfReturnJSON (
			isset( $ret['status']) && $ret['status'] === true,
			[ "message" => "Postagem adicionado com sucesso" , "data" => $ret['data']   ] ,
			[ "message" => "Erro ao realizar o processo" , "data" => $ret['data']   ]
		);
	}

	public function onlyUsers ($list){

		$ret = $this->user->getOnlyUsers( $list ); 
		$this->def->condicoesIfReturnJSON (
			isset( $ret['status']) && $ret['status'] === true,
			[ "message" => "Retorno da pesquisa" , "data" => $ret['data']   ] ,
			[ "message" => "Erro ao realizar o processo" , "data" => $ret['data']   ]
		);
	}

    //--------- PATH

	public function updateUser ($list){
		$ret = $this->user->setUpPerfil($list);

		$this->def->condicoesIfReturnJSON (
			isset( $ret['status'] ) && $ret['status'] === true ,
			[ "message" => "Dados do usuario editado com sucesso" , "data" => $ret['data']   ] ,
			[ "message" => "Erro ao realizar o processo" , "data" => $ret['data']   ]
		);		
 	}

 	public function newPass($list){
 		$ret = $this->user->setNewPass( $list ); 
 		$this->def->condicoesIfReturnJSON (
			isset( $ret['status'] ) && $ret['status'] === true ,
			[ "message" => "Senha editada com sucesso" , "data" => $ret['data']   ] ,
			[ "message" => "Erro ao realizar o processo" , "data" => $ret['data']   ]
		);
 	}



}
?>

 

