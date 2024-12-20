<?php
require_once __DIR__ . '/../models/Usuario.php';

class usuarioController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new Usuario($db);
    }

    public function list()
    {
        $users = $this->user->list();
        echo json_encode($users);
    }

    public function create()
{
    $data = json_decode(file_get_contents("php://input"));
    
    if (isset($data->usuario) && isset($data->senha)) {
        try {
            $this->user->create($data->usuario, $data->senha);

            http_response_code(201);
            echo json_encode(["message" => "Usuário criado com sucesso."]);
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao criar o usuário."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Dados incompletos."]);
    }
}

public function getByUserSenha()  
{
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->usuario) && isset($data->senha)) {
        try {
   
            $user = $this->user->getByUserSenha($data->usuario, $data->senha);

            if ($user) {
              
                http_response_code(200);
                echo json_encode([
                    "message" => "Usuário encontrado.",
                    "user" => $user
                ]);
            } else {
               
                http_response_code(401);
                echo json_encode(["message" => "Usuário ou senha incorretos."]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao encontrar o usuário."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Dados incompletos."]);
    }
}


    public function getById($id)
    {
        if (isset($id)) {
            try {
                $user = $this->user->getById($id);
                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Usuário não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id) && isset($data->usuario) && isset($data->senha)) {
            try {
                $count = $this->user->update($id, $data->usuario, $data->senha);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Usuário atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar o usuário."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id)) {
            try {
                $count = $this->user->delete($id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Usuário deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar o usuário."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o usuário."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}