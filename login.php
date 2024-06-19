<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'client/vendor/autoload.php';
require_once 'config.php';

$pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: restricted.php");
    exit;
}

require_once "config.php";
require_once 'PHPGangsta/GoogleAuthenticator.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "SELECT fullname, email, login, password, created_at, 2fa_code FROM users WHERE login = :login";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":login", $_POST["login"], PDO::PARAM_STR);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {

            $row = $stmt->fetch();
            $hashed_password = $row["password"];

            if (password_verify($_POST['password'], $hashed_password)) {
 
                $g2fa = new PHPGangsta_GoogleAuthenticator();
                if ($g2fa->verifyCode($row["2fa_code"], $_POST['2fa'], 2)) {
                  
                    $_SESSION["loggedin"] = true;
                    $_SESSION["login"] = $row['login'];
                    $_SESSION["fullname"] = $row['fullname'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["created_at"] = $row['created_at'];

                    
                    header("location: restricted.php");
                }
                else {
                    echo "<script>alert('2FA kód nesprávny')</script>";

                  }
                } else {
                  echo "<script>alert('Nesprávne meno alebo heslo.')</script>";
                }
              } else {
                echo "<script>alert('Nesprávne meno alebo heslo.')</script>";
              }
    } else {
        echo "Ups. Nieco sa pokazilo!";
    }
    

    unset($stmt);
    unset($pdo);
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
<title>Prihlásenie</title>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 


<style>
@import url('https://fonts.googleapis.com/css?family=Quicksand&display=swap');
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}
h3{
    font-family:Quicksand;
}
.alert{
    margin-top: 20%;
  width:50%;
  margin:20px auto;
  padding:30px;
  position:relative;
  border-radius:5px;
  box-shadow:0 0 15px 5px #ccc;
}
.close{
  position:absolute;
  width:30px;
  height:30px;
  opacity:0.5;
  border-width:1px;
  border-style:solid;
  border-radius:50%;
  right:15px;
  top:25px;
  text-align:center;
  font-size:1.6em;
  cursor:pointer;
}
@mixin alert($name,$bgColor){
  $accentColor:darken($bgColor,50);
  .#{$name}{
    background-color:#{$bgColor};
    border-left:5px solid $accentColor;
    .close{
      border-color:$accentColor;
      color:$accentColor;
    }
  }
}
@include alert(simple-alert,#ebebeb);
@include alert(success-alert,#a8f0c6);
@include alert(danger-alert,#f7a7a3);
@include alert(warning-alert,#ffd48a);
	body {
		color: #fff;
		
        background-color: #0C4A60 ; 
		font-family: 'Roboto', sans-serif;
	}
    .form-control{
		height: 40px;
		box-shadow: none;
		color: #969fa4;
	}
	.form-control:focus{
		border-color: #5cb85c;
	}
    .form-control, .btn{        
        border-radius: 3px;
    }
	.signup-form{
		width: 400px;
		margin: 0 auto;
		padding: 30px 0;
	}
	.signup-form h2{
		color: #636363;
        margin: 0 0 15px;
		position: relative;
		text-align: center;
    }
		
	
    .signup-form .hint-text{
		color: #999;
		margin-bottom: 30px;
		text-align: center;
	}
    .signup-form form{
		color: #999;
		border-radius: 3px;
    	margin-bottom: 15px;
        background: #f2f3f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
	.signup-form .form-group{
		margin-bottom: 20px;
        margin-left: 25%;
        margin-right: 25%;
	}
	.signup-form input[type="checkbox"]{
		margin-top: 3px;
	}
	.signup-form .btn{        
        font-size: 16px;
        font-weight: bold;		
		min-width: 140px;
        outline: none !important;
    }
	.signup-form .row div:first-child{
		padding-right: 10px;
	}
	.signup-form .row div:last-child{
		padding-left: 10px;
	}    	
    .signup-form a{
		color: #fff;
		text-decoration: underline;
	}
    .signup-form a:hover{
		text-decoration: none;
	}
	.signup-form form a{
		color: #5cb85c;
		text-decoration: none;
	}	
	.signup-form form a:hover{
		text-decoration: underline;
	}  
    .alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    margin-bottom: 15px;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
.secondary{
  text-align: center;
}
</style>


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
        <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Registrácia</a></li>
        <li class="active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Prihlásenie</a></li>
      </ul>
    </div>
  </div>
</nav>
</head>
<body>
<div class="signup-form">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		<h2>Prihlásenie</h2>
        
		<p class="hint-text"></p>
        <div class="form-group">
			   	
        </div>
        <div class="form-group">
        	
        <label for="login">
    Prihlasovacie meno:
    <input type="text" class="form-control" name="login" value="" id="login" required>
</label>
        </div>
		<div class="form-group">
        
        <label for="password">
    Heslo:
    <input type="password" class="form-control"  name="password" value="" id="password" required>
</label>
        </div>
		<div class="form-group">
        <label for="2fa">
    2FA kod:
    <input type="password" class="form-control" name="2fa" value="" id="2fa" required>
</label>
            
        </div>        
       
		<div class="form-group">
            <button type="submit" class="btn btn-success btn-lg btn-block">Prihlás sa</button>
        </div>
        <div class="text-center">Nemáš ešte vytvorený účet? <a href="register.php">Registrácia</a></div>
        
       
    </form>
    

	
  <?php

require_once 'client/vendor/autoload.php';
require_once 'config.php';

// Inicializacia Google API klienta
$client = new Google\Client();

// Definica konfiguracneho JSON suboru pre autentifikaciu klienta.
// Subor sa stiahne z Google Cloud Console v zalozke Credentials.
$client->setAuthConfig('client_secret.json');

// Nastavenie URI, na ktoru Google server presmeruje poziadavku po uspesnej autentifikacii.
$redirect_uri = "https://site230.webte.fei.stuba.sk/oh/redirect.php";
$client->setRedirectUri($redirect_uri);

// Definovanie Scopes - rozsah dat, ktore pozadujeme od pouzivatela z jeho Google uctu.
$client->addScope("email");
$client->addScope("profile");

// Vytvorenie URL pre autentifikaciu na Google server - odkaz na Google prihlasenie.
$auth_url = $client->createAuthUrl();

?>

 <?php
        // Ak som prihlaseny, existuje session premenna.
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            // Vypis relevantne info a uvitaciu spravu.
          
            echo '<p class="text-center"><a role="button" href="restricted.php">Zabezpečená stránka</a>';
            echo '<br>';
            echo '<a role="button" class="text-center" href="logout.php">Odhlás ma.</a></p>';

        } else {
            // Ak nie som prihlaseny, zobraz mi tlacidlo na prihlasenie.
            echo '<div class = "text-center"<p><a role="button" href="' . filter_var($auth_url, FILTER_SANITIZE_URL) . '">Prihláste sa pomocou Google účtu.</a></p></div>';
        }

        
        ?>
</div>

</body>
</html>