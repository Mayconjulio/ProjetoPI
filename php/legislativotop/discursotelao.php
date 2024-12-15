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
$cortxtexibidor = $userRow2['cortxtexibidor'];
$corgeral = $userRow2['corgeral'];
$discurso = $userRow2['discurso'];
$aparte = $userRow2['aparte'];
$qordem = $userRow2['qordem'];
$cfinal = $userRow2['cfinal'];
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
error_reporting(0);
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if (!isset($_SESSION['userSession'])) 
{
 header("Location: acesso");
}
$res=$DBcon->query("SELECT * FROM usuarios WHERE user_id=".$_SESSION['userSession']);
$userRow=$res->fetch_array();
$usuario = $userRow['usuario'];
$nome = $userRow['nome'];
$usrid = $userRow['user_id'];
$presidente = $userRow['presidente'];
$eid = htmlspecialchars($_COOKIE["votacao"]);
?>

<?php
if(isset($_POST['novodiscurso'])) {  
$query4 = "INSERT INTO discurso(idvotacao,vereador,tipo) VALUES('$eid','$usrid','discurso')";
  if ($DBcon->query($query4))
  {
    header("Refresh:0");
  }
else 
{
    $msg2 = "<br><div class='alert alert-danger' role='alert'>
  <strong>Desculpe!</strong> Tente novamente mais tarde.
</div>";
}
  //if ($DBcon->query($query))
  //{
  //  header("Refresh:0");
  //}

}
?>
<?php
if(isset($_POST['novocontra'])) {  
$query4 = "INSERT INTO discurso(idvotacao,vereador,tipo) VALUES('$eid','$usrid','contra')";
  if ($DBcon->query($query4))
  {
    header("Refresh:0");
  }
else 
{
    $msg2 = "<br><div class='alert alert-danger' role='alert'>
  <strong>Desculpe!</strong> Tente novamente mais tarde.
</div>";
}
  //if ($DBcon->query($query))
  //{
  //  header("Refresh:0");
  //}

}
?>
<?php
if(isset($_POST['novaordem'])) {  
$query4 = "INSERT INTO discurso(idvotacao,vereador,tipo) VALUES('$eid','$usrid','ordem')";
  if ($DBcon->query($query4))
  {
    header("Refresh:0");
  }
else 
{
    $msg2 = "<br><div class='alert alert-danger' role='alert'>
  <strong>Desculpe!</strong> Tente novamente mais tarde.
</div>";
}
  //if ($DBcon->query($query))
  //{
  //  header("Refresh:0");
  //}

}
?>
<?php
if(isset($_POST['novaconsideracao'])) {  
$query4 = "INSERT INTO discurso(idvotacao,vereador,tipo) VALUES('$eid','$usrid','consideracao')";
  if ($DBcon->query($query4))
  {
    header("Refresh:0");
  }
else 
{
    $msg2 = "<br><div class='alert alert-danger' role='alert'>
  <strong>Desculpe!</strong> Tente novamente mais tarde.
</div>";
}

}
?>
<?php
if(isset($_POST['negar'])) { 
$iddisc1 = strip_tags($_POST['iddisc1']);
$iddisc1 = $DBcon->real_escape_string($iddisc1);
$query = "UPDATE discurso SET status=2 WHERE id='".$iddisc1."'";
  
if ($DBcon->query($query))
{
  header("Refresh:0");
}
else 
{
    $msg2 = "<br><div class='alert alert-danger' role='alert'>
  <strong>Desculpe!</strong> Tente novamente mais tarde.
</div>";
}

}
?>
<?php
if(isset($_POST['aceitar'])) { 
  $iddisc1 = strip_tags($_POST['iddisc1']);
  $iddisc1 = $DBcon->real_escape_string($iddisc1);
  $tipo = strip_tags($_POST['tipo']);
$tipo = $DBcon->real_escape_string($tipo);
if($tipo=="discurso")
{ 
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$discurso.' minutes'));
}
elseif($tipo=="contra")
{
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$aparte.' minutes'));
}
elseif($tipo=="ordem")
{
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$qordem.' minutes'));
}
else
{
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$cfinal.' minutes'));
}
//echo $now."<br>".$tenMinFromNow;

