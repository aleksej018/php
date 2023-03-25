<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Obrisi</title>
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

    <form class="forma" action="" method="POST">
        <label for="sifra">
            <span>Proizvod proizvoda koji zelite da obrisete:</span><br>
            <input type="text" name="sifra">
        </label>
        <input class="obrisi" type="submit" value="Obrisi proizvod" name="obrisi">
    </form>

    <?php
    //PDO
        try{
            $pdo = new PDO("mysql:host=localhost; dbname=projekat_it50/20", "root","");
            echo "Konekcija na bazu je uspesna.<br><br>";

            $sql = "DELETE FROM prodavnicaracunara WHERE sifra = :sifra";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":sifra", $sifra);

            if(isset($_POST['obrisi'])){
                $sifra = $_POST['sifra'];
                if($sifra !== ""){
                    if(strlen($sifra) < 1){
                        echo "<br>Proizvod mora imati vise od 1 karaktera!";
                    }
                    else {
                        $stmt->execute();
                        echo "<br>Obrisan proizvod!";
                    }
                }
                else{
                    echo "<br>Proizvod sa tom sifrom ne postoji u bazi!";
                }


                if(ctype_alpha (ctype_space($_POST['sifra']))){
                    echo "Ovo je bio ispravan unos!<br>";
                }else{
                    echo "<br>Ovo nisu ispravni podaci molimo unesite samo slova!";
                }

                class ispisIzPolja{

                    public $ime;

                    function set_name($ime){
                        $this->ime = $ime;
                    }
                    function get_name(){
                        return $this->ime;
                    }
                }

                $unos = new ispisIzPolja();

                $unos->set_name(($_POST['sifra']));

                echo '<h3>' .$unos->get_name().' ' . 'uspesno obrisan iz baze!' . '</h3>';
                echo '<br>';


            }

            $sql1="DROP PROCEDURE IF EXISTS get_pr";
                  $sql2="CREATE PROCEDURE get_pr(
                  in proiz VARCHAR(50),
                  out sifra INT(10)
                  )
                  BEGIN
                  SELECT cena into sifra FROM prodavnicaracunara WHERE proizvod=proiz;
                  END;";

                  $pdo->exec($sql1);
                  $pdo->exec($sql2);
                  echo "Procedura uspesno kreirana.<br>";

                  $sql="CALL get_pr(:proiz, @sifra)";
                  $stmt=$pdo->prepare($sql);
                  $stmt->bindParam(":proiz",$proizvodSifra);
                  $proizvodSifra="Tastatura";
                  $stmt->execute();

                  $result=$pdo->query("SELECT @sifra as sifra");
                  foreach($result as $row){
                  echo $row['sifra'];
          }
        }
        catch(PDOException $e){
            echo $e->getMessage();
    
        }

    ?>
</body>
</html>