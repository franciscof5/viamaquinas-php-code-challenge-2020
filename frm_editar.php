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
    
    $sql = "UPDATE atividade SET titulo = '".$_REQUEST['titulo']."', descricao = '".$_REQUEST['descricao']."', tipo = '".$_REQUEST['tipo']."' WHERE id_atividade = ".$_REQUEST['id_atividade'];

    $resultado = $conn->query($sql);

    header("Location: atividades.php");
}

$sql = "SELECT titulo, descricao, tipo, status FROM atividade WHERE id_atividade = ".$_REQUEST['id_atividade'];

$resultado = $conn->query($sql);

$linha = $resultado->fetch_assoc();

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
            <input type="hidden" name="id_atividade" value="<?php echo $_REQUEST['id_atividade'] ?>">
        <table>
        <tr>
            <td>Título:</td>
            <td><input type="text" name="titulo" value="<?php echo $linha['titulo'] ?>"></td>
        </tr>
        <tr>
            <td>Descricao:</td>
            <td><textarea name="descricao"><?php echo $linha['descricao'] ?></textarea></td>
        </tr>
        <tr>
            <td>Tipo:</td>
            <td>
                <select name="tipo">
                    <option value="Desenvolvimento"<?php if ($linha['tipo'] == 'Desenvolvimento') { echo ' selected="selected"'; } ?>>Desenvolvimento</option>
                    <option value="Atendimento"<?php if ($linha['tipo'] == 'Atendimento') { echo ' selected="selected"'; } ?>>Atendimento</option>
                    <option value="Manutenção"<?php if ($linha['tipo'] == 'Manutenção') { echo ' selected="selected"'; } ?>>Manutenção</option>
                    <option value="Manutenção urgente"<?php if ($linha['tipo'] == 'Manutenção urgente') { echo ' selected="selected"'; } ?>>Manutenção urgente</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50"><input type="submit" value="Salvar" name="botao"></td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50"><a href="atividades.php">Voltar</a></td>
        </tr>
        </table>
        </form>
    </div>
</body>
</html>