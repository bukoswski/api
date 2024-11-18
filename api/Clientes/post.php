<?php

if ($acao === '' && $param === '') {
    echo json_encode(["ERROR" => "Caminho não encontrado."]);
    exit;
}

if ($acao === 'adicionar' && $param === '') {
    // Verificação se $_POST não está vazio
    if (empty($_POST)) {
        echo json_encode(["ERRO" => "Nenhum dado fornecido."]);
        exit;
    }

    // Construção dinâmica da query
    $sql = "INSERT INTO clientes (";
    $cont = 1;

    foreach (array_keys($_POST) as $key) {
        $sql .= $key;
        if ($cont < count($_POST)) {
            $sql .= ", ";
        }
        $cont++;
    }
    $sql .= ") VALUES (";
    $cont = 1;
    foreach ($_POST as $value) {
        $sql .= "?";
        if ($cont < count($_POST)) {
            $sql .= ", ";
        }
        $cont++;
    }
    $sql .= ")";

    try {
        // Conexão com o banco de dados
        $conn = Database::getConnection();
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Definição dinâmica dos tipos para bind_param
            $types = str_repeat('s', count($_POST)); // Assume que todos os campos são strings
            $stmt->bind_param($types, ...array_values($_POST));

            // Execução da query
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(["SUCESSO" => "Cliente adicionado com sucesso."]);
            } else {
                echo json_encode(["ERRO" => "Erro ao adicionar cliente."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["ERRO" => "Erro na preparação da query: " . $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(["ERRO" => "Erro ao processar: " . $e->getMessage()]);
    } finally {
        $conn->close();
    }
}