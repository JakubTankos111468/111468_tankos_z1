<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  $email = $_SESSION['email'];
  $id = $_SESSION['id'];
  $fullname = $_SESSION['fullname'];
  $name = $_SESSION['name'];
  $surname = $_SESSION['surname'];

} else {
  // Ak pouzivatel prihlaseny nie je, presmerujem ho na hl. stranku.
  header('Location: index.php');
  exit;
}
}


?>
<!doctype html>
<html lang="sk">
<head>



    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Zabezpečená stránka</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<link rel="stylesheet" href="styl.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
        <li ><a href="index.php"><span class="glyphicon glyphicon-home"></span> Domov</a></li>
        <li class="dropdown">
          

        </li>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
      
        <li class="active"><a href="logout.php"><span class="glyphicon glyphicon-user"></span> Odhlásenie</a></li>
        
      </ul>
    </div>
  </div>
</nav>
    
</head>
<body>


<main>




<div class="container">

  <div class="row">
    <div class="col">
    
    </div>
    <div class="col-6">
    <section class="karty">
    <div class="column card-style">
     
      <div class="card-text">
        
        <p class="ellipsis">
        <h2 class="nazov">Vitaj <?php echo $_SESSION['fullname']; ?></h2>
    <br>
    <p class="text">Na tejto stránke, je možné pridávať alebo upravovať úspechy športovcov. Taktiež je možné daných športovcov z databázy vymazať. 
      Tieto možnosti môže vykonávať len riadne zaregistrovaný poúživateľ, ktorý je aktuálne prihlásený.
      Prvá tabuľka slúži na pridávanie športovcov do databázy. Do tohto formulára je potrebné zadať meno športovca, priezvisko, dátum narodenia a taktiež miesto narodenia. 
          Po kliknutí na tlačidlo pridaj sa záznam úspešne pridá do databázy.<br><br>
          Druhá tabuľka v poradí slúži na upravovanie záznamov o športovcoch. 
          K tomuto sa dostaneme kliknutím na športovca ktorý je evidovaný v tabuľke. Po kliknutí sa nám zobrazí druhá stránka na ktorej je možné
          upravovať databázu ako je zmienené vyššie.
    </p>
        </p>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Údaje o prihlásenom použivateľovi</button>
      </div>
    </div>
    
  </section>
    
    <div class="container">
  

 
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
 
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Uživateľ <?php echo $_SESSION['login']; ?></h4>
        </div>
        <div class="modal-body">
        
    <p class="text1"><strong>Si prihlaseny pod emailom:</strong> <?php echo $_SESSION['email']; ?></p>
    <p class="text1"><strong>Tvoje prihlasovacie meno je:</strong> <?php echo $_SESSION['login']; ?></p>
    <p class="text1"><strong>Dátum registracie konta:</strong> <?php echo $_SESSION['created_at'] ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
    </div>
    <div class="col">
     
    </div>
  </div>
    
<br><br>
<style>
  
  .text1{
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
  background-color:#934A5F; 
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
}
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #222;
  color: white;
  text-align: center;
}
    </style>
    <?php


require_once('config.php');


try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!empty($_POST) && isset($_POST['del_person_id'])){
      $del = "DELETE FROM person WHERE id=?";
      $stmt_del = $db->prepare($del);
      $stmt_del->execute([intval($_POST['del_person_id'])]);
    }
    $query = "SELECT * FROM person";
    $stmt = $db->query($query); 
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

if(!empty($_POST) && !empty($_POST['name'])){
    
    $sql = "INSERT INTO person (name, surname, birth_day, birth_place, birth_country) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $success = $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country']]);
}



?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    
  <script src="js/truncate.js"></script>
  
    <div class="container-md">
     
    <div class="container-md">
   
<div class="container">


        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2><b>Pridaj športovca</b></h2></div>
                        <div class="col-sm-4">
                        <div class="col-sm-4">
                       
                        </div>
                            
                        </div>
                    </div>
                </div>
                
                <form action="#" id="myForm" method="post">
<div class="mb-3">
   
    <input type="text" name="name" class="form-control" id="InputName" placeholder="zadaj meno" required>
</div><br>
<div class="mb-3">
    
    <input type="text" name="surname" class="form-control" id="InputSurname" placeholder="zadaj priezvisko" required>
</div><br>
<div class="mb-3">
    
    <input type="date" name="birth_day" class="form-control" id="InputDate" required>
</div><br>
<div class="mb-3">
   
    <input type="text" name="birth_place" class="form-control" id="InputBrPlace" placeholder="zadaj miesto narodenia" required>
