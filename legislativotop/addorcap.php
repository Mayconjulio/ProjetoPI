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
<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
if(isset($_POST['novaenquete'])) {
 
  $nome = strip_tags($_POST['tituloen']);
  $email = strip_tags($_POST['emailen']);
  $zap = strip_tags($_POST['zapen']);
  $mensagem = strip_tags($_POST['sobreen']);
 $nome = $DBcon->real_escape_string($nome);
 $mensagem = $DBcon->real_escape_string($mensagem);
  
$query4 = "INSERT INTO reqcidadao(tipo,nome,email,telefone,mensagem) VALUES('OP','$nome','$email','$zap','$mensagem')";
  if ($DBcon->query($query4))
  {
    $msg2 = "<br><div class='alert alert-info' role='alert'>
  <strong>Pronto!</strong> Informações enviadas com sucesso.
</div>";
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
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Orçamento Participativo - Câmara Municipal de <?php echo $nomecam;?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />

  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>

  <script>  
      $(document).on('change', '#enquete2', function(){  
           var eid = $(this).find(':selected').data('eid');
           var mid = <?php echo $usrid;?>;
           var cnpj = "<?php echo $usuario;?>";
           $.ajax({  
                url:"load_data.php",
                type: "POST",
                data:{eid:eid,mid:mid,cnpj:cnpj},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#candidatos').replaceWith(data); 
                     }  
                     else  
                     {  
                     }  
                }  
           });  
      });  
 </script>
  <script>  
      $(document).on('change', '#enquete2', function(){  
           var eid = $(this).find(':selected').data('eid');
           var usr = "<?php echo $usrid;?>";
           var usrname = "<?php echo $usuario;?>";
           $.ajax({  
                url:"votos.php",
                type: "POST",
                data:{eid:eid,usr:usr,usrname:usrname},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#resvotos').replaceWith(data); 
                     }  
                     else  
                     {  
                     }  
                }  
           });  
      });  
 </script>

</head>

<body class="">
  <div class="wrapper ">


    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="./">Câmara Municipal de <?php echo $nomecam;?></a>
          </div>

        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <center><h4 class="card-title">Orçamento Participativo</h4></center>
              </div>

              <div class="card-body">
                <div class="table-responsive">

                <form role="form" action="" autocomplete="off" method="post">
            <div class="row">
        <div class="col-md-12">
        <?php 
if(isset($msg2)){ echo $msg2; }
									?>
            <div class="form-group">
                        <label>Nome completo</label>
                        <input type="text" class="form-control" placeholder="Nome completo" name="tituloen" required>
                      </div>
                    

                    <div class="form-group">
                        <label>Email (opcional)</label>
                        <input type="text" class="form-control" placeholder="Email opcional" name="emailen" >
                      </div>
                    

                    <div class="form-group">
                        <label>Telefone (WhatsApp)</label>
                        <input type="text" class="form-control" placeholder="Número do WhatsApp" name="zapen" required>
                      </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Mensagem</label>
                        <textarea rows="4" cols="80" class="form-control" placeholder="Mensagem" name="sobreen" required></textarea>
                      </div>
                    </div>
                  </div>
                  <center><button type="submit" class="btn btn-info" name="novaenquete">Enviar</button></center>
                  <br><br>
                  <center><a class="btn btn-danger" href="acesso" role="button">Voltar</a></center>
</form>
 
    </form><center>


</form>

</center>
    </div><br>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <footer class="footer">
        <div class=" container-fluid ">
          <nav>
            <ul>
              <li>
                <a href="https://starsolutions.net.br/contato">
                  SUPORTE TÉCNICO
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Feito por <a href="https://starsolutions.net.br" target="_blank">Star Solutions</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
</body>

</html>