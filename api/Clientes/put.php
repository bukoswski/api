<?php


if ($acao === '' || $acao === 'listar') {
    echo json_encode(["ERRO" => "Caminho não encontrado."]);
    exit;
}

if ($acao === 'update' && $param === '') {
    echo json_encode(["ERRO" => "Necessario informar o cliente."]);
    exit;
}

if ($acao === 'update' && $param !== '') {
    // Supondo que o $param contém o ID do cliente
    $id_cliente = $param; // ID do cliente a ser atualizado

    $sql = "UPDATE clientes SET ";
    array_shift($_POST);
    $placeholders = [];
    $values = [];
    $totalCampos = count($_POST); // Total de campos no $_POST
    $cont = 1;


    foreach ($_POST as $key => $value) {
        $sql .= "{$key} = ?";
        $placeholders[] = '?'; // Adiciona placeholders para os valores
        $values[] = $value;    // Adiciona o valor correspondente
        if ($cont < $totalCampos) {
            $sql .= ", ";
        }
        $cont++;
        var_dump($sql);
    }
    $sql .= " WHERE id_cliente = ?";

    // Adiciona o ID do cliente no final dos valores
    $values[] = $id_cliente;

    // Exibe a consulta para debug (somente em ambiente de desenvolvimento)
    // var_dump($sql);

    // Obter a conexão ao banco de dados
    $conn = Database::getConnection();

    if ($conn) {
        $stmt = $conn->prepare($sql); // Prepara a consulta

        if ($stmt) {
            // Vincula os valores ao statement
            $stmt->bind_param(str_repeat('s', count($values)), ...$values);

            if ($stmt->execute()) {
                echo json_encode(["SUCESSO" => "Cliente atualizado com sucesso."]);
            } else {
                echo json_encode(["ERRO" => "Erro ao atualizar o cliente: " . $stmt->error]);
            }
        } else {
            echo json_encode(["ERRO" => "Erro ao preparar a consulta: " . $conn->error]);
        }
    } else {
        echo json_encode(["ERRO" => "Erro na conexão com o banco de dados."]);
    }
}