</div><br>
<div class="mb-3">
   
    <input type="text" name="birth_country" class="form-control" id="InputBrCountry" placeholder="zadaj krajinu" required>
</div><br>

<button type="submit" class="btn btn-info btn-lg">Pridaj</button>
</form>
<script>
 document.getElementById("myForm").addEventListener("submit", function(event) {
  event.preventDefault(); 

  var xhr = new XMLHttpRequest();
  xhr.open(this.method, this.action, true);
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {

      Swal.fire("Super!", "Formulár bol úspešne odoslaný.", "success");
    }
  };
  xhr.send(new FormData(this));
});
</script>

<br> 

<?php
require_once('config.php');

try {
  $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (!empty($_POST) && !empty($_POST['person_id'])) {
    $sql = "INSERT INTO placement (id, person_id , game_id, placing, discipline) VALUES (?,?,?,?,?)";
    $stmt = $db->prepare($sql);
    $success = $stmt->execute([$_POST['id'],$_POST['person_id'],$_POST['game_id'], $_POST['placing'], $_POST['discipline']]);
  }

  $query = "SELECT * FROM placement";
  $stmt = $db->query($query); 
  $placements = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo $e->getMessage();
}
?>
        
<div class="table-responsive">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-8"><h2><b>Pridaj Umiestnenie</b></h2></div>
        <div class="col-sm-4">
          <div class="col-sm-4"></div>
        </div>
      </div>
    </div>
    <form action="#" id = "alert" method="post">
    <div class="mb-3">
        <input type="text" name="id" class="form-control" id="InputId" placeholder="zadaj nove id" required>
      </div><br>  
    <div class="mb-3">
        <input type="text" name="person_id" class="form-control" id="InputPerson" placeholder="zadaj id osoby" required>
      </div><br>
      <div class="mb-3">
        <input type="text" name="game_id" class="form-control" id="InputGame" placeholder="zadaj miesto olympiady" required>
      </div><br>
      <div class="mb-3">
        <input type="text" name="placing" class="form-control" id="InputPlacing" placeholder="zadaj umiestnenie" required>
      </div><br>
      <div class="mb-3">
        <input type="text" name="discipline" class="form-control" id="InputDiscipline" placeholder="zadaj disciplinu" required>
      </div><br>
      <br>
      <button type="submit" class="btn btn-info btn-lg">Pridaj</button>
      <br> 
    </form>
  </div>
</div>
<script>
 document.getElementById("alert").addEventListener("submit", function(event) {
  event.preventDefault(); 
  var xhr = new XMLHttpRequest();
  xhr.open(this.method, this.action, true);
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
 
      Swal.fire("Super!", "Formulár bol úspešne odoslaný.", "success");
    }
  };
  xhr.send(new FormData(this));
});
</script>
        <br>
 
        <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2><b>Uprava a mazanie športovcov</b></h2></div>
                        
                        <div class="col-sm-4">
                        <div class="col-sm-4">
                        
                        </div>
                            
                        </div>
                    </div>
                    <br>
        <table  id ="myTable" class="table table-striped table-hover table-bordered">
        <thead>
            <tr><td>Meno</td><td>Priezvisko</td><td>Narodenie</td><td>Vymazať</td></tr>
        </thead>
        <tbody>
        <?php 
        foreach($persons as $person){
            $date = new DateTimeImmutable($person["birth_day"]);
            echo "<tr><td><a href='editPerson.php?id=" .  $person["id"] . "'>" . $person["name"] . "</a></td><td>" . $person["surname"] . "</td><td>" . $date->format("d.m.Y") . "</td><td>";
            echo '<form action="#" id = "alert2" method="post"><input type="hidden" name="del_person_id" value="' 
            . $person['id'] . '"><button type="submit" class="btn btn-info btn-lg">Vymazať</button></form>';
             echo '</td></tr>';
            echo '</td></tr>';
           
          }
        ?> 
        </tbody>
    </table>
    </div>
    <script>
 document.getElementById("alert2").addEventListener("submit", function(event) {
  event.preventDefault(); 
  var xhr = new XMLHttpRequest();
  xhr.open(this.method, this.action, true);
  xhr.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {

      Swal.fire("Super!", "Formulár bol úspešne odoslaný.", "success");
    }
  };
  xhr.send(new FormData(this));
});
</script>


</main>
<div class="footer">
  <p>Prihlásený: <?php echo $_SESSION['fullname']; ?></p>
</div>
</body>
</html>