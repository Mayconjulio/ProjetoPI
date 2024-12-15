<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $res2=$DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2=$res2->fetch_array();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$corgeral = $userRow2['corgeral'];
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
  Câmara Municipal de <?php echo $nomecam;?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />

  <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins');

/* BASIC */

html {
  <?php 
  echo 'background-color: '.$corgeral.';';
?> 
}

body {
  font-family: "Poppins", sans-serif;
  height: 100vh;
}

a {
  color: #92badd;
  display:inline-block;
  text-decoration: none;
  font-weight: 400;
}

h2 {
  text-align: center;
  font-size: 16px;
  font-weight: 600;
  text-transform: uppercase;
  display:inline-block;
  margin: 40px 8px 10px 8px; 
  color: #cccccc;
}



/* STRUCTURE */

.wrapper {
  display: flex;
  align-items: center;
  flex-direction: column; 
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;
}

#formContent {
  -webkit-border-radius: 10px 10px 10px 10px;
  border-radius: 10px 10px 10px 10px;
  background: #fff;
  padding: 30px;
  width: 90%;
  max-width: 450px;
  position: relative;
  padding: 0px;
  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
  text-align: center;
}

#formFooter {
  background-color: #f6f6f6;
  border-top: 1px solid #dce8f1;
  padding: 25px;
  text-align: center;
  -webkit-border-radius: 0 0 10px 10px;
  border-radius: 0 0 10px 10px;
}



/* TABS */

h2.inactive {
  color: #cccccc;
}

h2.active {
  color: #0d0d0d;
  border-bottom: 2px solid #5fbae9;
}



/* FORM TYPOGRAPHY*/

input[type=button], input[type=submit], input[type=reset]  {
  background-color: #56baed;
  border: none;
  color: white;
  padding: 15px 80px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  text-transform: uppercase;
  font-size: 13px;
  -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
  margin: 5px 20px 40px 20px;
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
}

input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
  background-color: #39ace7;
}

input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
  -moz-transform: scale(0.95);
  -webkit-transform: scale(0.95);
  -o-transform: scale(0.95);
  -ms-transform: scale(0.95);
  transform: scale(0.95);
}

input[type=text] {
  background-color: #f6f6f6;
  border: none;
  color: #0d0d0d;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  width: 85%;
  border: 2px solid #f6f6f6;
  -webkit-transition: all 0.5s ease-in-out;
  -moz-transition: all 0.5s ease-in-out;
  -ms-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
}

input[type=text]:focus {
  background-color: #fff;
  border-bottom: 2px solid #5fbae9;
}

input[type=text]:placeholder {
  color: #cccccc;
}

input[type=password] {
  background-color: #f6f6f6;
  border: none;
  color: #0d0d0d;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  width: 85%;
  border: 2px solid #f6f6f6;
  -webkit-transition: all 0.5s ease-in-out;
  -moz-transition: all 0.5s ease-in-out;
  -ms-transition: all 0.5s ease-in-out;
  -o-transition: all 0.5s ease-in-out;
  transition: all 0.5s ease-in-out;
  -webkit-border-radius: 5px 5px 5px 5px;
  border-radius: 5px 5px 5px 5px;
}

input[type=password]:focus {
  background-color: #fff;
  border-bottom: 2px solid #5fbae9;
}

input[type=password]:placeholder {
  color: #cccccc;
}



/* ANIMATIONS */

