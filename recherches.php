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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISTM | UVIRA, Recherches</title>
    <link rel="shortcut icon" href="/icone.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="admin.css" class="rel">
</head>
<body>
    <section class="sub-header">
        <nav>
            <a href="index.html"><img src="logovrai.png"></a>
            <div class="nav-links" id="navLinks">
                <!-- <i class="fa-regular fa-xmark"></i> -->
                <div class="fa" onclick="hideMenu()"><img src="close.png"></div>
                <ul>
                <li><a href="index.html">ACCUEIL</a></li>
                    <li><a href="organisation.html">ORGANISATION</a></li>
                    <li><a href="courses.html">FILIERES</a></li>
                    <li><a href="blog.html">ADMISSION</a></li>
                    <li><a href="recherches.php">RECHERCHES</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                    <li><a href="about.html">A POPOS</a></li>
                </ul>
            </div>
            <div class="fa" onclick="showMenu()"><img src="menu.png"></div>
            <!-- <i class="fa-regular fa-bars"></i> -->
        </nav>
        <h1>RECHERCHES</h1>
    </section>
    <!----- Section recherches -->
    
    <h4 style="text-align: center;">Dans cette espace les étudiants peuvent consulter <br> les 
        travaux des autres Etudiants et celle des Professeurs</h4>
    <div class="tab">
        <button onclick="openOnglet(event, 'professeur')" class="tablinks">Livre des Professeurs</button>
        <button onclick="openOnglet(event, 'etudiant')" class="tablinks">Livre des Etudiants</button>
    </div>
    <div class="tabcontent" id="professeur">
        <h3>Espace pour les données des professeurs</h3>
        <div class="container my-5">
            <br>
            <table class="table table-light">
                <thead>
                    <tr>
                        <th scope="col">Nom de professeur</th>
                        <th scope="col">Cours ou sujet</th>
                        <th scope="col">Année de publication</th>
                        <th scope="col">Le fichier</th>
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
            <br>
            <table class="table table-light">
                <thead>
                    <tr>
                        <th scope="col">Nom de l'Etudiant</th>
                        <th scope="col">Année de Défense</th>
                        <th scope="col">Orientation</th>
                        <th scope="col">Sujet du livre</th>
                        <th scope="col">Le fichier</th>
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
                                    </tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
 


    <!----- Footer ------>
    <footer>
        <div class="footer-content">
            <h3>Notre adresse physique</h3>
            <p>
                Adresse: Avenue de la Mission N°29, Quartier Kakombe, Ville d'Uvira, Province du Sud-Kivu, RDC.
            </p>
            <p>Adresse Mail: istm-uvira@gmail.com</p>
            <p>Téléphone: +243 999 644 524</p>
            <ul class="socials">
                <li><a href="facebook.com/istm-uvira"><img src="facebook.png"></a></li>
                <li><a href="facebook.com/istm-uvira"><img src="twitter.png"></a></li>
                <li><a href="facebook.com/istm-uvira"><img src="twitter.png"></a></li>
            </ul>
        </div>
        <footer class="footer-bottom">
            <p>copyright &copy;2022, Fait par Olivier Rukabo : <span>+243 999 644 524</span> </a></p>
        </footer>
    </footer>


    <!-- Javascript for Toggle Menu -->
    <script src="script.js"></script>

    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu(){
            navLinks.style.right = "0";
        }
        function hideMenu(){
            navLinks.style.right = "-200px";
        }
    </script>
    
</body>
</html>