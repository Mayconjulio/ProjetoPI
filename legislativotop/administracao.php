<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
error_reporting(0);
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

if(!isset($_COOKIE['admuserSession']))
        {
            header("Location: acessoadmin");
        } 
    else
    {
      $_SESSION['adminSession'] = $_COOKIE['admuserSession'];
    }

$res=$DBcon->query("SELECT * FROM admin WHERE id=".$_SESSION['adminSession']);
$userRow=$res->fetch_array();
$usuario = $userRow['usuario'];
$id = $userRow['id'];

$res=$DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC LIMIT 1");
$userRow=$res->fetch_array();
$idpp = $userRow['user_id'];

$res2=$DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2=$res2->fetch_array();
$nomecam = $userRow2['nome'];
$nomecam2 = $userRow2['nomee'];
$logo = $userRow2['logo'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$cortxtexibidor = $userRow2['cortxtexibidor'];
$corgeral = $userRow2['corgeral'];
$discurso = $userRow2['discurso'];
$aparte = $userRow2['aparte'];
$qordem = $userRow2['qordem'];
$cfinal = $userRow2['cfinal'];


$res22=$DBcon->query("SELECT id FROM enquetes ORDER BY id DESC LIMIT 1");
$userRow22=$res22->fetch_array();
$countuuu2=$res22->num_rows;
    if($countuuu2>=1)
    { 
      $lastid = $userRow22['id']+1;
    }
    else
    {
      $lastid = 1;
    }
?>
<?php
if(isset($_POST['gerarel'])) 
{
 
 $rel = strip_tags($_POST['idrel']);
 $rel = $DBcon->real_escape_string($rel);
 
  $_SESSION['relSess'] = $rel;
  header("Location: relatorio");
  //echo "ID RELATÓRIO:  ".$_SESSION['relSess'];

}
?>
<?php
if(isset($_POST['salvar'])) 
{
 $cormenuu = strip_tags($_POST['cormenu']);
 $nomeu = strip_tags($_POST['nome']);
 $nomeu2 = strip_tags($_POST['nome2']);
 $corexibidoru = strip_tags($_POST['corexibidor']);
 $cortxtexibidoru = strip_tags($_POST['cortxtexibidor']);
 $corgeralu = strip_tags($_POST['corgeral']);
 $idpp = strip_tags($_POST['idpp']);
 $listapresenca = strip_tags($_POST['listapresenca']);
 
 $cormenuu = $DBcon->real_escape_string($cormenuu);
 $nomeu = $DBcon->real_escape_string($nomeu);
 $nomeu2 = $DBcon->real_escape_string($nomeu2);
 $corexibidoru = $DBcon->real_escape_string($corexibidoru);
 $cortxtexibidoru = $DBcon->real_escape_string($cortxtexibidoru);
 $corgeralu = $DBcon->real_escape_string($corgeralu);
 $idpp = $DBcon->real_escape_string($idpp);
 $listapresenca = $DBcon->real_escape_string($listapresenca);

 $query = "UPDATE camconfig SET tempresenca='$listapresenca',nomee='$nomeu2',cormenu='$cormenuu',nome='$nomeu',corexibidor='$corexibidoru',cortxtexibidor='$cortxtexibidoru',corgeral='$corgeralu' WHERE id=1";
  
if ($DBcon->query($query))
{
     $query2 = "UPDATE usuarios SET presidente='0'";
  if ($DBcon->query($query2))
{
  $query23 = "UPDATE usuarios SET presidente='99' WHERE user_id='$idpp'";
  if ($DBcon->query($query23))
{
  header("Refresh:0");
}
}
}
else 
{
echo "ERRO";
}        
}
?>
<?php
if(isset($_POST['removevota'])) 
{
 $idremov = strip_tags($_POST['idremove']);
 $idremov = $DBcon->real_escape_string($idremov);

 $query = "DELETE FROM enquetes WHERE id=".$idremov;
  
if ($DBcon->query($query))
{
   $query2 = "DELETE FROM modelos WHERE idenquete=".$idremov;
  
if ($DBcon->query($query2))
{
     $query3 = "DELETE FROM votos WHERE enqueteid=".$idremov;
  
if ($DBcon->query($query3))
{
  header("Refresh:0");
}
}
}
else 
{
echo "ERRO";
}        
}
?>
<?php
if(isset($_POST['removevota2'])) 
{
 $idremov = strip_tags($_POST['idremove2']);
 $idremov = $DBcon->real_escape_string($idremov);

 $query = "DELETE FROM usuarios WHERE user_id=".$idremov;
  
if ($DBcon->query($query))
{
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}       
}
?>
<?php
if(isset($_POST['removevota3'])) 
{
 $idremov = strip_tags($_POST['idremove3']);
 $idremov = $DBcon->real_escape_string($idremov);
 $hashed_password = password_hash($idremov, PASSWORD_DEFAULT);

 $query = "UPDATE admin SET senha='".$hashed_password."' WHERE id=".$_SESSION['adminSession'];
  
if ($DBcon->query($query))
{
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}       
}
?>
<?php
if(isset($_POST['removevota4'])) 
{
  $t1 = strip_tags($_POST['t1']);
  $t1 = $DBcon->real_escape_string($t1);
  $t2 = strip_tags($_POST['t2']);
  $t2 = $DBcon->real_escape_string($t2);
  $t3 = strip_tags($_POST['t3']);
  $t3 = $DBcon->real_escape_string($t3);
  $t4 = strip_tags($_POST['t4']);
  $t4 = $DBcon->real_escape_string($t4);

 $query = "UPDATE camconfig SET discurso='$t1',aparte='$t2',qordem='$t3',cfinal='$t4' WHERE id=1";
  
if ($DBcon->query($query))
{
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}       
}
?>
<?php
if(isset($_POST['removesess'])) 
{
 $idremov = strip_tags($_POST['idremovess']);
 $idremov = $DBcon->real_escape_string($idremov);

 $query = "DELETE FROM sessoes WHERE id=".$idremov;

if ($DBcon->query($query))
{
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}       
}
?>
<?php
if(isset($_POST['attvota'])) 
{
 $idremov = strip_tags($_POST['idup']);
 $idremov = $DBcon->real_escape_string($idremov);
 $txtu = strip_tags($_POST['txtup']);
 $txtu = $DBcon->real_escape_string($txtu);
  $txtu2 = strip_tags($_POST['txtup2']);
 $txtu2 = $DBcon->real_escape_string($txtu2);
 //$txtu = utf8_encode($txtu);

 $query = "UPDATE enquetes SET titulo='".$txtu."', descricao='".$txtu2."' WHERE id='".$idremov."'";

if ($DBcon->query($query))
{
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}      
}
?>
<?php
   if(isset($_FILES['imge'])){
      $errors= array();
      $file_name = $_FILES['imge']['name'];
      $file_size =$_FILES['imge']['size'];
      $file_tmp =$_FILES['imge']['tmp_name'];
      $file_type=$_FILES['imge']['type'];
      $file_ext=strtolower(@end(explode('.',$_FILES['imge']['name'])));
	  $temp = explode(".", $file_name);
	  $hash2 = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 30)), 30, 30);
	  $hashbg = round(microtime(true)).$hash2.'.'.end($temp);
      
      $expensions= array("jpeg","jpg","png");

       if(in_array($file_ext,$expensions)=== false){
         $errors[]="";
      }
      
      if($file_size > 3097152){
         $errors[]='Arquivo precisa ser menor que 3MB';
      }
      
      if(empty($errors)==true){
          
          $fileArray = array("./fotos/default-avatar.png");

foreach ($fileArray as $value) {
    if (file_exists($value) and $value!="./fotos/default-avatar.png") {
        unlink($value);
    } else {

    }
} 
$hashbg2 = "https://legislativocamocim.top/assets/lg2/".$hashbg;
$hashbg2 = $DBcon->real_escape_string($hashbg2);
 $query = "UPDATE camconfig SET logo='$hashbg2'";
  
if ($DBcon->query($query))
{
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}   

         move_uploaded_file($file_tmp,"assets/lg2/".$hashbg);
      }else{
         print_r($errors);
      }
   }
