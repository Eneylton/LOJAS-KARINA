<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: text/html; charset=utf-8");

include "../Connect/connect.php";

$postjson = json_decode(file_get_contents('php://input'), true);


if($postjson['crud'] == "listar-fornecedores"){

    $data = array();
    
    $query = mysqli_query($mysqli, "SELECT * FROM fornecedores as f ORDER BY f.nome ASC LIMIT $postjson[start], $postjson[limit]");

    while($row = mysqli_fetch_array($query)){
        $data[] = array(
            'id'           => $row['id'],
            'data'         => $row['data'],
            'cnpj'         => $row['cnpj'],
            'telefone'     => $row['telefone'],
            'email'        => $row['email'],
            'nome'         => $row['nome'],
            'foto'         => $row['foto']
            
        );
    }

    if($query) $result = json_encode(array('success' => true,'result' =>$data));
    else $result = json_encode(array('success'=> false));
    echo $result;

}


elseif($postjson['crud'] == "adicionar"){
   
    $data = array();

    $radom     = date('Y-m-d_H_i_s');

    $entry     = base64_decode($postjson['foto']);

    $img       = imagecreatefromstring($entry);

    $directory = "../imgs/".$radom.".jpg";

    $caminho ="./imgs/".$radom.".jpg";

    imagejpeg($img, $directory);

    imagedestroy($img);


    $query   = mysqli_query($mysqli, "INSERT INTO fornecedores SET
              
               cnpj               = '$postjson[cnpj]',
               telefone           = '$postjson[telefone]',
               email              = '$postjson[email]',
               nome               = '$postjson[nome]',
               foto               = '$caminho'");

    $idadd = mysqli_insert_id($mysqli);

    if($query) $result = json_encode(array('success' => true, 'idadd' => $idadd));
    else $result = json_encode(array('success'=> false));
    echo $result;
}


elseif($postjson['crud'] == "editar"){

    $data = array();

    $radom     = date('Y-m-d_H_i_s');

    $entry     = base64_decode($postjson['foto']);

    $img       = imagecreatefromstring($entry);

    $directory = "../imgs/".$radom.".jpg";

    $caminho ="./imgs/".$radom.".jpg";

    imagejpeg($img, $directory);

    imagedestroy($img);

    $query   = mysqli_query($mysqli, "UPDATE categorias SET           
     
               cnpj               = '$postjson[cnpj]',
               telefone           = '$postjson[telefone]',
               email              = '$postjson[email]',
               nome               = '$postjson[nome]',
               foto               = '$caminho' WHERE id  = '$postjson[id]'");


    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false));
    echo $result;
}

elseif($postjson['crud'] == "editar2"){

    $data = array();

    $query   = mysqli_query($mysqli, "UPDATE fornecedores SET
           
     
               cnpj               = '$postjson[cnpj]',
               telefone           = '$postjson[telefone]',
               email              = '$postjson[email]',
               nome               = '$postjson[nome]',
               foto               = '$postjson[foto]' WHERE id  = '$postjson[id]'");


    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false));
    echo $result;
}

elseif($postjson['crud'] == "deletar"){

    $query   = mysqli_query($mysqli, "DELETE FROM fornecedores WHERE id  = '$postjson[id]'");
  

    if($query) $result = json_encode(array('success'=>true));
    else $result = json_encode(array('success'=>false, 'msg'=>'error, Por favor, tente novamente... '));
    echo $result;
}


?>



