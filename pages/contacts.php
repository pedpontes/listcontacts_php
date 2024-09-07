<?php
    include "../includes/check_session.php";

    if($_SERVER["REQUEST_METHOD"] === "GET"){

        $userid = $_SESSION["id"];

        $result = $conn->query("SELECT * FROM contacts WHERE user_id = $userid");    
        
        if (!$result) {
            exit();
        }

        $contacts = $result->fetch_all();
        
        $conn->close();
    }
    elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_SESSION["id"];

        if(!(
            isset($_POST["name"])
            || isset($_POST["email"])
            || isset($_POST["tell"])
            || isset($_POST["address"]))){
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        elseif(empty($_POST["name"]) 
            || empty($_POST["email"]) 
            || empty($_POST["address"])
            || empty($_POST["tell"])) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

        $name = $_POST["name"];
        $email = $_POST["email"];
        $tell = $_POST["tell"];
        $address = $_POST["address"];
        $obs = isset($_POST["obs"]) ? $_POST["obs"] : "";

        $stmt = $conn->prepare("INSERT INTO contacts (name, address, user_id, tell, email, obs) VALUES (?,?,'$id',?,?,?)");
        $stmt->bind_param("sssss", $name, $email, $tell, $address, $obs);

        if (!($stmt->execute())) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        if(!($stmt->affected_rows > 0)){
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } 

        $stmt->close();
        $conn->close();

        header("location: /pages/contacts.php");
    }
    elseif($_SERVER["REQUEST_METHOD"] === "DELETE"){
        if(!isset($_GET["id"])){
            header("location: /pages/contacts.php");
            exit();
        }

        $conn = getDbConnection();

        $id = $_GET["id"];

        $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->bind_param("i", $id);
        if (!($stmt->execute())) {
            header("location: /pages/contacts.php");
            exit();
        }

        $stmt->close();
        $conn->close();

        header("location: /pages/contacts.php");
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <?php include "../includes/head.php" ?>
<head>
    <title>Contacts list table - Bootdey.com</title>
    <link rel="stylesheet" href="../public/css/contacts.css">
</head>
<body>
    <div class="container">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Agenda de Contatos <span class="text-muted fw-normal ms-2"><?= count($contacts) ?></span></h5>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                <div style="color: white;" onclick= "handleModalView()">
                    <a class="btn btn-primary"><i
                            class="bx bx-plus me-1"></i>Adicionar</a>
                </div>
                <div>
                    <a class="btn btn-danger" href="/pages/logout.php">Logout</a>
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
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col" class="ps-4" style="width: 50px;">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" class="form-check-input" id="contacusercheck"/>
                                        <label class="form-check-label" for="contacusercheck"></label>
                                    </div>
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Endereço</th>
                                <th scope="col">Obs.:</th>
                                <th scope="col" style="width: 200px;">Ação:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($contacts as $item){ ?>
                            <tr>
                                <th scope="row" class="ps-4">
                                    <div class="form-check font-size-16"><input type="checkbox"
                                            class="form-check-input" id="contacusercheck1" /><label
                                            class="form-check-label" for="contacusercheck1"></label></div>
                                </th>
                                <td><a href="#" class="text-body"><?= $item[2] ?></a></td>
                                <td><span class="badge badge-soft-success mb-0"><?= $item[3] ?></span></td>
                                <td><a class="__cf_email__"
                                        data-cfemail="5e0d373331300c27323b2d1e333730373c323b703d3133"><?= $item[6] ?></a>
                                </td>
                                <td><?= $item[4] ?></td>
                                <td><?= $item[5] ?></td>
                                <td>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" class="px-2 text-primary"><i
                                                    class="bx bx-pencil font-size-18"></i></a>
                                        </li>
                                        <li class="list-inline-item" id="dell" onclick="handleSubmitDell(<?= $item[0]?>)">
                                            <a href="/pages/contacts.php?id=<?= $item[0]?>" data-bs-toggle="tooltip"
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
    <?php include "../includes/footer_contacts.php"?>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <script>
        const handleSubmitDell = async (id) => {
            try {
                await fetch(`/pages/contacts.php?id=${id}`, {
                    method: "DELETE",
                });
            } catch (error) {
                throw new Error(error);
            }
        }

        const handleModalView = () => {
            var inputOnModal = document.querySelectorAll("input.form-control");
            var modal = document.getElementById("modal-add");
            modal.style.display = modal.style.display == "none" 
                ? "block"
                : "none";
            inputOnModal.forEach(item => item.value = "");
        }
    </script>
</body>

</html>