<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';


header("Content-Type: application/json; charset=utf-8");

$prompt = <<<TXT
Liste apenas 3 especialidades médicas reconhecidas no Brasil.

Responda SOMENTE em JSON.

Exemplo:

[
    "Cardiologista",
    "Neurologista",
    "Dermatologista"
]
TXT;

$url = "https://api.groq.com/openai/v1/chat/completions";

$dados = [

    "model" => "llama-3.3-70b-versatile",

    "messages" => [
        [
            "role" => "user",
            "content" => $prompt
        ]
    ],

    "temperature" => 0.2

];

$ch = curl_init($url);

curl_setopt_array($ch, [

    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,

    CURLOPT_HTTPHEADER => [

        "Authorization: Bearer " . GROQ_API_KEY,
        "Content-Type: application/json"

    ],

    CURLOPT_POSTFIELDS => json_encode($dados)

]);

$resposta = curl_exec($ch);

if(curl_errno($ch)){

    echo json_encode([
        "sucesso"=>false,
        "erro"=>curl_error($ch)
    ]);

    exit;

}

curl_close($ch);

$resultado = json_decode($resposta, true);

// Verifica erro da API
if(isset($resultado["error"])){

    echo json_encode([
        "sucesso"=>false,
        "erro"=>$resultado["error"]["message"]
    ]);

    exit;

}

// Conteúdo retornado pelo Groq
$jsonIA = $resultado["choices"][0]["message"]["content"] ?? "";

// Remove ```json
$jsonIA = str_replace("```json","",$jsonIA);
$jsonIA = str_replace("```","",$jsonIA);

$jsonIA = trim($jsonIA);

$especialidades = json_decode($jsonIA,true);

if(!is_array($especialidades)){

    echo json_encode([
        "sucesso"=>false,
        "erro"=>"A IA não retornou um JSON válido.",
        "resposta"=>$jsonIA
    ]);

    exit;

}

$novas = 0;
$existentes = 0;

foreach($especialidades as $especialidade){

    $especialidade = trim($especialidade);

    $sql = mysqli_prepare(

        $conexao,

        "SELECT id_especialidade
         FROM especialidade
         WHERE especialidade_medico=?"

    );

    mysqli_stmt_bind_param($sql,"s",$especialidade);

    mysqli_stmt_execute($sql);

    mysqli_stmt_store_result($sql);

    if(mysqli_stmt_num_rows($sql)==0){

        $insert = mysqli_prepare(

            $conexao,

            "INSERT INTO especialidade(especialidade_medico)
             VALUES(?)"

        );

        mysqli_stmt_bind_param($insert,"s",$especialidade);

        mysqli_stmt_execute($insert);

        $novas++;

    }else{

        $existentes++;

    }

}

echo json_encode([

    "sucesso"=>true,
    "novas"=>$novas,
    "existentes"=>$existentes

]);