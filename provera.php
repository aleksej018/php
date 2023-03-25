<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Provera</title>
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
            <span>vrsta soka:</span>
            <input type="text" name="proizvod">
        </label>
        <input type="submit" value="Pronadji" name="provera">
    </form>

    <?php
        $mysqli = new mysqli("localhost", "root", "", "projekat_it50/20");
        if ($mysqli->connect_errno) {
            echo "Greska!";
            exit();
        }
        echo "Uspesna konekcija sa bazom!<br>";

        $sql = "SELECT * FROM prodavnicaracunara WHERE proizvod = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $vrsta);

        if(isset($_POST['provera'])){
            $vrsta = $_POST['proizvod'];

            if($vrsta !== ""){
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
    
                if ($mysqli->affected_rows > 0){
                    echo $row['proizvod'] . "<br>" . $row['sifra'] . "<br>" . $row['cena'] . "<br>" . $row['kolicina'];
                }
                else 
                {
                    echo "Ne postoji proizvod sa tim imenom!";
                }


                if(filter_var($vrsta, FILTER_VALIDATE_INT) === FALSE){
                    echo "Uneli ste dobre podatke pretrage!";
                }
                else{
                    echo "Molimo unesite samo slova u polje pretrage!";
                }

                class ispisIzPolja {
                    //svojstva
                    public $ime;

                    //metode
                    function set_name($ime){
                        $this->ime = $ime;
                    }
                    function get_name(){
                        return $this->ime;
                    }
                }

                $unos = new ispisIzPolja();

                $unos->set_name(($_POST['proizvod']));

                echo 'Pretraga za' . ' ' .$unos->get_name(). ' ' .'uspesno izvrsena!';
                echo '<br>';

            }
        }


    ?>
</body>
</html>