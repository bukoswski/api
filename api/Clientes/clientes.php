<?php

if ($api === 'clientes') {
    if ($method === 'GET') {
        include_once "api/Clientes/get.php";
    }

    if ($method === 'POST') {
        // Inclui o arquivo POST padrão
        include_once "api/Clientes/post.php";

        // Verifica se '_method' está definido e executa PUT ou DELETE
        if (isset($_POST['_method'])) {
            if ($_POST['_method'] === "PUT") {
                include_once "api/Clientes/put.php";
                //var_dump("a");
            } elseif ($_POST['_method'] === "DELETE") {
                include_once "api/Clientes/delete.php";
                // var_dump($_POST);
            }
        }
    }
}
