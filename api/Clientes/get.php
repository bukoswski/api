<?php

$acao = $acao ?? '';
$param = $param ?? '';

if ($acao === '' && $param === '') {
    exit(json_encode(['error' => 'Caminho não encontrado']));
}

if ($acao === 'lista' && $param === '') {
    // Obtém a conexão com o banco
    $conn = Database::getConnection();

    // Realiza a consulta
    $query = $conn->query("SELECT * FROM clientes ORDER BY id_cliente");

    if ($query) {
        // Obtém os dados da consulta
        $result = $query->fetch_all(MYSQLI_ASSOC);

        // Retorna os dados em formato JSON
        array_shift($result);
        echo json_encode(['dados' => $result]);
    } else {
        // Retorna erro em caso de falha na consulta
        echo json_encode(['error' => 'Erro ao buscar dados: ' . $conn->error]);
    }
}

if ($acao === 'lista' && $param != '') {

    $conn = Database::getConnection();
    // Usando consultas preparadas para buscar um cliente específico
    $stmt = $conn->prepare("SELECT * FROM clientes WHERE id_cliente = ?");

    if ($stmt) {
        $stmt->bind_param("i", $param); // "i" indica que o parâmetro é um inteiro
        $stmt->execute();
        $result = $stmt->get_result()->fetch_object();

        if ($result) {
            // Retorna os dados em formato JSON
            echo json_encode(['dados' => $result]);
        } else {
            // Se não encontrar o cliente
            echo json_encode(['error' => 'Cliente não encontrado']);
        }

        $stmt->close(); // Fecha a declaração
    } else {
        // Retorna erro em caso de falha na preparação da consulta
        echo json_encode(['error' => 'Erro ao preparar a consulta: ' . $conn->error]);
    }
}

$conn->close();
