<?php
require("abstract.databoundobject.php");
require("class.pdofactory.php");
require('class.registro.php');

class postgresLoggerBackend{
    private $logFile; //nombre del fichero
	private $confile; //connexió del fitxer

    private $logLevel; //nivel para registrar los mensajes

	const DEBUG = 100;
	const INFO = 75;
	const NOTICE = 50;
	const WARNING = 25;
	const ERROR = 10;
	const CRITICAL = 5;

    private function __construct() {
        $this->logLevel = 100;

        $strDSN = "pgsql:dbname=database;host=localhost;port=5432";
        $objPDO = PDOFactory::GetPDO($strDSN, "postgres", "root", 
            array());
        $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->confile = new Registro($objPDO);
        


        //   if (!is_resource($this->confile)){
        //       printf("No puedo abrir el fichero %s", $this->logFile);
        //       return false;
        //   }
          echo "Connection opened...\n";

}

public static function getInstance(){
    static $objLog;
    if(!isset($objLog)){
        $objLog = new postgresLoggerBackend();
    }
    return $objLog;
}

public function __destruct(){
    if(is_resource($this->confile)){
        // fclose($this->confile);
    }
}


public function logMessage($msg, $logLevel = fileLoggerBackend::INFO){
    if ($logLevel > $this->logLevel){
        return false;
    }



    date_default_timezone_set('America/New_York');
      $formatterDate = DateTimeImmutable::createFromFormat('U',time());
      $time = $formatterDate->format('Y-m-d H:i:s');

      $msg = str_replace("\t", "", $msg);
      $msg = str_replace("\n", "", $msg);

      $module = 'pgsql_logdata';
    
    
    $this->confile->setMessage($msg);
    $this->confile->setLogDate($time);
    $this->confile->setLogLevel($logLevel);
    $this->confile->setModule($module);

    $this->confile->Save();


      


    //   $message = $time."\t".$logLevel."\t".$msg."\t".$module."\n";
    //   fwrite($this->confile, $message);

}

public static function levelToString($loglevel = null){

    switch ($loglevel) {
        case fileLoggerBackend::DEBUG:
            return 'DEBUG';
            break;
        case fileLoggerBackend::INFO:
            return 'INFO';
            break;
        case fileLoggerBackend::NOTICE:
            return 'NOTICE';
            break;
        case fileLoggerBackend::WARNING:
            return 'WARNING';
            break;
        case fileLoggerBackend::ERROR:
            return 'ERROR';
            break;
        case fileLoggerBackend::CRITICAL:
            return 'CRITICAL';
            break;			
        default:
            return '[OTHER]';
            break;
    }

}
}