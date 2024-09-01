<?php
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        include "../includes/check_session.php";

        $username = $_SESSION["username"];

        $conn = getDbConnection();

        $result = $conn->query("SELECT id FROM users WHERE username = '$username'");

        if(!$result) exit();

        if ($result->num_rows > 0) {
            $userId = $result->fetch_assoc()["id"];
        } else {
            header("location: /pages/login.php");
            exit();
        }
        
        $stmt = $conn->prepare("SELECT * FROM contacts WHERE user_id = ?");    
        $stmt->bind_param("i", $userId);

        if (!$stmt->execute()) {
            exit();
        }
    
        $result = $stmt->get_result();
        $contacts = $result->fetch_all();
    
        $stmt->close();
        $conn->close();
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
                <div>
                    <a href="/pages/addcontacts.php" class="btn btn-primary"><i
                            class="bx bx-plus me-1"></i>Adicionar</a>
                </div>
            </div>
        </div>
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
                            <tr>
                                <th scope="row" class="ps-4">
                                    <div class="form-check font-size-16"><input type="checkbox"
                                            class="form-check-input" id="contacusercheck1" /><label
                                            class="form-check-label" for="contacusercheck1"></label></div>
                                </th>
                                <td><a href="#" class="text-body"><?= $item[2] ?></a></td>
                                <td><span class="badge badge-soft-success mb-0"><?= $item[3] ?></span></td>
                                <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                        data-cfemail="5e0d373331300c27323b2d1e333730373c323b703d3133"><?= $item[4] ?></a>
                                </td>
                                <td><?= $item[6] ?></td>
                                <td><?= $item[5] ?></td>
                                <td>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit" class="px-2 text-primary"><i
                                                    class="bx bx-pencil font-size-18"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Delete" class="px-2 text-danger"><i
                                                    class="bx bx-trash-alt font-size-18"></i></a>
                                        </li>
                                        <li class="list-inline-item dropdown">
                                            <a class="text-muted dropdown-toggle font-size-18 px-2" href="#"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="bx bx-dots-vertical-rounded"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="/pages/updatecontacts.php?id=<?= "$item[0]" ?>">Editar</a><a class="dropdown-item"/>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
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
</body>

</html>