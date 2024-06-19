<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');



if (!isset($_GET['id'])) {
    exit("id not exist");
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_POST) && !empty($_POST['name'])) {
        
        $sql = "UPDATE person SET name=?, surname=?, birth_day=?, birth_place=?, birth_country=? where id=?";
        $stmt = $db->prepare($sql);
        $success = $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country'], intval($_POST['person_id'])]);
    }

    $query = "SELECT * FROM person where id=?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $person = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['del_placement_id'])){
        $sql = "DELETE FROM placement WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($_POST['del_placement_id'])]);
    }
    
    $query = "select placement.*, game.city from placement join game on placement.game_id = game.id where placement.person_id=?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $placements = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

try {
  $db1 = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
  $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  

  $query1 = "SELECT * FROM person where id=?";
  $stmt1 = $db1->prepare($query);
  $stmt1->execute([$_GET['id']]);
  $person1 = $stmt->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['del_person_id'])){
      $sql1 = "DELETE FROM person WHERE id=?";
      $stmt1 = $db1->prepare($sql1);
      $stmt1->execute([intval($_POST['del_person_id'])]);
  }
  
  $query1 = "SELECT * FROM person where id=?";;
  $stmt1 = $db1->prepare($query1);
  $stmt1->execute([$_GET['id']]);
  $persons1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<link rel="stylesheet" href="styl.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Olympic games</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Domov</a></li>
     
        <li><a href="restricted.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Späť</a></li>
        <li class="dropdown">
          

        </li>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php"><span class="glyphicon glyphicon-user"></span> Odhlásenie</a></li>
       
      </ul>
    </div>
  </div>
</nav>
</head>

<body>
<style>  .text1{
    color: black;
  }
      .text{
        font-size: large;
        margin-left: 30px;
      
        margin-top: 20px;
        margin-bottom: 20px;
        color: #e5e4e2     ;
      }
      .nazov {
        margin-left: 30px;
      
        color: #e5e4e2     ;
      }
      body {
         background-color: #0C4A60 ;   ;
    color: #566787;
 
    font-family: 'Roboto', sans-serif;
}

section {
  display: flex;
  flex-flow: row wrap;

margin-left: 19%;
margin-right: 19%;

}

P {
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 16px;
}

H3 {
  font-family: "IBM Plex Sans", sans-serif;
  font-weight: 100;
  text-transform: uppercase;
  font-size: 28px;
}

figure {
  margin: 0px;
}

figure img {
  width: 100%;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

figure img:hover {
  opacity: 0.6;
  transition: all .3s linear;
}
.column {
  box-sizing: border-box;
  flex: 1 100%;
  justify-content: space-evenly;
  margin: 20px;
}
.card-style {
  border-radius: 12px;
  border-image-slice: 1;
  box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.4);
  transition: all 0.25s linear;
}
.card-style:hover {
  box-shadow: -1px 10px 29px 0px rgba(0, 0, 0, 0.8);
}

.card-text {
  padding: 20px;
}
.karty {
    color: #e5e4e2     ;
}</style>
<script src="js/truncate.js"></script>
  <section class="karty">
    <div class="column card-style">
      <figure>
        
      </figure>
      <div class="card-text">
        <h3>Úprava záznamov databázy</h3>
        <p class="ellipsis">
          
          Táto tabuľka slúži na upravovanie záznamov o športovcoch. V tejto tabuľke je možné zmeniť meno športovca dátum narodenia a podobne. Taktiež je možnosť z databázy 
          vymazávať umiestnenia daných športovcov. Ak nejaký atribut upravíme, je dôležité kliknúť na tlačidlo "Pridaj" a následne kliknúť na tlačidlo potvrdenia. Ak všetko prebehlo
          úspešne zobrazí sa okno so správou: "Záznam o športovcovi bol úspešne zmenený".
        </p>
      </div>
    </div>
    
    
  </section>
    
    <div class="container-md">
    
<div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2><b>Úprava športovca</b></h2></div>
                        <div class="col-sm-4">
                        <div class="col-sm-4">
                       
                        </div>
                            
                        </div>
                    </div>
                </div>
               
        <form action="#" id="alert" method="post">
            <input type="hidden" name="person_id" value="<?php echo $person['id']; ?>">
            <div class="mb-3">
                <label for="InputName" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="InputName" value="<?php echo $person['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputSurname" class="form-label">Surname:</label>
                <input type="text" name="surname" class="form-control" id="InputSurname" value="<?php echo $person['surname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputDate" class="form-label">birth day:</label>
                <input type="date" name="birth_day" class="form-control" id="InputDate" value="<?php echo $person['birth_day']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputbrPlace" class="form-label">birth place:</label>
                <input type="text" name="birth_place" class="form-control" id="InputBrPlace" value="<?php echo $person['birth_place']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputBrCountry" class="form-label">birth country:</label>
                <input type="text" name="birth_country" class="form-control" id="InputBrCountry" value="<?php echo $person['birth_country']; ?>" required>
            </div>
            <br>
            <button   type="submit"  class="btn btn-info btn-lg">Uprav</button>
           
           
  



        </form>
        <script>
 document.getElementById("alert").addEventListener("submit", function(event) {
  event.preventDefault(); // zamedzi odoslaniu formulára klasickým spôsobom

  // tu by bolo možné pridať ďalšie overenie formulára pomocou JavaScriptu

  // odoslať formulár pomocou AJAX
  var xhr = new XMLHttpRequest();
  xhr.open(this.method, this.action, true);
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      // zobraz upozornenie pomocou SweetAlert
      Swal.fire("Super!", "Formulár bol úspešne odoslaný.", "success");
    }
  };
  xhr.send(new FormData(this));
});
</script>
        
        
     
<br>

        <h2>Umiestnenia</h2>
        <table id ="myTable" class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <td>Umiestnenie</td>
                    <td>Disciplína</td>
                    <td>OH</td>
                    <td>Akcia</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                
               
                foreach ($placements as $placement) {
                    
                    
                    echo '<tr><td>' . $placement['placing'] . '</td><td>' . $placement['discipline'] . '</td><td>' . $placement['city'] . '</td><td>';
                    echo '<form action="#" id="alert1" method="post"><input type="hidden" name="del_placement_id" value="' . $placement['id'] . '"><button type="submit" class="btn btn-info btn-lg">Vymaž</button></form>';
                    echo '</td></tr>';
                }
                ?>
               <!--<div class="footer">
  <p>Prihlásený: <?php echo $_SESSION['login']; ?></p>
</div>-->
<script>
 document.getElementById("alert1").addEventListener("submit", function(event) {
  event.preventDefault(); // zamedzi odoslaniu formulára klasickým spôsobom

  // tu by bolo možné pridať ďalšie overenie formulára pomocou JavaScriptu

  // odoslať formulár pomocou AJAX
  var xhr = new XMLHttpRequest();
  xhr.open(this.method, this.action, true);
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      // zobraz upozornenie pomocou SweetAlert
      Swal.fire("Super!", "Formulár bol úspešne odoslaný.", "success");
    }
  };
  xhr.send(new FormData(this));
});
</script>

        
    </div>
   
    
</body>

</html>