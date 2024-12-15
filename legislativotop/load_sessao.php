<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');

$output = '';
$eid = $_POST['eid'];
$mid = $_POST['mid'];
$cnpj = $_POST['cnpj'];
$data = date('Y-m-d');

$output .= '<div name="lstenquetes" id="lstenquetes">
<form role="form" action="" autocomplete="off" method="post">
<select class="form-control" id="enquete2" name="enquete2">';

$query = $DBcon->query("SELECT * FROM enquetes WHERE categoria='".$eid."' ORDER BY id ASC");
$count = $query->num_rows;
$i = 0;

if ($count >= 1) {
    $output .= '<option id="1" data-eid="1" value="1" selected="selected">Selecione uma votação da Sessão ' . $eid . '</option>';

    while ($enquetee = $query->fetch_array()) {
        $i++;
        $id = $enquetee['id'];
        $enquete = $enquetee['titulo'];
        $votandoAgora = $enquetee['votando'];

        if ($cnpj == "Presidente") 
        {
            $query2 = $DBcon->query("SELECT * FROM votos WHERE enqueteid='" . $id . "'");
            $count2 = $query2->num_rows;

            if ($count2 >= 9) {
                $output .= '<option id="' . $id . '" data-eid="' . $id . '" style="background-color: black; color: white;">✅[' . $i . '] ' . $enquete . '</option> ';
            } else {
                $output .= '<option id="' . $id . '" data-eid="' . $id . '" style="background-color: white; color: black;">⛔[' . $i . '] ' . $enquete . '</option> ';
            }
        } 
        else 
        {
            $query2 = $DBcon->query("SELECT * FROM votos WHERE enqueteid='" . $id . "' AND usuario='" . $cnpj . "'");
            $count2 = $query2->num_rows;

            if ($count2 >= 1) 
            {
                while ($enquete2 = $query2->fetch_array()) 
                {
                    $meuvoto = $enquete2['modelo'];

                    if ($meuvoto == "Contra") 
                    {
                        $output .= '<option id="' . $id . '" data-eid="' . $id . '" style="background-color: DarkRed; color: white;" class="overrideRed">⛔[' . $i . '] ' . $enquete . '</option> ';
                    } else if ($meuvoto == "A Favor") {
                        $output .= '<option id="' . $id . '" data-eid="' . $id . '" style="background-color: green; color: white;" class="overrideGreen">✅[' . $i . '] ' . $enquete . '</option> ';
                    } else {
                        $output .= '<option id="' . $id . '" data-eid="' . $id . '" style="background-color: grey; color: white;" class="overrideGray">✋[' . $i . '] ' . $enquete . '</option> ';
                    }
                }
            } 
            else 
            {
                if($votandoAgora==1)
                {
                    $output .= '<option id="' . $id . '" data-eid="' . $id . '">[' . $i . '] ' . $enquete . '</option> ';
                }
                
            }
        }
    }
} else {
    $output .= '<option id="1" data-eid="1" value="1" selected="selected">Nenhuma votação em andamento.</option>';
}

$output .= '</select>   
</form>
</div>';

$queryv22 = $DBcon->query("SELECT * FROM camconfig LIMIT 1");
$countv22 = $queryv22->num_rows;

if ($countv22 >= 1) {
    while ($enquetev22 = $queryv22->fetch_array()) {
        $tempresenca = $enquetev22['tempresenca'] ?? null;
    }

    if ($cnpj == "Presidente" && $tempresenca == "1") {
        $output .= '<div name="lstvereadorespresentes" id="lstvereadorespresentes"><br>
        <form role="form" action="" autocomplete="off" method="post">
        <select class="form-control" id="vpresentes" name="vpresentes">';
        $output .= '<option id="1" data-eid="1" value="1" selected="selected">Registre a presença dos vereadores</option>';

        $queryv = $DBcon->query("SELECT * FROM usuarios ORDER BY user_id DESC");
        $countv = $queryv->num_rows;

        if ($countv >= 1) {
            while ($enquetev = $queryv->fetch_array()) {
                $vereador = $enquetev['nome'];
                $party = $enquetev['partido'];
                $user_id = $enquetev['user_id'];

                if ($vereador != ".") {
                    $output .= '<option id="' . $user_id . '" data-eid="' . $user_id . '">[' . $party . '] ' . utf8_decode($vereador) . '</option> ';
                }
            }
        }

        $output .= '</select>   
        </form>
        </div>';
    }
}

echo $output;
?>