<?php
require_once '../config/conexaoDB.php';
require_once '../src/utis/Default.php';


 class Usuario extends DbPostgress {


    public static function addUser() {
        return 'Novo usuário apontado!';

    }


    public function addUser2( $nome  ,$sobrenome) {
        return "Novo usuário apontado! nome : $nome $sobrenome ";
    }
//--------------------
    // public function seleAll (){
	// 	return $this->crud_selectAll('SELECT * FROM acessos', []);
    // }


// ------ ativo   

    private function add ( $list ){
		$sqls = [
		    "INSERT INTO pessoa (cpf, nome, email, telefone, caminho_foto, sexo, funcao_na_empresa) VALUES ($1, $2, $3, $4, $5, $6, $7)",
		    "INSERT INTO acessos (login, senha) VALUES ($1, $2)"
		];
	 	
	    $list_par = [
	        array_slice($list, 0, 7),
	        [ $list[0], $list[7] ]
	    ];

		return  $this-> crud_edit_commit ( 2 , $sqls , $list_par); 
    }
    
    public function setAdd ( $list ){
		return $this->add( $list ) ;
    }

    // *************************

	private function upPerfil ( $list ){

    	$coluna = trim($list[0]); 

	    $valor = $list[1];  
	    $cpf = $list[2];   

		$params = [$valor, $cpf];
		
		$sql = "UPDATE pessoa SET \"$coluna\" = $1 WHERE cpf = $2";
		return $this->crud_edit($sql, $params);
	}

	public function setUpPerfil ( $list ){
		return $this->upPerfil( $list );
	}

	// *************************
	
	private function newPass ( $list ){
		$pass = $list[0];
		$id = $list[1];
		$sql = "UPDATE acessos SET senha = $1 WHERE login = $2";
		$param = [ $pass , $id ];
		return  $this->crud_edit($sql, $param);
	} 

	public function setNewPass ( $list ){
		return $this->newPass( $list );
	} 
	// *************************
	private function loginAuth($list) {
	    $usuario = $list[0];
	    $sql = "SELECT senha , id FROM acessos WHERE login = $1";
	    return $this->crud_select($sql, [$usuario]);
	}

	public function setLoginAuth($list) {
	    return $this->loginAuth( $list );
	}
	// *************************
	private function listSelf( $list ){
		$v = [ $list ] ;

 		$sql = "SELECT * FROM pessoa WHERE cpf = $1 ";
 	    return $this->crud_select( $sql, $v );
	}

	public function getListSelf ( $list ) {
		return $this->listSelf( $list );
	} 
	// *************************

	private function newPost ($list){
		$id = $list [ 0 ] ;
		$legenda = $list [ 1 ] ;

		$param = [ $id , $legenda ];

		$sql = "
		    INSERT INTO postagem (
		        id_autor,
		        caminho_arquivo,
		        legenda,
		        ativo
		    ) VALUES (
		        $1,
		        'sem arquivo',
		        $2,
		        true
		    )
		    RETURNING id
		";

		return  $this->crud_edit($sql, $param);
	}

	public function setNewPost ( $list ) {

		return $this->newPost( $list );
	} 

	// *************************

	private function onlyUsers ( $list ) {
		$sql = "
			SELECT 
			    ac.id,
			    pe.nome,
			    pe.email,
			    pe.telefone,
			    pe.caminho_foto,
			    pe.funcao_na_empresa
			FROM acessos ac
			INNER JOIN pessoa pe ON ac.login = pe.cpf
			WHERE ac.id = $1
		";

 	    return $this->crud_select( $sql, [$list[0] ]);
	}

	public function getOnlyUsers ( $list ) {
		return $this->onlyUsers( $list ) ;
	}
	
	// *************************  
	private function newPostFile( $list) {

	    try {
	        $id = $list[0];   
	        $legenda = $list[1];  
	        $file = $list[2]; 
	        $cpf = $list[3];   

	        $extensao = pathinfo($file['name'], PATHINFO_EXTENSION);
	        $novoNome = $cpf . "_" . $id . "_" . time() . "." . $extensao;
	        $destino = __DIR__ . '/../../public/upload/postagens/' . $novoNome;

	        if ( move_uploaded_file($file['tmp_name'], $destino)) {
	            $param = [$id, $legenda, $novoNome];

				$sql = "
				    INSERT INTO postagem (
				        id_autor,
				        caminho_arquivo,
				        legenda,
				        ativo
				    ) VALUES (
				        $1,
				        $3,
				        $2,
				        true
				    )
				    RETURNING id
				";


	            return $this->crud_edit($sql, $param);     
	        } else {
	            return ['status' => false, 'data' => 'Erro ao realizar o upload do arquivo.'];
	        }

	    } catch (Exception $err) {
	        return ['status' => false, 'data' => $err->getMessage()];
	    }
	}

	public function setNewPostFile ( $list  ){
		return $this->newPostFile ( $list );
	} 

	// *************************


} 
?>
