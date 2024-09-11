<?php
    include "../includes/check_session.php";

    if($_SERVER["REQUEST_METHOD"] === "GET"){
        $id = $_SESSION["id"];

        $conn = getDbConnection();

        try{
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
        catch(mysqli_sql_exception $ex){
            exit("Erro:" . $ex->getMessage());
        }

        $result = $stmt->get_result();
        $contact = $result->fetch_assoc();

        $stmt->close();
        $conn->close();
    }

    elseif($_SERVER["REQUEST_METHOD"] === "POST"){
        $id = $_SESSION["id"];

        //verificar se username e email é valido
        if(!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["currentpass"]) || empty($_POST["username"]) || empty($_POST["email"] || empty($_POST["currentpass"]))){
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $currentpass = trim($_POST["currentpass"]);

        $pass = $_SESSION["pass"];
        if(!password_verify($currentpass, $pass)){
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        //verifica se ele quis trocar a senha e entao faz match entre as senha atuais
        if(isset($_POST["newpass"]) && !empty($_POST["newpass"])){
            $newpass = trim($_POST["newpass"]);
            $newpassCrypt = password_hash($newpass, PASSWORD_BCRYPT);
        }

        try {
            //para quando o usuario digitou a senha atual e a nova senha corretamente
            if(isset($newpassCrypt)){
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, pass = ? WHERE id = $id");
                $stmt->bind_param("sss", $username, $email, $newpassCrypt);
                $stmt->execute();
            }
            //para quando ele somente alterou outros campos
            else{
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = $id");
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
            }
        } catch (mysqli_sql_exception $ex) {
            exit("Erro" . $ex->getMessage());
        }

        
        if(!($stmt->affected_rows > 0)){
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        
        $stmt->close();
        $conn->close();

        include "../includes/logout.php";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dados do perfil</title>
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
                                <h6 class="mb-2 text-primary">Informações de perfil: #<?= $contact["username"] ?></h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="fullName">Nome do usuario
                                        <input required name="username" type="text" class="form-control" id="fullName" value="<?=$contact["username"]?>" placeholder="Username">
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
                                    <label for="phone">Senha Atual
                                        <input required type="password" name="currentpass" class="form-control" id="pass">
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Nova senha
                                        <input type="password" name="newpass" class="form-control" id="pass">
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