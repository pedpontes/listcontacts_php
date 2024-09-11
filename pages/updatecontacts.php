<?php
    include "../includes/check_session.php";

    //retorna a pagina de edição para o contato requerido apartir do id
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        if(!isset($_GET["id"])){
            header("Location: /pages/contacts.php");
            exit();
        }
        elseif(empty($_GET["id"])){
            header("Location: /pages/contacts.php");
            exit();
        }
        $idContact = $_GET["id"];
        $id = $_SESSION["id"];

        $conn = getDbConnection();

        try{
            $stmt = $conn->prepare("SELECT * FROM contacts WHERE id = ? and user_id = ?");
            $stmt->bind_param("ii", $idContact, $id);
            $stmt->execute();
        }
        catch(mysqli_sql_exception $ex){
            exit("Erro:" . $ex->getMessage());
        }

        $result = $stmt->get_result();
        $contact = $result->fetch_assoc();
        if(!$contact){
            header("Location: /pages/contacts.php");
            exit();
        }

        $stmt->close();
        $conn->close();
    }

    //envia requisição para edição do contato
    elseif($_SERVER["REQUEST_METHOD"] === "POST"){
        $id = $_SESSION["id"];
        $idContact = $_GET["id"];

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
        
        try {
            $stmt = $conn->prepare("UPDATE contacts SET name = ?, address = ?, tell = ?, email = ?, obs = ? WHERE id = ? and user_id = $id");
            $stmt->bind_param("ssssii", $name, $address, $tell, $email, $obs, $idContact);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Atualizar dados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/updatecontacts.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <form method="POST" class="card-body">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Informações do contato: #<?= $contact["id"] ?></h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Nome
                                        <input required name="name" type="text" class="form-control" id="fullName" value="<?=$contact["name"]?>" placeholder="Digite seu nome">
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">E-mail
                                        <input required type="email" name="email" class="form-control" id="eMail" value="<?=$contact["email"]?>" placeholder="exemplo@email.com">
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Telefone/Celular
                                        <input required type="text" name="tell" class="form-control" value="<?=$contact["tell"]?>" id="phone" placeholder="359...">
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Endereço
                                        <input required type="text" name="address" class="form-control" value="<?=$contact["address"]?>" id="website" placeholder="Rua,número,bairro...">
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="website">Observação
                                        <input type="text" name="obs" class="form-control" value="<?=$contact["obs"]?>" id="website" placeholder="">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right">
                                    <a href="/pages/contacts.php" id="btncancel" style="color: white;" class="btn btn-secondary"/>Cancelar</a>
                                    <input type="submit" id="submit" class="btn btn-primary" value="Salvar"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
</body>
</html>