//$dateTime = new DateTime('NOW');
//$fmin = $dateTime->modify('+4 minutes');

$query = "UPDATE discurso SET status=1, inicio='".$now."',fim='".$tenMinFromNow."' WHERE id='".$iddisc1."'";
  
if ($DBcon->query($query))
{
  header("Refresh:0");
}
else 
{
    $msg2 = "<br><div class='alert alert-danger' role='alert'>
  <strong>Desculpe!</strong> Tente novamente mais tarde.
</div>";
}

}
?>
<?php
    $queryu=$DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC LIMIT 1");
    $countu=$queryu->num_rows;
    if($countu>=1)
    { 
    while($enqueteeeu=$queryu->fetch_array())
    {  
    $prescam = $enqueteeeu['user_id'];
    if($usrid == $prescam)
    {
      $presidastat = 1;
//echo '<p style="color:black;">Tempo para discursar:</p>
//<div><span id="time"  style="color:black;">04:00</span></div>
//<form role="form" action="" autocomplete="off" method="post">
//echo '<button type="submit" class="btn btn-primary" name="reset">Parar alerta de fim de discurso</button>';
    }
    else
    {
      $presidastat = 0;
    }
  }
} 
?>
<?php
if(isset($_POST['interromper'])) { 
  $iddisc1 = strip_tags($_POST['discnow1']);
  $iddisc1 = $DBcon->real_escape_string($iddisc1);

$query = "DELETE FROM discurso WHERE id='".$iddisc1."'";
  
if ($DBcon->query($query))
{
  header("Refresh:0");
}
else 
{
    $msg2 = "<br><div class='alert alert-danger' role='alert'>
  <strong>Desculpe!</strong> Tente novamente mais tarde.
</div>";
}

}
?>
<!DOCTYPE html>
<html lang="pt"> 
<head><meta charset="utf-8">
  <title>Discurso Telão - Câmara Municipal de <?php echo $nomecam;?></title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  

  <link rel="stylesheet" href="css/lightgallery.min.css">    

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

   <link rel="stylesheet" href="css/swiper.css">

   <link rel="stylesheet" href="css/aos.css"> 

  <link rel="stylesheet" href="css/style.css">

</head>
<?php 
  //echo '<body style="color:'.$cortxtexibidor.'; background-color:'.$corexibidor.';">';
  echo '<body style="color:#000000; background-color:#FFFFFF;">';
?>  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    



    <header class="site-navbar py-3" role="banner">

      <div class="container-fluid">


      <div class="row">

<?php
if($discurso<=9)
{
$discurso="0".$discurso;
}
if($aparte<=9)
{
  $aparte="0".$aparte;
}
if($qordem<=9)
{
  $qordem="0".$qordem;
}
if($cfinal<=9)
{
  $cfinal="0".$cfinal;
}
?>
    <div class="col-12">
        
        
      <center>       

        <div class="container" name="discursando" id="discursando"></div><br>


<br> <p align="center"><a class="btn btn-danger" href="./" role="button">Voltar</a></p>
</center>
</div>



<?php
//INICIO ANTIGO QUERDISCURSO.PHP E BOTOES PEDIDO DISCURSO
?> 



  </div>

        

</select>   
    </form><center>
<?php
    $queryu=$DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC LIMIT 1");
    $countu=$queryu->num_rows;
    if($countu>=1)
    { 
    while($enqueteeeu=$queryu->fetch_array())
    {  
    $prescam = $enqueteeeu['user_id'];
    if($usrid == $prescam)
    {
      $presidastat = 1;
//echo '<p style="color:black;">Tempo para discursar:</p>
//<div><span id="time"  style="color:black;">04:00</span></div>
//<form role="form" action="" autocomplete="off" method="post">
//echo '<button type="submit" class="btn btn-primary" name="reset">Parar alerta de fim de discurso</button>';
    }
    else
    {
      $presidastat = 0;
    }
  }
} 
?>

</form>

</center>

<script>
function formatTime(time) {
  return time < 10 ? "0" + time : time;
}

