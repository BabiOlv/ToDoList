<?php
    $con = new PDO("mysql:host=localhost;dbname=tolist", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['tarefa'])){
        $tarefa = filter_input(INPUT_POST, 'tarefa', FILTER_SANITIZE_STRING);
        $query = "insert into tarefas (descricao,concluida) values (:descricao, 0)";
        $stm = $con->prepare($query);
        $stm->bindParam('descricao', $tarefa);
        $stm->execute();
        header('Location: http://aulahost/ToList/tarefas.php');
    }

    if (isset($_GET['excluir'])){
        $id = filter_input(INPUT_GET, 'excluir', FILTER_SANITIZE_NUMBER_INT);
        $query = "delete from tarefas where id=:id";
        $stm = $con->prepare($query);
        $stm->bindParam('id', $id);
        $stm->execute();
        header('Location: http://aulahost/ToList/tarefas.php');
    }

    if (isset($_GET['concluir'])){
        $id = filter_input(INPUT_GET, 'concluir', FILTER_SANITIZE_NUMBER_INT);
        $query = "update tarefas set concluida=1 where id=:id";
        $stm = $con->prepare($query);
        $stm->bindParam('id', $id);
        $stm->execute();
        header('Location: http://aulahost/ToList/tarefas.php');
    }

    if (isset($_GET['reabrir'])){
        $id = filter_input(INPUT_GET, 'reabrir', FILTER_SANITIZE_NUMBER_INT);
        $query = "update tarefas set concluida=0 where id=:id";
        $stm = $con->prepare($query);
        $stm->bindParam('id', $id);
        $stm->execute();
        header('Location: http://aulahost/ToList/tarefas.php');
    }

    $query = "select id,descricao,concluida from tarefas";
    $lista = $con->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>To Do List</title>
</head>
<body>
    <form method="post">
        Nova Tarefa: <input type="text" name="tarefa"/>
        <input type="submit" value="Incluir">
    </form>
    <div class="lista">
        <ul>
            <?php foreach($lista as $item): ?>
                <li <?= $item['concluida']?'class="concluida"':'' ?> >
                <?=$item['descricao']?>
                <?php if(!$item['concluida']): ?>
                    <a href="?concluir=<?=$item['id']?>">[Concluir]</a>
                    <?php else: ?>
                        <a href="?reabrir=<?=$item['id']?>">[Reabrir]</a>
                    <?php endif; ?>
                    <a href="?excluir=<?=$item['id']?>">[Excluir]</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>