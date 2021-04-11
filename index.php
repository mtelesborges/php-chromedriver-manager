<?php

require __DIR__ . "\\vendor\\autoload.php";

use ChromeDriverManager\{System , ChromeDriverManager};

// diretório em que o chromedriver deverá ser instalado
$dir = __DIR__ . "\\bin";

$system = new System;
$webDriverManager = new ChromeDriverManager($dir);

// porta em que o chromedriver será executado
$port = 9515;

// verifica se há um processo do chromedriver em execução e encerra-o
$system->killProcess(null, $port);

// baixa o executável e salva-o no diretório especificado na istanciação da classe
$webDriverManager->saveExecutable();