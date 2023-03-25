<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dodaj</title>
</head>
<body>
    <div class="nav-meni">
        <ul class="nav-meni__items">
            <li class="nav-meni__item"><a href="dodaj.php">Dodaj proizvod</a></li>
            <li class="nav-meni__item"><a href="izmeni.php">Izmeni proizvod</a></li>
            <li class="nav-meni__item"><a href="obrisi.php">Obrisi proizvod</a></li>
            <li class="nav-meni__item"><a href="provera.php">Proveri proizvod</a></li>
        </ul>
    </div>


    <form action="" method="POST">
        <label for="proizvod">
            <span>Naziv proizvoda:</span>
            <input type="text" name="proizvod">
        </label>
        <label for="sifra">
            <span>Sifra proizvoda:</span>
            <input type="text" name="sifra">
        </label>
        <label for="cena">
            <span>Cena proizvoda:</span>
            <input type="text" name="cena">
        </label>
        <label for="kolicina">
            <span>Kolicina proizvoda:</span>
            <input type="text" name="kolicina">
        </label>
        <input type="submit" value="Dodaj" name="Dodaj">
    </form>

    <?php
    //PDO EKSTENZIJA
    
    try{
        $pdo = new PDO("mysql:host=localhost; dbname=projekat_it50/20", "root","");
        $pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Konekcija na bazu je uspesna.<br><br>";

        $sql = "INSERT INTO prodavnicaracunara(proizvod, sifra, cena, kolicina) VALUES(:proizvod, :sifra, :cena, :kolicina)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":proizvod",$proizvod);
        $stmt->bindParam(":sifra",$sifra);
        $stmt->bindParam(":cena",$cena);
        $stmt->bindParam(":kolicina",$kolicina);

        if(isset($_POST['Dodaj'])){
            $proizvod = $_POST['proizvod'];
            $sifra = $_POST['sifra'];
            $cena = $_POST['cena'];
            $kolicina = $_POST['kolicina'];

            if($proizvod != "" && $sifra != "" && $cena != "" && $kolicina != ""){
                if(strlen($proizvod) < 5){
                    echo "<br>Ime komponente mora sadrzati minimum 5 karaktera";
                    echo"<br>Ime ne smije da sadrzi broj";
                }
                else if(($sifra) < 1){
                    echo "<br>Sifra mora biti veca od 1 karaktera.";
                }
                else if(($kolicina) < 0){
                    echo "<br>Kolicina mora biti veca od 1.";
                }
                else{
                    $stmt->execute();
                    echo "<br>Komponenta uspesno uneta u bazu.<br>";
                }
            }
            else{
                echo "<br>Sva polja moraju biti popunjena!";
            }
        }

        $sql1="DROP PROCEDURE IF EXISTS get_pr";
        $sql2="CREATE PROCEDURE get_pr()
        BEGIN
        SELECT * FROM prodavnicaracunara;
        END;";

        $pdo->exec($sql1);
        $pdo->exec($sql2);
        echo "Procedura uspesno kreirana.<br>";

        $sql="CALL get_pr()";
        $pdo->query("$sql");
        $result=$pdo->query("$sql");
        foreach($result as $row){
            echo $row['proizvod'] . " " . $row['sifra'] . " " . $row['cena'] . " " . $row['kolicina'] . "<br>";
        }
        $pdo=null;
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

    ?>
</body>
</html>