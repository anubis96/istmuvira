<?php
    include 'connexion.php';
    if(isset($_GET['deleteid'])){
        $id = $_GET['deleteid'];

        $sql = "delete from `etudiants` where id=$id";
        $res = mysqli_query($con, $sql);
        if($res){
            echo "L'Enregistrement supprimé avec succès";
            header('location:admin.php');
        }else {
            echo "Erreur ".mysqli_error($con);
        }
    }
?>