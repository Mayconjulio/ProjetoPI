<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário | LM</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, #00c6ff, #0072ff);
        }
        .box{
            color: black;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: rgba(255, 255, 255);
            padding: 15px;
            border-radius: 15px;
            width: 20%;
        }
        fieldset{
            border: 3px solid  #0072ff;
        }
        legend{
            border: 1px solid  #0072ff;
            padding: 10px;
            text-align: center;
            background-color:  #0072ff;
            border-radius: 8px;
        }
        .inputBox{
            position: relative;
        }
        .inputUser{
            background: none;
            border: none;
            border-bottom: 1px solid black;
            outline: none;
            color: black;
            font-size: 15px;
            width: 100%;
            letter-spacing: 2px;
        }
        .labelInput{
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput{
            top: -20px;
            font-size: 12px;
            color: rgb(0, 49, 98);
        }
        #data_nascimento{
            border: none;
            padding: 8px;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
        }
        #submit{
            background:#0072ff;
            width: 100%;
            border: none;
            padding: 15px;
            color:  #ffffff;
            font-size: 15px;
            cursor: pointer;
            border-radius: 10px;
        }
        #submit:hover{
            background-image: linear-gradient(to right,rgb(33, 148, 255), rgb(0, 63, 122));
        }
        #VolTar{
            position: relative;
            background-color: rgb(33, 148, 255);
            color: #ffffff;
            padding: 10px;
            left: 4px;
            top: -15px;
            border: 1px solid;
            border-radius: 5px ;
            text-decoration: none;
            font-weight: bold;
        }
        #VolTar:hover{
            background-image: linear-gradient(to right,rgb(33, 148, 255), rgb(0, 63, 122));
        }
    </style>
</head>
<body>
    <div class="box">
    <?php
  if (isset($_GET['error'])) {
      echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
  }
  if (isset($_GET['success'])) {
      echo "<div class='success'>" . htmlspecialchars($_GET['success']) . "</div>";
  }
  ?>
        <form action="cadastro.php" method="post">
            <fieldset> 
                <legend><b>Faça Seu Cadastro</b></legend>
            
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input class="inputUser" id="senha" type="password" name="senha" required>
                    <label for="Senha" class="labelInput">Senha</label>
                </div>
                <br><br>
                <label for="data_nascimento"><b>Data de Nascimento:</b></label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
                <br><br><br>
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="estado" id="estado" class="inputUser" required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                <br><br> 
                <a href="../../public/paginicial.php" id="VolTar">Voltar para pagina Principal</a>
                <input id="submit" type="submit" value="Cadastrar">
            </fieldset>
        </form>
    </div>
</body>
</html>