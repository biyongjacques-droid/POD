<?php
$username = "root";
$servername = "127.0.0.1";
$password = "";
$dbname = "informations";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("erreur de connexion a la base de donnees". $conn->connect_error);
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $niveau = $_POST['niveau'];
    $service = $_POST['services'];
    $date = $_POST['date'];
    $avis = $_POST['avis'];

    $sql = "INSERT INTO demande (nom, prenom, age, niveau, service, date, avis) VALUES ('$nom', '$prenom', $age , '$niveau','$service', '$date', '$avis')";
    if($conn->query($sql) === TRUE){
       header("location:index.php?message=yes");
    }else{
        
        header("location:index.php?message=no");
    }
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <h1>Demande de Services</h1>
            <form action="" method="POST">
                    <div class="input-box">
                     <input type="text" name="nom" placeholder="Veuillez entrer votre nom">
                    </div>

                    <div class="input-box">
                        <input type="text" name="prenom" placeholder="Veuillez entrer votre prenom">
                    </div>

                    <div class="input-box">
                     <input type="number" name="age" placeholder="Votre age">
                     </div>

                    <div class="input-box">
                        <input type="text" name="niveau" placeholder="Quel est votre niveau scolaire">
                    </div>

                    <div class="input-box">
                         <input type="text" name="services" placeholder="entrer le service souhaité(babysitter, lavage du sol, repetiteur...)">
                    </div>

                    <div class="input-box">
                     <input type="date" name="date">
                    </div>

                    <div class="input-box">
                        <textarea name="avis" placeholder="Pourquoi ce service ?"></textarea>
                    </div>

                    <div class="input-box">
                     <button type="submit">Envoyer</button>
                    </div>
            </form>
    </div>


</body>
</html>