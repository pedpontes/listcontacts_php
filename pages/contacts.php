<!DOCTYPE html>
<html lang="pt-BR">

<?php include "../includes/head.php" ?>
<head>
    <title>contacts list table - Bootdey.com</title>
    <link rel="stylesheet" href="../public/css/contacts.css">
</head>
<body>
    <div class="container">
        <?php include "../includes/nav.php" ?>
        <div class="row">
            <div class="col-lg-12">
                <div class>
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap align-middle table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" class="ps-4" style="width: 50px;">
                                        <div class="form-check font-size-16"><input type="checkbox"
                                                class="form-check-input" id="contacusercheck" /><label
                                                class="form-check-label" for="contacusercheck"></label></div>
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
                                    <td><a href="#" class="text-body">Simon
                                            Ryles</a></td>
                                    <td><span class="badge badge-soft-success mb-0">998826493</span></td>
                                    <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                            data-cfemail="5e0d373331300c27323b2d1e333730373c323b703d3133">daniel.pereirafr23@gmail.com</a>
                                    </td>
                                    <td>Rua dsafsdf sdafadsf, 31. Bairro dsfsdaf dsafdsf</td>
                                    <td>sdfsdfsdfsdfsdfsdfsdfsdfsdf</td>
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
        <?php include "../includes/footer_contacts.php"?>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
</body>

</html>