function startTimer(duration, display) {
  var timer = duration, minutes, seconds;
  setInterval(function () {
    minutes = parseInt(timer / 60, 10);
    seconds = parseInt(timer % 60, 10);

    display.textContent = formatTime(minutes) + ":" + formatTime(seconds);

    if (--timer < 0) {
      var audio = new Audio('alert.wav');
      audio.play();
      var x = document.getElementById("time");
      x.style.display = "none";

      //alert("Tempo de discurso encerrado.");
      //document.location.reload(true);
    }
  }, 1000);
}

function changeText() {
  var fiveMinutes = 60 * 4;
  var display = document.querySelector('#time');
  startTimer(fiveMinutes, display);
}
</script>
        <div class="row align-items-center">
        
          
            
          
          <div class="col-10 col-md-8 d-none d-xl-block" data-aos="fade-down">
            
            <nav class="site-navigation position-relative text-right text-lg-center" role="navigation">

              <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
                
            </nav>
          </div>

          </div>

        </div>
      </div>
      
    </header>

    <?php
echo '<script>
setInterval(function(){ 
    //APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
    $( document ).ready(function() {
        var eid = '.$eid.';
        var prestat = '.$presidastat.';
        //alert(eid); VERIFICA SE É TELÃO, SE FOR, MANDA PARA PÁGINA DE DISCURSO
        $.ajax({  
            url:"discursandotelao.php",
            type: "POST",
            data:{eid:eid,prestat:prestat},  
            dataType:"text",  
            success:function(data)  
            {  
                if(data != "")  
                {  
                    $("#discursando").replaceWith(data); 
                }  
                else  
                {  
                    window.location.assign("exibidor");
                }  
            }  
        });  
    });
}, 1000);

function checkDiscurso(tempo, discID) {
    //alert(tempo);
    if (tempo == "00:02") {
        //alert(discID);
        $.ajax({  
            url: "fimdiscurso.php",
            type: "POST",
            data: { discID: discID },  
            dataType: "text",  
            success: function(data) {  
                if (data != "") {  
                    $("#discursando").replaceWith(data); 
                    var audio = new Audio("alert.wav");
                    audio.play();
                }  
            }  
        });
    }
}

$(document).ready(function() {
    setInterval(function() { 
        var tempo1 = $("#trest1").val();
        checkDiscurso(tempo1, $("#discnow1").val());
    }, 1000);

    setInterval(function() { 
        var tempo2 = $("#trest2").val();
        checkDiscurso(tempo2, $("#discnow2").val());
    }, 1000);
});
</script>';
?>



    
<input id="idq" name="idq" value="" hidden></input>


    
    <div class="col-sm">


</div><br><br><br>

</div>
    
    
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/swiper.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/js.cookie.min.js"></script>
  <script src="js/picturefill.min.js"></script>
  <script src="js/lightgallery-all.min.js"></script>
  <script src="js/jquery.mousewheel.min.js"></script>

  <script src="js/main.js"></script>

  
  <script>
    $(document).ready(function(){
      $('#lightgallery').lightGallery();
    });
  </script>

<script>
function display_ct5() {
    var x = new Date();
    var ampm = x.getHours() >= 12 ? '' : '';
    var x1 = "Hora: " +  x.getHours() + ":" + ('0' + x.getMinutes()).slice(-2);
    document.getElementById('ct5').innerHTML = x1;
    display_c5();
}

function display_c5() {
    var refresh = 1000; // Refresh rate in milliseconds
    mytime = setTimeout(display_ct5, refresh);
}

display_c5();
</script>
 
<script>
var eq = Cookies.get('votacao');
$('#idq').attr('value', eq);

$(document).ready(function() {
    var eid = $('#idq').val();
    var mid = <?php echo $usrid; ?>;
    var cnpj = "<?php echo $usuario; ?>";

    $.ajax({  
        url: "votosexibidor.php",
        type: "POST",
        data: { eid: eid, mid: mid, cnpj: cnpj },
        dataType: "text",
        success: function(data) {
            if (data != '') {
                $('#listav').replaceWith(data); 
            }
        }  
    });

    $.ajax({  
        url: "vexibidor.php",
        type: "POST",
        data: { eid: eid, mid: mid, cnpj: cnpj },
        dataType: "text",
        success: function(data) {
            if (data != '') {
                $('#nomevota').replaceWith(data); 
            }
        }  
    });
});
</script>

</body>
</html>