<?php
namespace Model\Dao;
use Model\Entity\Comentarios;
use PDO;
use stdClass;
use Model\Compomentes\JsonEncodePrivate;

class DaoComentarios {

    private $cn;

    public function __construct(){
        try{
            $this->cn = Connection::getInstance();
        }catch (\Exception $e){
            echo $e->getMessage();
        }

    }
	public function save($obj){

        try{
            $this->cn->beginTransaction();

            $sql = "INSERT INTO tmlqa_comments (comment_post_ID,comment_author,comment_author_email,comment_content,comment_parent,comment_date) VALUES (:comment_post_ID,:comment_author,:comment_author_email,:comment_content,:comment_parent,now())";
            $res = $this->cn->prepare($sql);
            $res->bindParam(":comment_post_ID", $obj->getPostId(), PDO::PARAM_STR);
            $res->bindParam(":comment_author", $obj->getNome(), PDO::PARAM_STR);
            $res->bindParam(":comment_author_email", $obj->getEmail(), PDO::PARAM_STR);
            $res->bindParam(":comment_content", $obj->getComentario(), PDO::PARAM_STR);
            $res->bindParam(":comment_parent", $obj->getParentId(), PDO::PARAM_STR);

            if($res->execute()){

                $this->cn->commit();
                $data                   = new stdClass();
                $data->success          = true;
                $data->error            = false;
                return json_encode($data);

            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->user             = false;
                return json_encode($data);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
    public function find($obj){
        $this->cn->beginTransaction();
        $start = microtime(true);
        $aprovado = "S";
        $sql = "SELECT comment_ID,comment_post_ID,comment_author,comment_author_email,comment_content,comment_parent,DATE_FORMAT(comment_date,'%d/%m/%Y') as comment_date FROM tmlqa_comments where comment_post_ID=:comment_post_ID";
        $res = $this->cn->prepare($sql);
        $res->bindParam(":comment_post_ID", $obj->getPostId(), PDO::PARAM_STR);
        $res->execute();
        $eventos_obj    = $res->fetchAll(PDO::FETCH_OBJ);
        $this->cn->commit();
        $listaEventos = $this->addItems($eventos_obj);
        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);
        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount         = $res->rowCount();
        $data->comentarios          = $listaEventos;
        return json_encode($data);
    }
    private function addItems($l){
        $arrayObjetos = array();
        foreach($l as $vl){
            $comentarios = new Comentarios();
            $comentarios->setId($vl->comment_ID);
            $comentarios->setNome($vl->comment_author);
            $comentarios->setEmail($vl->comment_author_email);
            $comentarios->setComentario($vl->comment_content);
            $comentarios->setParentId($vl->comment_parent);
            $comentarios->setPostId($vl->comment_post_ID);
            $comentarios->setData($vl->comment_date);
            $arrayObjetos[]= JsonEncodePrivate::execute($comentarios);
        }
        return $arrayObjetos;
    }
}