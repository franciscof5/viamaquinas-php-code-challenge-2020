<?php

require 'config.php';
require 'mysql.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    // se não estiver logado direciona para a página de login...
    header("Location: index.php");
}

if (isset($_REQUEST['botao'])) {

    if (date('w') == 6 && date('H') > 12 && $_REQUEST['tipo'] == 'Manutenção urgente') { // Manutenções urgentes não podem ser criadas (nem via edição) após as 13:00 das sextas-feiras.
        exit();
    }

    // insere a nova atividade
    $sql = "INSERT INTO atividade (titulo, descricao, tipo, status) VALUES ('".$_REQUEST['titulo']."', '".$_REQUEST['descricao']."', '".$_REQUEST['tipo']."', 'aberta');";
    //var_dump($sql);
    $resultado = $conn->query($sql);

    header("Location: atividades.php");
}

?>
<html>
<head>
    <style>
    .content {
      max-width: 500px;
      margin: auto;
    }
    a:visited {
      color: blue;
    }
    </style>
</head>
<body>
    <div class="content">
        <form action="" method="POST">
        <table>
        <tr>
            <td>Título:</td>
            <td><input type="text" name="titulo"></td>
        </tr>
        <tr>
            <td>Descricao:</td>
            <td><textarea name="descricao"></textarea></td>
        </tr>
        <tr>
            <td>Tipo:</td>
            <td>
                <select name="tipo">
                    <option>Desenvolvimento</option>
                    <option>Atendimento</option>
                    <option>Manutenção</option>
                    <option>Manutenção urgente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50"><input type="submit" value="Adicionar" name="botao"></td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50"><a href="atividades.php">Voltar</a></td>
        </tr>
        </table>
    </div>
</body>
</html>