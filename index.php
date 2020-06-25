<?php

require 'config.php';
require 'mysql.php';

session_start();

if (isset($_REQUEST['botao'])) {
    // valida usuário e senha
    $sql = "SELECT id_usuario FROM usuario WHERE usuario = '".$_REQUEST['usuario']."' AND senha = '".md5($_REQUEST['senha'])."'";

    $resultado = $conn->query($sql);

    if($resultado) {
        if ($resultado->num_rows > 0) {
            $_SESSION['usuario'] = $_REQUEST['usuario'];
        }
    } else {
        echo "<center>Erro de login, tente outro usuário e/ou senha</center>";
    }
}

if (isset($_SESSION['usuario'])) {
    // se digitada credenciais corretas ou usuário já estiver logado...
    header("Location: atividades.php");
}

?>
<html>
<head>
    <style>
    .content {
      max-width: 500px;
      margin: auto;
      text-align: center;
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
            <td>Usuário:</td>
            <td><input type="text" name="usuario"></td>
        </tr>
        <tr>
            <td>Senha:</td>
            <td><input type="password" name="senha"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input name="botao" type="submit" value="Entrar"></td>
        </tr>
        </table>
        </form>
    </div>
</body>
</html>