<?php
use Model\Dao\DaoComentarios;
use Model\Entity\Comentarios;


$app->post('/comentario/save', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $parsedBody = $request->getParsedBody();

            $obj = new Comentarios();
            $obj->setPostId($parsedBody["post_id"]);
            $obj->setNome($parsedBody["nome"]);
            $obj->setEmail($parsedBody["email"]);
            $obj->setComentario($parsedBody["comentario"]);
            $obj->setParentId($parsedBody["parent_id"]);

            $dao = new DaoComentarios();
            return ($dao->save($obj));

        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

$app->post('/comentario/list', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $parsedBody = $request->getParsedBody();

            $obj = new Comentarios();
            $obj->setPostId($parsedBody["post_id"]);


            $dao = new DaoComentarios();
            return ($dao->find($obj));

        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});


$app->get('/', function ($request, $response, $args) {
    //$this->logger->info("HOME, ".$this->logApi);
    return $this->renderer->render($response, 'inicio.phtml', $args);
});

