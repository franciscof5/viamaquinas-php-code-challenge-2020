<?php

require 'config.php';
require 'mysql.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    // se não estiver logado direciona para a página de login...
    header("Location: index.php");
}

if (isset($_REQUEST['acao']) && $_REQUEST['acao'] == 'excluir') {

    // verifica se é uma "manutenção urgente" (não exclui)
    $sql = "SELECT id_atividade FROM atividade WHERE id_atividade = '".$_REQUEST['id_atividade']."' AND tipo = 'Manutenção urgente'";

    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 0) {

        $sql = "DELETE FROM atividade WHERE id_atividade = ".$_REQUEST['id_atividade'];

        $resultado = $conn->query($sql);

    }
    
} elseif (isset($_REQUEST['acao']) && $_REQUEST['acao'] == 'marcar_como_concluida') {

    // "Atividades de atendimento e manutenção urgentes não podem ser finalizadas se a descrição estiver preenchida com menos de 50 caracteres"
    
    $sql = "SELECT LENGTH(descricao) AS caracteres, tipo FROM atividade WHERE id_atividade = ".$_REQUEST['id_atividade'];

    $resultado = $conn->query($sql);

    $linha = $resultado->fetch_assoc();

    if (($linha['tipo'] == 'Atendimento' || $linha['tipo'] == 'Manutenção urgente') && $linha['caracteres'] < 49) {

        //$sql = "UPDATE atividade SET status = 'concluída' WHERE id_atividade = ".$_REQUEST['id_atividade'];

        //$resultado = $conn->query($sql);
        echo "Atividades de atendimento e manutenção urgentes não podem ser finalizadas se a descrição estiver preenchida com menos de 50 caracteres. Edite a atividade.";
    } else {
        
        $sql = "UPDATE atividade SET status = 'concluida' WHERE id_atividade = ".$_REQUEST['id_atividade'];

        $resultado = $conn->query($sql);
    }

    //if ($linha['tipo'] != 'Atendimento' && $linha['tipo'] != 'Manutenção urgente') {


    //}
    
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
        <br><br><table border="1">
        <?php
        $sql = "SELECT id_atividade, titulo, descricao, tipo, status FROM atividade ORDER BY id_atividade DESC";

        $resultado = $conn->query($sql);
        if($resultado) { ?>
        <tr>
            <td><b>ID</b></td>
            <td><b>Título</b></td>
            <td><b>Descrição</b></td>
            <td><b>Tipo</b></td>
            <td><b>Status</b></td>
            <td></td>
        </tr>

        <?php

            while ($linha = $resultado->fetch_assoc()) {

                ?><tr>
                    <td><?php echo $linha['id_atividade']; ?></td>
                    <td><?php echo $linha['titulo']; ?></td>
                    <td><?php echo $linha['descricao']; ?></td>
                    <td><?php echo $linha['tipo']; ?></td>
                    <td><?php echo $linha['status']; ?></td>
                    <td>
                        <a href="frm_editar.php?id_atividade=<?php echo $linha['id_atividade']; ?>">editar</a><br><br>
                        <?php if($linha['tipo']!="Manutenção urgente") { ?>
                            <a href="atividades.php?acao=excluir&id_atividade=<?php echo $linha['id_atividade']; ?>">excluir</a><br><br>
                             <?php } ?>
                        <?php if($linha['status']=="aberta") { ?>
                            <a href="atividades.php?acao=marcar_como_concluida&id_atividade=<?php echo $linha['id_atividade']; ?>">concluir</a>
                        <?php } ?>
                    </td>
                </tr><?php

            }
        } else {
            echo "Bem vindo ao sistema de atividades, comece criando sua primeira atividade";
        }

        ?>
        </table>
        <br><a href="frm_adicionar.php">Adicionar nova atividade</a>
    </div>
</body>
</html>