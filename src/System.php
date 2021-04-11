<?php

namespace ChromeDriverManager;

class System
{
    
    /**
     * Gets PID
     * @throws \Exception
     */
    function getPID(int $port) : int
    {
    
        if(!$port){
            throw new \Exception("Port $port is invalid.", 1);
        }

        $command = "netstat -ano | find /i \"$port\"";
        $response = shell_exec($command);
    
        $elements = explode(" ", $response);
        return (int) @trim(array_pop($elements));
    
    }
    
    /**
     * Kill system process
     */
    function killProcess(?int $pid, int $port = null) : ?string
    {
        if($pid === null || empty($pid) || $pid == 0){
            $pid = $this->getPID($port);
        }

        if($pid === null || empty($pid) || $pid == 0){
            return null;
        }
    
        $command = "taskkill /F /PID $pid";
    
        $response = shell_exec($command);
    
        return $response;
    }

    public function createDir($dir) : self
    {
        if(!is_dir($dir)){
            mkdir($dir);
        }

        return $this;
    }
}