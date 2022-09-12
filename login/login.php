<!-- Code by Brave Coder - https://youtube.com/BraveCoder -->

<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: welcome.php");
    die();
}

include 'config.php';
$msg = "";

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = htmlspecialchars($data);

        return $data;
    }

    $umail = validate($_POST['email']);

    $password = validate($_POST['password']);

    if (empty($umail)) {
        $msg = "<div class='alert alert-danger'>Entrer votre adresse Mail.</div>";
        exit();
    } else if (empty($password)) {
        $msg = "<div class='alert alert-danger'>Entrer votre mot de passe</div>";
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE email='$umail' AND password='$password'";
        $res = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($res) === 1 ){
            $row = mysqli_fetch_assoc($res);

            if( $row['email'] === $umail && $row['password'] == $password){
                header('location:../admin.php');
                $msg = "<div class='alert alert-info'>Vous êtes bien connecté.</div>";
            }else{
                $msg = "<div class='alert alert-danger'>Vérifier vos informations saisies.</div>";
            }
        }else{
            $msg = "<div class='alert alert-danger'>Vérifier votre mail ou mot de passe.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Connexion pour Admin</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Connexion pour l'Admin.</h2>
                        <p>L'admin doit se connecter pour pouvoir, gérer les données des recherches. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" required>
                            <input type="password" class="password" name="password" style="margin-bottom: 2px;" required>
                            <br><br>
                            <button name="submit" name="submit" class="btn" type="submit">Connexion</button>
                        </form>
                        <div class="social-icons">
                            <p>Ajouter un Admin <a href="register.php">Ici</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function(c) {
            $('.alert-close').on('click', function(c) {
                $('.main-mockup').fadeOut('slow', function(c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>