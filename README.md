# Php Webdriver Manager

## Sobre

Este projeto tem o objetivo de gerenciar a instalação do chromedriver, mantendo a versão do executável compatível com a versão do chrome instalada.

## Tabela de conteúdos

<!--ts-->
* [Sobre](#sobre)
* [Tabela de Conteúdos](#tabela-de-conteúdos)
* [Pré-requisitos](#pré-requisitos)
* [Instalação](#instalação)
* [Como usar](#como-usar)
* [Referências](#referências)
* [Autor](#autor)
<!--te-->

## Pré-requisitos

* Php ^7.4
* Composer ^2

## Instalação

No cmd, dentro do diretório selecionado, digite o comando abaixo:

```shell
composer require mtelesborges/php-chromedriver-manager
```

## Como usar

Abaixo, um *snipet* de uso do gerenciador:

```PHP
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
```

## Referências

Esta biblioteca é inspirada na biblioteca python [webdriver-manager](https://pypi.org/project/webdriver-manager/).

## Autor

[Mailson Teles Borges](www.linkedin.com/in/mailson-teles-borges-b5b67bb0)
