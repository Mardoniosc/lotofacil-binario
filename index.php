<?php

$acertos = 0;
$concurso = 0;
$numeroAcertados = "";
$premio15 = "";
$premio14 = "";

$jogo = $_GET['jogo'];

if ($jogo) {
  $url = "https://api-jogos.servicosmsc.com.br/api/resultado/valida-resultado?loteria=lotofacil&concurso=0&numeros_jogados=" . $jogo;

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  $resultados = curl_exec($ch);
  $response = json_decode($resultados, true);


  $acertos = $response["Quantidade de Acertos"];
  $concurso = $response["concurso"];
  $numeroAcertados = $response["Números acertos"];
  $premio15 = $response["premiacoes"][0];
  $premio14 = $response["premiacoes"][1];

  // print_r($response);

  curl_close($ch);
  $hoje = date("d/m/Y H:i:s");

  $salvar = $concurso . " - " . $acertos . " - " . $hoje . "\n";
  $fp = fopen("resultado.txt", "a");
  fwrite($fp, $salvar);
  fclose($fp);
}

// echo "<br>";
// echo $acertos;
// echo "<br>";
// echo $concurso;
// echo "<br>";
// echo $numeroAcertados;
// echo "<br>";
// echo $jogo;
// echo "<br>";
// print_r($premio15);
// echo "<br>";
// print_r($premio14);
// echo "<br>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lotofacil Binario</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">

        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex flex-shrink-0 items-center">
            <img class="block h-8 w-auto lg:hidden" src="./lotofacil.png" alt="Your Company">
            <img class="hidden h-8 w-auto lg:block" src="./lotofacil.png" alt="Your Company">
          </div>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <a href="#" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Lotofacil</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pt-2 pb-3">
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
        <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Lotofacil</a>
      </div>
    </div>
  </nav>

  <?php if ($jogo) : ?>
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Ultimo Resultado Lotofacil</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalhes do resultado lotofacil</p>
      </div>
      <div class="border-t border-gray-200">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Jogo</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= $jogo; ?></dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Concurso</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= $concurso; ?></dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Acertos</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= $acertos; ?></dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Números Acertados</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= $numeroAcertados; ?></dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Prêmio 15</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Ganhadores <?= $premio15["vencedores"]; ?> - Valor R$ <?= $premio15["premio"]; ?></dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Prêmio 14</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">Ganhadores <?= $premio14["vencedores"]; ?> - Valor R$ <?= $premio14["premio"]; ?></dd>
          </div>
        </dl>
      </div>
    </div>
  <?php endif; ?>

  <?php if (!$jogo) : ?>
    <div role="alert" class="p-6">
      <div class="bg-orange-500 text-white font-bold rounded-t px-4 py-2">
        Atenção
      </div>
      <div class="border border-t-0 border-orange-400 rounded-b bg-orange-100 px-4 py-3 text-orange-700">
        <p>Nenhum jogo foi informado para válidação!</p>
        <p>exemplo => lotofacil-binario.servicosmsc.com.br?jogo=1,2,3,4,5,6</p>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($jogo) : ?>

    <div class="p-6 mt-5">

      <div class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
      <p class="font-bold">Autor Mardonio</p>
      <p>Caso tenha alguma dúvida entrar em contato.</p>
      </div>

    </div>
  <?php endif; ?>
</body>

</html>