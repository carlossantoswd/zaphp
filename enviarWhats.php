<?php
namespace Facebook\WebDriver; //Definição do namespace
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\WebDriverCapabilites;
use Lista;
use Facebook\WebDriver\Remote\LocalFileDetector;
header("Content-type: text/html; charset=utf-8"); //definindo o cabeçalho para utf-8
    
require_once('vendor/autoload.php');//realizando o autoload das classes pelo composer
require_once('dadosExcel.php');
require_once('Lista.php');
require_once('SeleniumClient/WebDriverWait.php');


$host = 'http://localhost:4444/wd/hub';

 // definindo a url como a do google

$arquivo = "arquivos/excel/".$_SESSION["campanha"].".xls";
$fotoVideo = $_FILES['fotoVideo'];
$mensagem = $_POST["mensagem"];


$obLista = new Lista("arquivos/excel/");
$obLista->adicionarNaPasta($fotoVideo, $_SESSION["campanha"]."foto");

$newFotoVideo = "arquivos/excel/".$_SESSION["campanha"]."foto".$_SESSION["extensao"];
   
$chromeOptions = new ChromeOptions();
$desiredcapabilities = DesiredCapabilities::chrome();
$desiredcapabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);
$desiredcapabilities->setCapability('acceptSslCerts', false);
$desiredcapabilities->setCapability('VERSION', "2.45");
$driver = RemoteWebDriver::create($host, $desiredcapabilities);

// Host default

$arrRec = dadosExcel(); 

$url = 'https://web.whatsapp.com/';
$driver->get($url);
$pesquisa = $driver->findElement(WebDriverBy::id('app'));
sleep(20);
echo "conecte QRcode";
echo "<br>";

$tamanhArr = count($arrRec);
    for($i = 0; $i < $tamanhArr; $i++){
        $block = 'block';
        if(!empty($arrRec[$i]["celular"])) {
        	try {

        	$url = "https://web.whatsapp.com/send?phone={$arrRec[$i]["celular"]}&text={$mensagem}";

        	$driver->get($url);

        	sleep(3);
	        $driver->wait()->until(
			    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath('//*[@id="main"]/footer/div[1]/div/span[2]/div/div[2]/div[2]/button'))
			);
			
			$pesquisa =  $driver->findElement(WebDriverBy::xpath('//*[@id="main"]/footer/div[1]/div/span[2]/div/div[2]/div[2]/button'));
        	$pesquisa->click();
	        sleep(3);
        	} catch (\Exception $e) {
	    		echo "<pre>";print_r($e);echo "</pre>";exit;
            }
        }
    }     
?>