?>
<?php
if(isset($_POST['novaenquete'])) {
 
  $titulo = strip_tags($_POST['tituloen']);
  $sobre = strip_tags($_POST['sobreen']);
  $lastidd = strip_tags($_POST['lastide']);
 $lastidd = $DBcon->real_escape_string($lastidd);
 $titulo = $DBcon->real_escape_string($titulo);
 $sobre = $DBcon->real_escape_string($sobre);
 $catcat = strip_tags($_POST['categoria']);
 $catcat = $DBcon->real_escape_string($catcat);
 $datahj = date("d/m/Y");
 $horahj = date("h:i:sa");
  
  $query = "INSERT INTO enquetes(id,titulo,descricao,categoria,inicio,fim) VALUES('$lastidd','$titulo','$sobre','$catcat','$datahj','$horahj')";
  if ($DBcon->query($query))
  {
$query2 = "INSERT INTO modelos(idenquete,nome,img) VALUES('$lastidd','A Favor','afavor.png')";
if ($DBcon->query($query2))
{
  $query3 = "INSERT INTO modelos(idenquete,nome,img) VALUES('$lastidd','Contra','contra.png')";
  if ($DBcon->query($query3))
  {

    $query4 = "INSERT INTO modelos(idenquete,nome,img) VALUES('$lastidd','Abster','abster.png')";
  if ($DBcon->query($query4))
  {
    $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
      <span aria-hidden='true'>&times;</span>
              </button>
    <strong>Pronto!</strong> Concluído com sucesso.
  </div>";
  } else {
      $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
      <button type='button' class='close' data-dismiss='alert'>
      <span aria-hidden='true'>&times;</span>
              </button>
                <strong>Desculpe!</strong> Tente novamente mais tarde.
              </div>";
  }

  }

}
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
if(isset($_POST['novasess'])) {
 
  $titulo = strip_tags($_POST['nomesessao']);
 $titulo = $DBcon->real_escape_string($titulo);
  
  $query = "INSERT INTO sessoes(sessao) VALUES('$titulo')";
  if ($DBcon->query($query))
  {
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}

}
?>
<?php
if(isset($_POST['novaenquetee'])) {
 
  $titulo = strip_tags($_POST['tituloenn']);
 $titulo = $DBcon->real_escape_string($titulo);
  

    $queryo = "INSERT INTO ordemdodia(ordem) VALUES('$titulo')";
  if ($DBcon->query($queryo))
  {
  $msg2 = "<br><div class='alert alert-success alert-dismissible' role='alert'>
  <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
  <strong>Pronto!</strong> Concluído com sucesso.
</div>";
} else {
    $msg2 = "<br><div class='alert alert-danger alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert'>
    <span aria-hidden='true'>&times;</span>
            </button>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
            </div>";
}
}
?>
<!DOCTYPE html>
<html lang="pt">

<head><meta charset="utf-8">
  
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Administração da Câmara
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
</head>

<body class="user-profile">
  <div class="wrapper ">
  <?php 
  echo '<div class="sidebar" data-color="'.$cormenu.'">';
  ?>  
      <!--
        Alterar a cor usando: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a class="simple-text logo-mini">
          LT
        </a>
        <a class="simple-text logo-normal">
ADMINISTRAÇÃO
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
        </ul>
      </div>
    </div>
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
            <a class="navbar-brand" href="#">Câmara Municipal de <?php echo $nomecam;?></a>
          </div>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">

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
                <h5 class="title">Painel de administração</h5>
                <p>Você está administrando <strong><?php echo $nomecam;?></strong></p>
              </div>
              <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Configurações da Câmara</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="crono-tab" data-toggle="tab" href="#crono" role="tab" aria-controls="crono" aria-selected="false">Configurar cronômetros</a>
  </li>

     <li class="nav-item" role="presentation">
     <a class="nav-link" id="sess-tab" data-toggle="tab" href="#sess" role="tab" aria-controls="sess" aria-selected="true">Iniciar Sessão</a>
   </li>

  <li class="nav-item" role="presentation">
    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">Adicionar votação</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Adicionar Ordem do dia</a>
  </li>

    <li class="nav-item">
    <a class="nav-link" id="sessv-tab" data-toggle="tab" href="#sessv" role="tab" aria-controls="sessv" aria-selected="false">Sessões e votações</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Excluir votação</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#vere" role="tab" aria-controls="vere" aria-selected="false">Excluir vereador</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#rel" role="tab" aria-controls="rel" aria-selected="false">Relatórios</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="sec-tab" data-toggle="tab" href="#sec" role="tab" aria-controls="sec" aria-selected="false">Segurança</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
<?php 
                                        if (isset($msg2)) 
                                        {
                                        echo $msg2;
                                        }
                                        ?>
<div class="tab-pane fade" id="home2" role="tabpanel" aria-labelledby="home-tab">
  
  <form role="form" action="" autocomplete="off" method="post">
            <div class="row">
        <div class="col-md-12">

        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <strong><label>SESSÃO Nº</label></strong>
            <select class="form-control" id="categoria" name="categoria" required>
<option id="1" data-sssid="1" value="1" selected="selected">Selecione uma sessão</option> ';
<?php
            $query=$DBcon->query("SELECT * FROM sessoes ORDER BY id DESC");
$count=$query->num_rows;
if($count>=1)
{
while($enquete=$query->fetch_array())
{
       $id = $enquete['id'];
       $enquete = $enquete['sessao'];
          echo '<option id="'.$id.'" data-sssid="'.$id.'" style="background-color: grey; color: white;"  value="'.$enquete.'">SESSÃO: '.$enquete.'</option> ';
}
}

            
            
            echo '</select>
          </div>
        </div>
      </div>

        <div class="form-group" hidden>
    <input type="text" class="form-control" name="lastide" value="'.$lastid.'" >
  </div>
                      <div class="form-group">
                        <label>Nome da votação</label>
                        <input type="text" class="form-control" placeholder="Ex: Projeto de Lei nº1111/2021" name="tituloen">
                      </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Descrição</label>
                        <textarea rows="4" cols="80" class="form-control" placeholder="Descrição da votação" name="sobreen"></textarea>
                      </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary" name="novaenquete">Enviar projeto para votação</button>
</form>
  </div>';
?>
<div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
  
  <form role="form" action="" autocomplete="off" method="post">
            <div class="row">
        <div class="col-md-12">
                      <div class="form-group">
                        <label><strong>Ordem do Dia</strong></label>
                        <input type="text" class="form-control" placeholder="Ex: Projeto de Lei nº1111/2021" name="tituloenn">
                      </div>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary" name="novaenquetee">Enviar Ordem do Dia</button>
</form>
  
  </div>

<div class="tab-pane fade" id="sess" role="tabpanel" aria-labelledby="sess-tab">
  
  <form role="form" action="" autocomplete="off" method="post">
            <div class="row">
        <div class="col-md-12">
  
        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <strong><label>INFORME A SESSÃO Nº</label></strong>
            <input type="text" class="form-control" placeholder="Definir a sessão para organizar votações. Ex: 123/2022" name="nomesessao">
          </div>
        </div>
      </div>
  
      <button type="submit" class="btn btn-primary" name="novasess">REGISTRAR SESSÃO</button>
  </form>
  
  </div></div></div>
  
<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <div class="card-body">
                <form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Nome da câmara</label>
                        <input type="text" class="form-control" placeholder="Nome da câmara" value="<?php echo $nomecam;?>" name="nome">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Nome da casa</label>
                        <input type="text" class="form-control" placeholder="Casa legislativa de XYZ" value="<?php echo $nomecam2;?>" name="nome2">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Cor menu lateral (Disponíveis: blue | green | orange | red | yellow)</label>
                        <input type="text" class="form-control" placeholder="Cor menu lateral" value="<?php echo $cormenu;?>" name="cormenu">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Cor de fundo do exibidor</label>
                        <input type="text" class="form-control" placeholder="Cor exibidor" value="<?php echo $corexibidor;?>" name="corexibidor">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Cor do texto do exibidor</label>
                        <input type="text" class="form-control" placeholder="Cor exibidor" value="<?php echo $cortxtexibidor;?>" name="cortxtexibidor">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Cor geral (acesso, registro, página inicial, etc)</label>
                        <input type="text" class="form-control" placeholder="Cor geral" value="<?php echo $corgeral;?>" name="corgeral">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>ID do presidente da câmara</label>
                        <input type="text" class="form-control" placeholder="Cor geral" value="<?php echo $idpp;?>" name="idpp">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tem lista de presença?</label>
                        
                        <select class="form-control" id="listapresenca" name="listapresenca" required>
                            <?php
                            $qtitulo321 = $DBcon->query("SELECT * FROM camconfig LIMIT 1");
                            if ($qqtitulo321=$qtitulo321->fetch_array())
                            {
                              $temPresenca = $qqtitulo321['tempresenca'];
                              if($temPresenca=="0")
                              {
                                  echo '<option id="0" data-sssid="0" value="0" selected="selected">Não</option>
                        <option id="1" data-sssid="1" value="1">Sim</option>';
                              }
                              else
                              {
                                echo '<option id="0" data-sssid="0" value="0">Não</option>
                        <option id="1" data-sssid="1" value="1" selected="selected">Sim</option>';  
                              }
                            }
                            ?>
                        
                        </select>
                        
                      </div>
                    </div>
                  </div>

                  <center><label>Para definir uma cor de fundo/texto do exibidor, utilize os nomes das cores em INGLÊS.
                    <br>Para definir a cor de fundo geral, utilize o código Hexadecimal(Exemplo: #xyz123).
                    <br><strong><a href="https://www.w3schools.com/colors/colors_names.asp" target="_blank">VERIFIQUE AS CORES AQUI</a></strong>
                  </label></center>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="salvar">Salvar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  </form>
<hr>
<div class="row">
                    <div class="col-md-12">
                      <center>
                        <img class="img-fluid" width="300" src="<?php 
                      echo $logo;
                    ?>">
                    
                    <form role="form" action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
         <label class="btn btn-warning btn-file"><img src="newavicon.png" width="32">
          <input type="file" onchange="this.form.submit()" style="display: none;" name="imge" /></label>
      </form>
                    
                      </center>
                    </div>
                  </div>
<hr>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <a href="sair" class="btn btn-danger btn-block" style="color:white;">Sair</a>
                        </div>
                      </div>
                    </div>
                  </div>

                
              </div>
              </div>
              
              
  <div class="tab-pane fade" id="sessv" role="tabpanel" aria-labelledby="sessv-tab">
<p>Exibindo as últimas 10 sessões</p>
<?php
$queryordem=$DBcon->query("SELECT * FROM sessoes ORDER BY id DESC LIMIT 10");
$countordem=$queryordem->num_rows;
if($countordem>=1)
{ 
while($enqueteordem=$queryordem->fetch_array())
{
$idvot = $enqueteordem['id'];  
$ordem = $enqueteordem['sessao'];
echo '<strong><p>[ID: '.$idvot.'] '.$ordem.'</p></strong>';
}
}
?>
<center>
<strong>************************************************************</strong>
<p><strong>***</strong>Digite o <strong>NÚMERO DO ID</strong> da sessão para remover permanentemente.<strong>***</strong></p>
<strong>************************************************************</strong>
</center>
<form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="ID" value="" name="idremovess">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="removesess">Remover sessão permanentemente</button>
                        </div>
                      </div>
                    </div>
                  </div>
</form>

<hr>

<p>Exibindo as últimas 10 votações</p>
<?php
$queryordem=$DBcon->query("SELECT * FROM enquetes ORDER BY id DESC LIMIT 10");
$countordem=$queryordem->num_rows;
if($countordem>=1)
{ 
while($enqueteordem=$queryordem->fetch_array())
{
$idvot = $enqueteordem['id'];  
$ordem = $enqueteordem['titulo'];
$ordem2 = $enqueteordem['descricao'];
echo '<strong><p>[ID: '.$idvot.'] '.$ordem.' - '.$ordem2.'</p></strong>';
}
}
?>
<center>
<strong>************************************************************</strong>
<p><strong>***</strong>Digite o <strong>NÚMERO DO ID</strong> da votação e o novo título para atualizar.<strong>***</strong></p>
<strong>************************************************************</strong>
</center>
<form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="ID" value="" name="idup">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Novo título/nome" value="" name="txtup">
                      </div>
                    </div>
                  </div>
                                    <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nova descrição" value="" name="txtup2">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-info btn-block" name="attvota">Atualizar</button>
                        </div>
                      </div>
                    </div>
                  </div>
</form>

  </div>              

  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
<p>Exibindo as últimas 10 votações</p>
<?php
$queryordem=$DBcon->query("SELECT * FROM enquetes ORDER BY id DESC LIMIT 10");
$countordem=$queryordem->num_rows;
if($countordem>=1)
{ 
while($enqueteordem=$queryordem->fetch_array())
{
$idvot = $enqueteordem['id'];  
$ordem = $enqueteordem['titulo'];
echo '<strong><p>[ID: '.$idvot.'] '.$ordem.'</p></strong>';
}
}
?>
<center>
<strong>************************************************************</strong>
<p><strong>***</strong>Digite o <strong>NÚMERO DO ID</strong> da votação para remover permanentemente.<strong>***</strong></p>
<strong>************************************************************</strong>
</center>
<form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="ID" value="" name="idremove">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="removevota">Remover votação permanentemente</button>
                        </div>
                      </div>
                    </div>
                  </div>
</form>
  </div>


  <div class="tab-pane fade" id="vere" role="tabpanel" aria-labelledby="vere-tab">
<?php
$queryordem2=$DBcon->query("SELECT * FROM usuarios ORDER BY user_id ASC");
$countordem2=$queryordem2->num_rows;
echo '<p>Exibindo todos os '.$countordem2.' vereadores registrados no sistema</p>';
if($countordem2>=1)
{ 
while($enqueteordem2=$queryordem2->fetch_array())
{
$idvot = $enqueteordem2['user_id'];  
$ordem = $enqueteordem2['nome'];
$usrve = $enqueteordem2['usuario'];
echo '<strong><p>[ID: '.$idvot.'] '.utf8_decode($ordem).' (Usuário: '.$usrve.')</p></strong>';
}
}
?>
<center>
<strong>************************************************************</strong>
<p><strong>***</strong>Digite o <strong>NÚMERO DO ID</strong> do vereador para removê-lo permanentemente.<strong>***</strong></p>
<strong>************************************************************</strong>
</center>
<form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="ID" value="" name="idremove2">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="removevota2">Remover vereador permanentemente</button>
                        </div>
                      </div>
                    </div>
                  </div>
</form>

</div>


  <div class="tab-pane fade" id="sec" role="tabpanel" aria-labelledby="sec-tab">
<strong><p>Trocar senha de administrador</p></strong>
  <p>Digite uma nova senha no campo abaixo</p>
<form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nova senha" value="" name="idremove3">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="removevota3">Alterar senha</button>
                        </div>
                      </div>
                    </div>
                  </div>
</form>

  </div>


  <div class="tab-pane fade" id="rel" role="tabpanel" aria-labelledby="rel-tab">
<br>
  <strong><center><p>Exibindo todas as votações</p></center></strong>
<?php
$queryordem2=$DBcon->query("SELECT * FROM enquetes ORDER BY id DESC");
$countordem2=$queryordem2->num_rows;
if($countordem2>=1)
{ 
while($enqueteordem2=$queryordem2->fetch_array())
{
$idvot = $enqueteordem2['id'];  
$ordem = $enqueteordem2['titulo'];
echo '<strong><p>[ID: '.$idvot.'] '.$ordem.'</p></strong>';
}
}
?>
<center>
<strong>************************************************************</strong>
<p><strong>***</strong>Digite o <strong>NÚMERO DO ID</strong> da votação para gerar o relatório.<strong>***</strong></p>
<strong>************************************************************</strong>
</center>
<form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="ID" value="" name="idrel">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="gerarel">Gerar relatório da votação</button>
                        </div>
                      </div>
                    </div>
                  </div>
</form>

</div>


  <div class="tab-pane fade" id="crono" role="tabpanel" aria-labelledby="crono-tab">
  <center><p><strong>***INSERIR SOMENTE O VALOR DO MINUTO***</strong></p></center>
  <form role="form" action="" autocomplete="off" method="post">
  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tempo de discurso (ex: 4)</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo $discurso;?>" name="t1">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tempo de aparte (ex: 1)</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo $aparte;?>" name="t2">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tempo de questão de ordem (ex: 10)</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo $qordem;?>" name="t3">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Tempo de considerações finais (ex: 5)</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo $cfinal;?>" name="t4">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="removevota4">Salvar cronômetros</button>
                        </div>
                      </div>
                    </div>
                  </div>
</form>
<center><p><strong>***INSERIR SOMENTE O VALOR DO MINUTO***</strong></p></center>
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