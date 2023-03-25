<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Izmeni</title>
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
        <input type="submit" value="Izmeni Porizvod" name="izmeni">
    </form>


    <?php
        try{
            $pdo = new PDO("mysql:host=localhost; dbname=projekat_it50/20", "root","");
            $pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Konekcija na bazu je uspesna.<br><br>";

            $sql = "UPDATE prodavnicaracunara SET sifra=:sifra, cena=:cena, kolicina=:kolicina WHERE proizvod=:proizvod";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":proizvod", $proizvod);
            $stmt->bindParam(":sifra", $sifra);
            $stmt->bindParam(":cena", $cena);
            $stmt->bindParam(":kolicina", $kolicina);

            if(isset($_POST['izmeni'])){
                $proizvod = $_POST['proizvod'];
                $sifra = $_POST['sifra'];
                $cena = $_POST['cena'];
                $kolicina = $_POST['kolicina'];

                if($proizvod !="" && $sifra !="" && $cena !="" && $kolicina !=""){
                    if(strlen($proizvod) < 5){
                        echo "<br>Ime komponente mora imati vise od 5 karaktera!";
                    }
                    else if(($sifra) < 3){
                        echo "<br>Sifra mora sadrzati vise od 2 karaktera!";
                    }
                    else if(($cena) < 500){
                        echo "<br>Cena mora biti veca od 500din!";
                    }
                    else if(($kolicina) < 1){
                        echo "<br>Kolicina mora biti veca od 1!";
                    }
                    else{
                        $stmt->execute();
                        echo "<br>Komponenta uspesno dodata!<br><br>";
                    }
                }
                else{
                    echo "<br>Sva polja moraju biti popunjena!";
                }

                $pdo->beginTransaction();

                $sql1="SELECT proizvod, sifra, cena, kolicina FROM prodavnicaracunara WHERE proizvod=:proiz";
                $stmt=$pdo->prepare($sql1);
                $stmt->bindParam(":proiz",$proiz);
                $proiz=$proizvod;
                $stmt->execute();
                $result=$stmt->fetchAll();
        
                foreach($result as $row){
                    $proiz=$row['proizvod'];
                    $sifra=$row['sifra'];
                    $cena=$row['cena'];
                    $kolicina=$row['kolicina'];
                }
        
                $sql1="UPDATE prodavnicaracunara SET proizvod=:proizvod WHERE cena=:cena";
                $stmt=$pdo->prepare($sql1);
                $stmt->bindParam(":cena",$cena);
                $kolicina=10;
                $stmt->bindParam(":proizvod",$proiz);
                $stmt->execute();
                echo "Za artikal $proiz cena je promenjena na $cena. <br>";
        
                $pdo->commit();
                }



        }
        catch(PDOException $e){
            echo $e->getMessage();
        }


        // $pdo->beginTransaction();

        // $sql1="SELECT vrsta, cena, kolicina, tezina FROM artikal WHERE vrsta=:vrste";
        // $stmt=$pdo->prepare($sql1);
        // $stmt->bindParam(":vrste",$vrste);
        // $vrste="jagode";
        // $stmt->execute();
        // $result=$stmt->fetchAll();

        // foreach($result as $row){
        //     $vrste=$row['vrsta'];
        //     $cena=$row['cena'];
        //     $kolicina=$row['kolicina'];
        //     $tezina=$row['tezina'];
        // }

        // $sql1="UPDATE artikal SET vrsta=:vrsta WHERE cena=:cena";
        // $stmt=$pdo->prepare($sql1);
        // $stmt->bindParam(":cena",$cena);
        // $kolicina=10;
        // $stmt->bindParam(":vrsta",$vrste);
        // $stmt->execute();
        // echo "Za artikal $vrste cena je promenjena na $cena. <br>";

        // $pdo->commit();
    ?>
</body>
</html>