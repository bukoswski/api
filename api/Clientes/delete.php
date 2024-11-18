<?php



if ($acao == '' && $param == '') {
    echo json_encode(["ERROR" => "Caminho Invalido."]);
    //var_dump("aqui");
    exit;
}
if ($acao == 'delete' && $param == '') {
    echo json_encode(["ERROR" => "Parametro Invalido."]);
    exit;
}
if ($acao == 'delete' && $param !== '') {
    //echo json_encode(["Acao de EXCLUSÂO."]);

    $conn = Database::getConnection();

    if ($conn) {
        $stmt = $conn->prepare("DELETE FROM clientes WHERE id_cliente = {$param}");
        $stmt->execute();

        if ($stmt) {
            echo json_encode(["SUCESSO" => "Cliente Excluido com sucesso."]);
        } else {
            echo json_encode(["ERRO" => "Erro ao EXCLUIR cliente."]);
        }
    }
}
