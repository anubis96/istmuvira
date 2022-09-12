<?php
    include 'connexion.php';
    // Pour Etudiant
    if (isset($_POST['submit'])){
        $name = $_POST['nomEtudiant'];
        $sujet = $_POST['sujetLivre'];
        $anne = $_POST['anneeLivre'];
        $orientation = $_POST['filiere'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $path = "files/".$fileName;

        $sql = "insert into `etudiants` (nomEtudiant, sujetLivre, anneeLivre, filiere, livrePDF) values('$name', '$sujet', '$anne', '$orientation', '$fileName')";
        $result = mysqli_query($con, $sql);
        $message = "";
        if($result){
            move_uploaded_file($fileTmpName, $path);?>
            <script> alert("Données de <?php echo $name; ?> enregistrés avec succès")</script>
        <?php
        }else{
            $message = "Erreur ".mysqli_error($con);
        }
    }
    // Pour professeur
    if (isset($_POST['soumettre'])){
        $name = $_POST['nomProf'];
        $sujet = $_POST['coursLivre'];
        $anne = $_POST['annePub'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $paths = "profs/".$fileName;

        $sql = "insert into `professeur` (nomProf, coursLivre, annePub, fichier) values('$name', '$sujet', '$anne', '$fileName')";
        $result = mysqli_query($con, $sql);
        $message = "";
        if($result){
            move_uploaded_file($fileTmpName, $paths);?>
            <script> alert("Données de <?php echo $name; ?> enregistrés avec succès")</script> <?php
         }else{
            echo "Erreur ".mysqli_error($con);
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="admin.css">
    <title>Espace Admin</title>
</head>

<body>
    <div class="logout" style="display: flex; margin-right: 10px">
    <h1>Espace Admin</h1>
    <button style="max-height: 40px;" class="btn btn-danger"><a class="text-light" href="../istm/login/logout.php">Deconnecter</a></button>
    </div>
    
    <p>Dans cette espace l'administrateur du site web peut ajouter, modifier et supprimer les informations sur les
        travaux des Etudiants et celle des Professeurs</p>
    <div class="tab">
        <button onclick="openOnglet(event, 'professeur')" class="tablinks">Livre des Professeurs</button>
        <button onclick="openOnglet(event, 'etudiant')" class="tablinks">Livre des Etudiants</button>
    </div>
    <div class="tabcontent" id="professeur">
        <h3>Espace pour les données des professeurs</h3>
        
        <div class="container my-5">
            <form action="admin.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nomEtudiant">Nom de professeur</label>
                    <input type="text" name="nomProf" class="form-control" id="nomEtudiant" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="coursLivre">Cours ou sujet du livre</label>
                    <input type="text" name="coursLivre" class="form-control" id="coursLivre" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="anneeLivre">Année de publication</label>
                    <input type="text" name="annePub" class="form-control" id="anneeLivre" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="livrePDF">Charger le livre</label>
                    <input type="file" name="file" class="form-control" autocomplete="off">
                </div>
                <br>
                <div>
                    <button type="submit" class="btn btn-primary" name="soumettre">Ajouter</button>
                </div>
                <br>
                <!--<p style="background-color:greenyellow"><?php //echo $message ?></p>-->
            </form>
            <br>
            <table class="table table-light">
                <thead>
                    <tr>
                        <th scope="col">Nom de professeur</th>
                        <th scope="col">Cours ou sujet</th>
                        <th scope="col">Année de publication</th>
                        <th scope="col">Le fichier</th>
                        <th scope="col">Opération</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql2 = "SELECT * FROM `professeur`";
                        $res = mysqli_query($con, $sql2);
                        if($res){
                            while($rows = mysqli_fetch_assoc($res)){
                                $id = $rows['id'];
                                $nom = $rows['nomProf'];
                                $sujet = $rows['coursLivre'];
                                $anne = $rows['annePub'];
                                $fichiers = $rows['fichier'];

                                echo '<tr>
                                    <td>'.$nom.'</td>
                                    <td>'.$sujet.'</td>
                                    <td>'.$anne.'</td>
                                    <td><a href="download_prof.php?file='.$fichiers.'">Télecharger le fichier</a></td>
                                    <td>
                                    <!---<button class="btn btn-primary"><a class="text-light" href="">Modifier</a></button>-->
                                    <button class="btn btn-danger"><a class="text-light" href="delete.php?deleteid='.$id.'">Supprimer</a></button>
                                    </td>
                                    </tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <div class="tabcontent" id="etudiant">
    <h3>Espace pour les données des étudiants</h3>
    <div class="container my-5">
            <form action="admin.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nomEtudiant">Nom complet de l'Etudiant</label>
                    <input type="text" name="nomEtudiant" class="form-control" id="nomEtudiant" placeholder="Nom de l'Etudiant" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="sujetLivre">Le sujet de son TFC</label>
                    <input type="text" name="sujetLivre" class="form-control" id="sujetLivre" placeholder="Sujet du TFC" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="anneeLivre">Année de soutenance</label>
                    <input type="text" name="anneeLivre" class="form-control" id="anneeLivre" placeholder="Année de Soutenance" autocomplete="off">
                </div>
                <div class="form-group">
                    <div>Orientation : </div>
                    <select name="filiere" id="filiere" class="form-control">
                        <option value="accouchese" selected>Accoucheuse</option>
                        <option value="rd_congo">RDC</option>
                        <option value="italie">Italie</option>
                        <option value="maroc">Maroc</option>
                    </select>
                <div class="form-group">
                    <label for="livrePDF">Charger le TFC</label>
                    <input type="file" name="file" class="form-control" autocomplete="off">
                </div>
                <br>
                <div>
                    <button type="submit" class="btn btn-primary" name="submit">Ajouter</button>
                </div>
                <br>
                <!--<p style="background-color:greenyellow"><?php //echo $message ?></p>-->
            </form>
            <br>
            <table class="table table-light">
                <thead>
                    <tr>
                        <th scope="col">Nom de l'Etudiant</th>
                        <th scope="col">Année de Défense</th>
                        <th scope="col">Orientation</th>
                        <th scope="col">Sujet du livre</th>
                        <th scope="col">Le fichier</th>
                        <th scope="col">Opération</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql2 = "SELECT * FROM `etudiants`";
                        $res = mysqli_query($con, $sql2);
                        if($res){
                            while($rows = mysqli_fetch_assoc($res)){
                                $id = $rows['id'];
                                $nom = $rows['nomEtudiant'];
                                $sujet = $rows['sujetLivre'];
                                $anne = $rows['anneeLivre'];
                                $filiere = $rows['filiere'];
                                $fichier = $rows['livrePDF'];

                                echo '<tr>
                                    <td>'.$nom.'</td>
                                    <td>'.$anne.'</td>
                                    <td>'.$filiere.'</td>
                                    <td>'.$sujet.'</td>
                                    <td><a href="download.php?file='.$fichier.'">Télecharger le fichier</a></td>
                                    <td>
                                    <!---<button class="btn btn-primary"><a class="text-light" href="">Modifier</a></button>-->
                                    <button class="btn btn-danger"><a class="text-light" href="delete.php?deleteid='.$id.'">Supprimer</a></button>
                                    </td>
                                    </tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>

</html>