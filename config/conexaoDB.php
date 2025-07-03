<?php
// instalar ou apontar no dockercompose // sudo apt update // sudo apt install php-pgsql
require_once '../src/utis/Default.php';

abstract class DbPostgress {


    private $pass = getenv('DB_PASS');
    private $server = getenv('DB_SERVER');
    private $user = getenv('DB_USER');
    private $port = getenv('DB_PORT');
    private $dbname = getenv('DB_NAME');

    final private function con (){
        $rota = "
            host={$this->server}
            port={$this->port}
            dbname={$this->dbname}
            user={$this->user}
            password={$this->pass}
        ";
        $con = pg_connect($rota); 
        if(!$con){
            return false ;
             //  json_decode(['status'=> false , 'message' => 'Erro 500 ']  )
             // exit ;

            // return ['status'=> false , 'message' => 'Erro 500 '] ;
            // exit;
        }else{
            return $con ;
        }
    }

    final protected function crud_select( $sql, $prn) {
        $con = $this->con();
        $result = pg_query_params($con, $sql, $prn);

        if (!$result) {
            $err = pg_last_error($con);
            pg_close($con);
            return ['status' => false, 'data' => $err ];
        }

        $res = pg_fetch_all($result);
        pg_close($con);

        if (!$res) {
            return ['status' => false, 'data' => 'Nenhum resultado encontrado'];
        }

        return ['status' => true, 'data' => $res];
    }


    final protected function crud_selectAll ( $sql , $prn = [] ) {
        $result = pg_query_params($this->con(), $sql, $prn);
        $con = $this->con();
        
        if(!result){
            $er = pg_last_error( $con );
            pg_close($con); 
            return ['status' => false , 'data' => $er] ;
        }
        
        $res = pg_fetch_all($result); 
        pg_close($con); 
        
        if( $res ){
            return [  'status' => true , 'data' => $res ];
        }else{

            return ['status' => true , 'data' => '[]' ];

        }
    }

    final protected function crud_edit ( $sql , $prn ){

        $conn = $this->con();
        $res = pg_query_params( $conn , $sql , $prn);
        $linhasAfetadas = pg_affected_rows($res);

        if( $linhasAfetadas > 0 ){
            pg_close($conn);
            return ['status'=> true , 'data' => $linhasAfetadas  ] ;
        }else{
            $er = pg_last_error($conn); 
            pg_close($conn);
            return ['status'=> false , 'data' => $er ] ;
        }
    }

    final protected function crud_edit_commit ($xCommit,$vetorSql=[],$vatorParam=[]){
        $conm = $this->con();
        pg_query( $conm , 'BEGIN');

        for( $i = 0 ; $i < $xCommit ; $i++ ){
            $valida_crud = pg_query_params( $conm, $vetorSql[$i], $vatorParam[$i]);
            error_log(">>> Valor da variável: " . print_r( $valida_crud, true));

            if( $valida_crud === false ){
                $erro_sql = pg_last_error($conm);
                pg_query($conm, 'ROLLBACK');
                return ['status' => false , 'data' => $erro_sql ] ;
            }
        }

        pg_query( $conm , 'COMMIT');
                return [
                    'status' => true , 
                    'data' => 'Processo efetuado com sucesso'
                ] ;
    }

}
?>