/* Simple CSS3 Fade-in-down Animation */
.fadeInDown {
  -webkit-animation-name: fadeInDown;
  animation-name: fadeInDown;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

/* Simple CSS3 Fade-in Animation */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fadeIn {
  opacity:0;
  -webkit-animation:fadeIn ease-in 1;
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fadeIn.first {
  -webkit-animation-delay: 0.4s;
  -moz-animation-delay: 0.4s;
  animation-delay: 0.4s;
}

.fadeIn.second {
  -webkit-animation-delay: 0.6s;
  -moz-animation-delay: 0.6s;
  animation-delay: 0.6s;
}

.fadeIn.third {
  -webkit-animation-delay: 0.8s;
  -moz-animation-delay: 0.8s;
  animation-delay: 0.8s;
}

.fadeIn.fourth {
  -webkit-animation-delay: 1s;
  -moz-animation-delay: 1s;
  animation-delay: 1s;
}

/* Simple CSS3 Fade-in Animation */
.underlineHover:after {
  display: block;
  left: 0;
  bottom: -10px;
  width: 0;
  height: 2px;
  background-color: #56baed;
  content: "";
  transition: width 0.2s;
}

.underlineHover:hover {
  color: #0d0d0d;
}

.underlineHover:hover:after{
  width: 100%;
}



/* OTHERS */

*:focus {
    outline: none;
} 

#icon {
  width:60%;
}

* {
  box-sizing: border-box;
}





.hrdivider {
  position: relative;
  margin-bottom: 20px;
  width: 100%;
  text-align: center;
}

.hrdivider span {
  position: absolute;
  top: -11px;
  background: #fff;
  padding: 0 20px;
  font-weight: bold;
  font-size: 16px;
}

.element {
  align-items: center;
  <?php 
  echo 'background-color: '.$corgeral.';';
?>  
  box-shadow: 
    12px 12px 16px 0 rgba(0, 0, 0, 0.25),
    -8px -8px 12px 0 rgba(255, 255, 255, 0.3);
  border-radius: 15px;
  display: flex;
  height: 70px;
  justify-content: center;
  margin-right: 0rem;
  padding: 10px;
}
</style>

</head>

<?php 
  echo '<body style="background-color:'.$corgeral.';">';
?>  
<br><br>
    <center><img src="assets/logo.png" width="100">
    <br><strong>

    <?php 
  echo $nomecam;
?>  

    </strong><br>
    <hr>
    <?php 
  echo '<div class="container" style="background-color:'.$corgeral.';">';
?>  

<div class="row">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class="col element">
<a href="acessovereador" style="color:black;"><img src="assets/areavereador.png" width="32"/>
<p>Área do Vereador</p></a>
</div>

<div class="col">
&nbsp;
</div>

<div class="col element">
    <a href="acessopublico" style="color:black;"><img src="assets/eqpub.png" width="32"/><p>Área do Povo</p></a>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="w-100"><hr></div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <div class="col element">
  <a href="presidenteapp" style="color:black;"><img src="assets/presidente.png" width="32"/><p>Presidente</p></a>
  </div>
  <div class="col">
&nbsp;
</div>
    <div class="col element">
    <a href="vereadoresapp" style="color:black;"><img src="assets/vereadores.png" width="32"/><p>Vereadores</p></a>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="w-100"><hr></div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="col element">
    <a href="listamesadir" style="color:black;"><img src="assets/md.png" width="32"/><p>Mesa Diretora</p></a>
    </div>
    <div class="col">
&nbsp;
</div>
    <div class="col element">
    <a href="calendarioapp" style="color:black;"><img src="assets/calendar.png" width="32"/><p>Calendário da Câmara</p></a>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="w-100"><hr></div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="col element">
    <a href="comperapp" style="color:black;"><img src="assets/cperma.png" width="32"/><p>Comissões Permanentes</p></a>
    </div>
    <div class="col">
&nbsp;
</div>
    <div class="col element">
    <a href="tvcamara" style="color:black;"><img src="assets/tv.png" width="32"/><p>TV Câmara</p></a>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="w-100"><hr></div>
<!--
    <div class="col">
    <a href="faqapp" style="color:black;"><img src="assets/faq.png" width="32"/><p>Dúvidas frequentes</p></a>
    </div>
-->
    <div class="w-100"><center><h2 style="color:black;"><strong>—Legislativo—</strong></h2></center><br></div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="col element">
    <a href="indicapp" style="color:black;"><img src="assets/indicacoes.png" width="32"/><p>Indicações</p></a>
    </div>
    <div class="col">
&nbsp;
</div>
    <div class="col element">
    <a href="mocoesapp" style="color:black;"><img src="assets/mocoes.png" width="32"/><p>Moções</p></a>
    </div>
    <div class="col">
&nbsp;
</div>
    <div class="col element">
    <a href="reqapp" style="color:black;"><img src="assets/requerimentos.png" width="32"/><p>Requerimentos</p></a>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="w-100"><center><h2 style="color:black;"><strong>—Transparência—</strong></h2></center><br></div>

    <div class="col element">
    <a href="https://leismunicipais.com.br/" style="color:black;"><img src="assets/municipal.png" width="32"/><p>Leis Municipais</p></a>
    </div>
    <div class="col">
&nbsp;
</div>
    <div class="col element">
    <a href="https://leismunicipais.com.br/cidades-por-estado/pe" style="color:black;"><img src="assets/complementar.png" width="32"/><p>Leis Complementares</p></a>
    </div>
    <div class="col">
&nbsp;
</div>
    <div class="col element">
    <a href="https://tce.pe.gov.br/internet/index.php/portal-da-transparencia" style="color:black;"><img src="assets/contasp.png" width="32"/><p>Contas Públicas</p></a>
    </div>

    <div class="w-100"><center><h2 style="color:black;"><strong>—Para o Cidadão—</strong></h2></center></div>
    <div class="col-sm">
    &nbsp;
    </div>
    <div class="col-sm">
    <a class="btn btn-danger" href="addorcap" role="button">Orçamento Participativo</a><br>
    <a class="btn btn-warning" href="addsugest" role="button">Sugerir Lei Municipal</a><br>
    <a class="btn btn-danger" href="adddenuncia" role="button">Denunciar Irregularidades</a>
    </div>
    <div class="col-sm">
    &nbsp;
    </div>
    

</div>
</div>
</center>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
</body>
</html>
