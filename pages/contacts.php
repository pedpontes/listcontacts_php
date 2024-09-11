<?php
    //verifica a sessao do usuario
    include "../includes/check_session.php";

    //retorna os contatos do usuario especifico
    if($_SERVER["REQUEST_METHOD"] === "GET"){

        $userid = $_SESSION["id"];

        $result = $conn->query("SELECT * FROM contacts WHERE user_id = $userid");    

        $contacts = $result->fetch_all();
        $conn->close();
    }

    //adicionar contatos
    elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_SESSION["id"];

        if(!(isset($_POST["name"]) || isset($_POST["email"]) || isset($_POST["tell"]) || isset($_POST["address"]))){
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        elseif(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["address"]) || empty($_POST["tell"])){
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

        $name = $_POST["name"];
        $email = $_POST["email"];
        $tell = $_POST["tell"];
        $address = $_POST["address"];
        $obs = isset($_POST["obs"]) ? $_POST["obs"] : "";
        
        //prepara a consulta sql
        try {
            $stmt = $conn->prepare("INSERT INTO contacts (name, address, user_id, tell, email, obs) VALUES (?,?,'$id',?,?,?)");
            $stmt->bind_param("sssss", $name, $address, $tell, $email, $obs);
            $stmt->execute();
        } catch (mysqli_sql_exception $ex) {
            exit("Erro" . $ex->getMessage());
        }

        if(!($stmt->affected_rows > 0)){
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } 

        $stmt->close();
        $conn->close();

        header("location: /pages/contacts.php");
    }

    //deleta contato especifico
    elseif($_SERVER["REQUEST_METHOD"] === "DELETE"){
        if(!isset($_GET["id"])){
            header("location: /pages/contacts.php");
            exit();
        }

        $id = $_GET["id"];

        try {
            $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        } catch (mysqli_sql_exception $ex) {
            exit("Erro" . $ex->getMessage());
        }

        $stmt->close();
        $conn->close();

        header("Location: /pages/contacts.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <?php include "../includes/head.php" ?>
<head>
    <title>Lista de contatos</title>
    <link rel="stylesheet" href="../public/css/contacts.css">
</head>
<body>
    <div class="container">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">
                    <img class="mb-4" src="../public/assets/logo1.png" alt="" width="150" height="150">
                    Agenda de Contatos 
                    <span class="text-muted fw-normal ms-2">
                        <?= count($contacts) ?>
                    </span>
                </h5>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                <div style="color: white;" id="addBtn" onclick="handleModalView()">
                    <a class="btn btn-primary"><i
                            class="bx bx-plus me-1"></i>Adicionar</a>
                </div>
                <div>
                    <a class="btn btn-danger" href="/pages/logout.php">Sair</a>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-add" style="display: none;">
        <?php include "../includes/addcontacts.php"; ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class>
                <div class="table-responsive">
                    <?php 
                        if(count($contacts) == 0){ ?>
                        <td>
                            Nenhum contato para mostrar.
                        </td>
                    <?php } else{ ?>
                    <label>Filtro: <input type="text" placeholder="Nome" oninput="handleFilterContacts(event)"></label>
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Endereço</th>
                                <th scope="col">Obs.:</th>
                                <th scope="col" style="width: 200px;">Ação:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($contacts as $item){ ?>
                            <tr class="list" id="<?=$item[0]?>">
                                <td><a class="text-body"><?= $item[2] ?></></td>
                                <td><span class="badge badge-soft-success mb-0"><?= $item[3] ?></span></td>
                                <td><a class="__cf_email__"
                                        data-cfemail="5e0d373331300c27323b2d1e333730373c323b703d3133"><?= $item[4] ?></a>
                                </td>
                                <td><?= $item[6] ?></td>
                                <td><?= $item[5] ?></td>
                                <td>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="/pages/updatecontacts.php?id=<?=$item[0]?>" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" class="px-2 text-primary"><i
                                                    class="bx bx-pencil font-size-18"></i></a>
                                        </li>
                                        <li class="list-inline-item" id="dell" onclick="handleSubmitDell(<?= $item[0]?>)">
                                            <a href="/pages/contacts.php?id=<?=$item[0]?>" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" class="px-2 text-danger"><i
                                                    class="bx bx-trash-alt font-size-18"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <!-- ?v=1.0 para evitar o cacheamento do script.js -->
    <script src="../public/js/script.js?v=1.0"></script>
</body>
</html>