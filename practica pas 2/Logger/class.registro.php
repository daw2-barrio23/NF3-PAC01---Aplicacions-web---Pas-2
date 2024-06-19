<?php

class Registro extends DataBoundObject {

        protected $Message;
        protected $LogLevel;
        protected $LogDate;
        protected $Module;


        protected function DefineTableName() {
                return("logdata");
        }

        protected function DefineRelationMap() {
                return(array(
                        "message" => "Message",
                        "loglevel" => "LogLevel",
                        "logdate" => "LogDate",
                        "module" => "Module"
                ));
        }
}

?>