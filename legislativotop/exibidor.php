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
$nomecasa = $userRow2['nomee'];
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
  <title>Votação - Câmara Municipal de <?php echo $nomecam;?></title>
  
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
  echo '<body style="color:'.$cortxtexibidor.'; background-color:'.$corexibidor.';">';
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
        
        <?php
$query321 = $DBcon->query("SELECT * FROM enquetes WHERE votando=1 ORDER BY id DESC LIMIT 1");
if ($userRow321=$query321->fetch_array())
{
        $ini321 = $userRow321['inicio'];
        $hr321 = $userRow321['fim'];
echo '<p style="text-align: right;" style="color:'.$cortxtexibidor.';">'.$ini321.' - '.$hr321.'</p>';
}
        ?>
        
        <strong><p style="text-align: right;" id='ct5' <?php 
echo 'style="color:'.$cortxtexibidor.';"';
?>   font-size: 20px;">Hora: </p></strong>
      <center>
    <h1 style="margin-top: -100px;" <?php 
echo 'style="color:'.$cortxtexibidor.';">';
?>  <img src="assets/logo2.png" width="120"><a href="#" <?php 
echo 'style="color:'.$cortxtexibidor.';">';
?>  Câmara Municipal de <?php echo $nomecam;?><br></a></h1>
  
        <u><h2 id="nomevota" name="nomevota" <?php 
echo 'style="color:'.$cortxtexibidor.';">';
?>  </h2></u>
        

<div name="dresult" id="dresult">
        <?php
          $eid = htmlspecialchars($_COOKIE["votacao"]);
    $querycca = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='A Favor'");
    $contagemcca=$querycca->num_rows;
    if($contagemcca>=0)
    {
      $conta = $contagemcca;
      echo '<h1><span class="badge badge-pill badge-success">A Favor: '.$conta.'</span>&nbsp;';
    }


  $eid = htmlspecialchars($_COOKIE["votacao"]);
    $queryccb = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Contra'");
    $contagemccb=$queryccb->num_rows;
    if($contagemccb>=0)
    {
      $contb = $contagemccb;
     echo '<span class="badge badge-pill badge-danger">Contra: '.$contb.'</span>&nbsp;';
    }

  $eid = htmlspecialchars($_COOKIE["votacao"]);
    $queryccc = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Abster'");
    $contagemccc=$queryccc->num_rows;
    if($contagemccc>=0)
    {
      $contc = $contagemccc;
      echo '<span class="badge badge-pill badge-secondary">Abstenção: '.$contc.'</span>&nbsp;';
    }

  $eid = htmlspecialchars($_COOKIE["votacao"]);
    $queryccd = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."'");
    $contagemccd=$queryccd->num_rows;
    if($contagemccd>=0)
    {
      $contd = $contagemccd;
      echo '<span class="badge badge-pill badge-primary">Total: '.$contd.'</span></h1>';
    }

    $total = $contd;
    $favor = $conta;
    $contra = $contb;
    $abstencao = $contc;
  if($favor>$contra && $favor>$abstencao)
  {
  echo '<br><center><h1><span class="badge badge-pill badge-success">Aprovado</span></h1></center>';
  }
  elseif($contra>$favor && $contra>$abstencao)
  {
    echo '<br><center><h1><span class="badge badge-pill badge-danger">Rejeitado</span></h1></center>';
  }
  else
  {
    echo '<br><center><h1><span class="badge badge-pill badge-dark">Em andamento</span></h1></center>';
  }
  

  echo '</center>';
        ?>
</div>

        <div class="container" name="discursando" id="discursando"></div><br>
<div class="container" name="fdiscurso" id="fdiscurso"></div><br></center>

<div class="container-fluid" name="proxdisc" id="proxdisc" style="display: flex; justify-content: flex-end"></div>

        <!-- LISTA DE PARLAMENTARES -->
        <div class="container-fluid" name="listav" id="listav">
      <div class="row">
      </div>
    </div> 


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

<?php
//funções presidente
if($presidastat>=1)
{ 
  //gerar lista de pedidos - nenhum pedido = mostrar que não há interessados em discurso
  echo '<script>
  setInterval(function(){ 
    //APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
    $( document ).ready(function(){
  var eid ='.$eid.';
  //alert(eid);
           $.ajax({  
                url:"querdiscurso.php",
                type: "POST",
                data:{eid:eid},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != "")  
                     {  
                         $("#fdiscurso").replaceWith(data); 
                     }  
                     else  
                     {  
                     
                     }  
                }  
           });  
}); }, 4000);
  </script>';
}
//funções vereador comum
else
{
  //gerar botão
  //echo '<div class="container">
  //<div class="row justify-content-md-center">
  //<form role="form" action="" autocomplete="off" method="POST">
  //<button type="submit" class="btn btn-primary" name="novodiscurso">Pedir Questão de Ordem('.$discurso.'min)</button>
  //<button type="submit" class="btn btn-warning" name="novocontra">Pedir aparte('.$aparte.'min)</button>
  //<button type="submit" class="btn btn-info" name="novaconsideracao">Pedir Considerações Finais('.$cfinal.'min)</button>
  //</form>
  //</div></div><br>';
//função checar situação do pedido

    //iniciar timer do vereador
    echo '<script>
    setInterval(function(){ 
      //INICIAR TIMER DISCURSO SE O PEDIDO FOR APROVADO
      //alert("vereador");
        
    }, 3000);
    </script>';

}
?> 

<script>
function startTimer(duration, display) 
{
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) 
        {
          var audio = new Audio('alert.wav');
          audio.play();
          var x = document.getElementById("time");
         x.style.display = "none";

          //alert("Tempo de discurso encerrado.");
          //document.location.reload(true);
        }
    }, 1000);
}

