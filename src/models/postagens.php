<?php

require_once '../config/conexaoDB.php';
require_once '../src/utis/Default.php';

class Postagens extends  DbPostgress {


    //--------- GET

    // ************

	private function listAllPostes(  ){
    	$sql = "SELECT * FROM postagem ";
    	return $this->crud_selectAll( $sql , [] );	
	}
    public function getListAllPostes ( ) {
    	return $this->listAllPostes();
    }

	// ************

    private function listAllLimit ( $list ) {
    	$qtdLimt = $list[0];
		$sql = "
	    	SELECT * FROM postagem
			ORDER BY id DESC
			LIMIT $qtdLimt
     	";
    	return $this->crud_selectAll( $sql , [] );
    }
    public function getListAllLimit ($list ) {
    	return $this->listAllLimit( $list );
    }
	// ************

	private function listAllPostSelf ( $list ){ 
		$id = $list[0];
		$sql = "
			SELECT * FROM postagem 
			WHERE id_autor = $1 AND
			ativo = true 
		";

    	return $this->crud_selectAll( $list , $list[0] );
	}

	private function getListAllPostSelf ( $list ){ 
    	return $this->listAllPostSelf( $list );
	}

	// ************

private function fileDownPost($list) {
    $sql = " 
        SELECT caminho_arquivo
        FROM postagem
        WHERE id = $1
    ";

    $ret = $this->crud_select($sql, [$list[0]]);

    if ($ret['status'] === true && isset($ret['data'][0]['caminho_arquivo']) && $ret['data'][0]['caminho_arquivo'] !== 'sem arquivo') {

        $arquivo = $ret['data'][0]['caminho_arquivo'];
        $caminho = __DIR__ . '/../../public/upload/postagens/' . $arquivo;

        if (file_exists($caminho)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($arquivo) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($caminho));
            readfile($caminho);
            exit;
        } else {
            return ['status' => false, 'data' => 'Arquivo não encontrado no servidor.'];
        }

    }

    return ['status' => false, 'data' => 'Arquivo não localizado ou não associado.'];
}


	public function getFileDownPost ( $list ){
		return $this->fileDownPost( $list );
	} 


    	  
    //--------- POST 
    //--------- PATH

}

?>
