<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $query = "SELECT person.*, game.year, game.city, game.type, placement.placing, placement.discipline
    FROM person
    INNER JOIN placement ON person.id = placement.person_id
    INNER JOIN game ON placement.game_id = game.id WHERE placing < 2 ORDER BY person.id ASC";
    
    
  
    $stmt = $db->query($query); 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $db1 = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $query = "SELECT *
    
    FROM person LIMIT 10";

   

    $stmt1 = $db1->query($query); 
    $results1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Olympic games</title>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<link rel="stylesheet" href="styl.css">

<script src="script.js"></script>

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
        <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Domov</a></li>
        <li class="dropdown">
          

        </li>
        
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Registrácia</a></li>
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Prihlásenie</a></li>
      </ul>
    </div>
  </div>
</nav>


</head>
<body>
<br>
<section class="karty">
    <div class="column card-style">
     
      <div class="card-text">
        
        <p class="ellipsis">
        <h2 class="nazov">Vitajte na hlavnej stránke o našich olympijských víťazoch </h2>
    <br>
    <p class="text">
        Prvá tabuľka zobrazuje mená našich olympijských víťazov spolu s rokom kedy medailu získali, miestom kde sa olympiáda konala, taktiež je v tabuľke jasné či ide o LOH alebo ZOH
        a nakoniec je v tabuľke napísaná disciplína v ktorej tú medailu získali.
        <br><br>
        Druhá tabuľka zobrazuje naších najúspešnejších olympionikov podľa počtu
        získaných zlatých medailí. Po kliknutí na meno niektorého športovca sa
        otvorí stránka so zobrazením detailu daného športovca so všetkými jeho umiestneniami
        na olympiádach.
        <br><br>
        Po registrácii a následnom prihlásení je možné upravovať záznamy o športovcoch, či ich pridávať alebo mazať z databázy.
    </p>
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
                        <div class="col-sm-8"><h2><b>Olympionici</b></h2></div>
                        <div class="col-sm-4">
                        <div class="col-sm-4">
                        
                        </div>
                            <div class="search-box">
                            <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Zadaj meno" title="Type in a name">
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
              
    <table id ="myTable" class="table table-striped table-hover table-bordered">
        <thead>
            <tr><th>Meno</th><th>Priezvisko</th><th>Rok</th><th>Miesto olympiády</th><th>Typ olympliády</th><th>Disciplína</th><tr>
        </thead>
        <tbody>
        <?php  
         
        
        $rowsPerPage = 10;
$totalRows = count($results);
$totalPages = ceil($totalRows / $rowsPerPage);

$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$startRow = ($currentpage - 1) * $rowsPerPage;
$query = "SELECT person.*, game.year, game.city, game.type, placement.placing, placement.discipline
    FROM person
    INNER JOIN placement ON person.id = placement.person_id
    INNER JOIN game ON placement.game_id = game.id WHERE placing < 2 ORDER BY person.id ASC LIMIT $startRow, $rowsPerPage";
    


    
    $startIndex = ($currentpage - 1) * $rowsPerPage;
    $endIndex = $startIndex + $rowsPerPage;
    for ($i = $startIndex; $i < $endIndex && $i < $totalRows; $i++) {
        $result = $results[$i];
        echo "<tr>";
        echo "<td>" . $result['name'] . "</td>";
        echo "<td>" . $result['surname'] . "</td>";
        echo "<td>" . $result['year'] . "</td>";
        echo "<td>" . $result['city'] . "</td>";
        echo "<td>" . $result['type'] . "</td>";
        echo "<td>" . $result['discipline'] . "</td>";
        echo "</tr>";             
    }
    
   
        ?> 
       <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
        <li class="<?php if ($currentpage == $i) echo "active"; ?>"><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
    <?php } ?>
</ul>


</tbody>
    </table>

    

    


                             
            
    <button onclick="showAllRows()" class="btn btn-info btn-lg">Zobraz všetko</button>
    <br>
    <br>
    
            
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2><b>Olympionici podľa úspechov</b></h2></div>
                        <div class="col-sm-4">
                        <div class="col-sm-4">
                       
                        </div>
                            
                        </div>
                    </div>
                </div>
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr><th>Meno</th><th>Priezvisko</th><tr>
        </thead>
        <tbody>
        <?php 
        foreach($results1 as $result){
            
        echo "<tr>";
        echo "<td><a href='person.php?id=" .  $result["id"] . "'>" . $result["name"] . "</td>";
        echo "<td>" . $result["surname"]  . "</td>";
        echo "<tr>";
        
                       
        }
        
        ?> 
        
            </tbody>
    </table> 
            
        </form>
    </div>
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

    </style>
</body>
</html>
<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
<script>
function showAllRows() {
  window.location.href = 'index.php?show_all=true';
}
</script>
<script>
 
var th = document.getElementsByTagName('th');


for(var i = 0; i < th.length; i++) {
    th[i].addEventListener('click', sortTable);
}


function sortTable(event) {
    var column = event.target.textContent.toLowerCase();
    var table = document.getElementById('myTable');
    var tbody = table.getElementsByTagName('tbody')[0];
    var rows = tbody.getElementsByTagName('tr');

 
    var rowsArray = Array.prototype.slice.call(rows, 0);
    
    var thIndex = Array.prototype.indexOf.call(th, event.target);


    rowsArray.sort(function(a, b) {
        var aVal = a.getElementsByTagName('td')[thIndex].textContent;
        var bVal = b.getElementsByTagName('td')[thIndex].textContent;
        return aVal.localeCompare(bVal);
    });


    for(var i = 0; i < rowsArray.length; i++) {
        tbody.appendChild(rowsArray[i]);
    }
}

</script>
<script>
function showAllRows() {
  
  var table = document.getElementById("myTable");

  for (var i = 0; i < table.rows.length; i++) {
    table.rows[i].style.display = "table-row";
  }
}
</script>