/* window.onload = function () {
    var fiveMinutes = 60 * 4, display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
};  */
</script>
<script>
function changeText() 
{
  var fiveMinutes = 60 * 4, display = document.querySelector('#time');
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
      
    </header><?php
//funções presidente
if($usuario=="Telao")
{ 
  echo '<script>
  setInterval(function(){ 
    //APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
    $( document ).ready(function() 
  {
  var eid ='.$eid.';
  //alert(eid);
           $.ajax({  
                url:"checkVoting.php",
                type: "POST",
                data:{eid:eid},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != "")  
                     {  
                      $("#dresult").replaceWith(data); 
                      location.reload();
                      //return false; ENABLE IF RIGHT AFTER ONCLICK EVENT
                     }  
                     else  
                     {  
                     }  
                }  
           });  
  });
  }, 5000);
  </script>';
}
?>
<?php
//atualiza resultados
echo '<script>
setInterval(function(){ 
  //APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
  $( document ).ready(function() 
{
var eid ='.$eid.';
//alert(eid);
         $.ajax({  
              url:"atualizaResultados.php",
              type: "POST",
              data:{eid:eid},  
              dataType:"text",  
              success:function(data)  
              {  
                   if(data != "")  
                   {  
                       $("#dresult").replaceWith(data); 
                   }  
                   else  
                   {  
                   }  
              }  
         });  
});
}, 5000);
</script>';
//atualiza cores de voto
echo '<script>
setInterval(function(){ 
  //APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
  $( document ).ready(function() 
{
var eid ='.$eid.';
var mid = '.$usrid.';
//alert(eid);
         $.ajax({  
              url:"atualizaVotos.php",
              type: "POST",
              data:{eid:eid,mid:mid},  
              dataType:"text",  
              success:function(data)  
              {  
                   if(data != "")  
                   {  
                       $("#listav").replaceWith(data); 
                   }  
                   else  
                   {  
                   }  
              }  
         });  
});
}, 5000);
</script>';
//carrega discurso independente de cargo

echo '<script>
setInterval(function(){ 
  //APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
  $( document ).ready(function() 
{
var eid ='.$eid.';
var prestat = '.$presidastat.';
//alert(eid);
         $.ajax({  
              url:"discursando.php",
              type: "POST",
              data:{eid:eid,prestat:prestat},  
              dataType:"text",  
              success:function(data)  
              {  
                   if(data != "")  
                   {';  
                    if($usuario=='Telao')
                    {
                     echo 'window.location.replace("discursotelao");';
                    }
                    else
                    {
                      echo '$("#discursando").replaceWith(data);';
                    }
                   echo '}  
                   else  
                   {  
                   }  
              }  
         });  
});
}, 1000);
</script>'; 
//próximo discurso
echo '<script>
setInterval(function(){ 
  //APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
  $( document ).ready(function() 
{
var eid ='.$eid.';
var prestat = '.$presidastat.';
//alert(eid);
         $.ajax({  
              url:"listaDiscurso.php",
              type: "POST",
              data:{eid:eid,prestat:prestat},  
              dataType:"text",  
              success:function(data)  
              {  
                   if(data != "")  
                   {  
                       $("#proxdisc").replaceWith(data); 
                   }  
                   else  
                   {  
                   }  
              }  
         });  
});
}, 3000);
</script>';
//timer de discurso
echo '<script>
setInterval(function(){ 
  $( document ).ready(function() 
{
  var tempo =$("#trest1").val();
  //alert(tempo);
if(tempo=="0:2")
{
  var disc1id =$("#discnow1").val();
    //alert(disc1id);
    $.ajax({  
      url:"fimdiscurso1.php",
      type: "POST",
      data:{disc1id:disc1id},  
      dataType:"text",  
      success:function(data)  
      {  
           if(data != "")  
           {  
               $("#discursando").replaceWith(data); 
               var audio = new Audio("alert.wav");
            audio.play();
           }  
           else  
           {  
           }  
      }  
 });

}
else
{
    //alert("Not a valid Number");
}
  
});
}, 1000);
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
  var x = new Date()
  var ampm = x.getHours( ) >= 12 ? '' : '';
  
  var x1=""; 
  x1 = x1 + "Hora: " +  x.getHours( )+ ":" +  ('0'+x.getMinutes()).slice(-2);
  document.getElementById('ct5').innerHTML = x1;
  display_c5();
   }
   function display_c5(){
  var refresh=1000; // Refresh rate in milli seconds
  mytime=setTimeout('display_ct5()',refresh)
  }
  display_c5()
  </script>
 
  <script>
    var eq = Cookies.get('votacao');
    $('#idq').attr('value', eq)
  </script>
<script>
$( document ).ready(function() 
{
  var eid = $('#idq').val();
           var mid = <?php echo $usrid;?>;
           var cnpj = "<?php echo $usuario;?>";
           $.ajax({  
                url:"votosexibidor.php",
                type: "POST",
                data:{eid:eid,mid:mid,cnpj:cnpj},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#listav').replaceWith(data); 
                     }  
                     else  
                     {  
                     }  
                }  
           });  
});
</script>
<script>
$( document ).ready(function() 
{
  var eid = $('#idq').val();
           var mid = <?php echo $usrid;?>;
           var cnpj = "<?php echo $usuario;?>";
           $.ajax({  
                url:"vexibidor.php",
                type: "POST",
                data:{eid:eid,mid:mid,cnpj:cnpj},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#nomevota').replaceWith(data); 
                     }  
                     else  
                     {  
                     }  
                }  
           });  
});
</script>
</body>
</html>