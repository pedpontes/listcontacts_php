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
    <title>contacts list table - Bootdey.com</title>
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
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a aria-current="page" href="#"
                                class="router-link-active router-link-exact-active nav-link active"
                                data-bs-toggle="tooltip" data-bs-placement="top" title data-bs-original-title="List"
                                aria-label="List">
                                <i class="bx bx-list-ul"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-bs-toggle="tooltip" data-bs-placement="top" title
                                data-bs-original-title="Grid" aria-label="Grid"><i class="bx bx-grid-alt"></i></a>
                        </li>
                    </ul>
                </div>
                <div>
                    <a href="#" data-bs-toggle="modal" data-bs-target=".add-new" class="btn btn-primary"><i
                            class="bx bx-plus me-1"></i> Adicionar</a>
                </div>
                <div class="dropdown">
                    <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                            class="bx bx-dots-horizontal-rounded"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php 
        if(count($contacts) == 0){ ?>
        <div class="row">
            Nenhum contato para mostrar.
        </div>
    <?php }else{ ?>
    <div class="row">
        <div class="col-lg-12">
            <div class>
                <div class="table-responsive">
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
                                <td><a href="#" class="text-body"></a></td>
                                <td><span class="badge badge-soft-success mb-0"></span></td>
                                <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                        data-cfemail="5e0d373331300c27323b2d1e333730373c323b703d3133"></a>
                                </td>
                                <td></td>
                                <td></td>
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
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true"><i
                                                    class="bx bx-dots-vertical-rounded"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Action</a><a class="dropdown-item"
                                                    href="#">Another action</a><a class="dropdown-item"
                                                    href="#">Something else here</a>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php include "../includes/footer_contacts.php"?>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
</body>

</html>