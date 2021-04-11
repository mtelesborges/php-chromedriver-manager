<?php

namespace ChromeDriverManager;

use DirectoryIterator;

class ChromeDriverManager
{

    private $version;
    
    private $dir;

    public function __construct($dir = __DIR__)
    {
        $this->dir = $dir;
        (new System)->createDir($dir);
    }

    private function getChromeVersion(): string
    {
    
        $command = 'wmic datafile where name="C:\\\\Program Files (x86)\\\\Google\\\\Chrome\\\\Application\\\\chrome.exe" get Version /value';
        
        $response = shell_exec($command);
        $response = @trim($response);
        $response = str_replace("Version=", "", $response);

        $version = explode(".", $response);
    
        array_pop($version);
        
        $version = implode(".", $version);
    
        return $version;
    }
    
    private function getChromeDriverVersion(string $chromeVersion): string
    {
        
        $url = "https://chromedriver.storage.googleapis.com/LATEST_RELEASE_$chromeVersion";
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $version = curl_exec($ch);
    
        curl_close($ch);
        
        if(preg_match("/error/i", $version)){
            throw new \Exception($version);
        }

        return $version;
    }
    
    private function download(string $version): ?string
    { 
        $this->version = $version;

        $url = "https://chromedriver.storage.googleapis.com/$version/chromedriver_win32.zip";
        
        $dir = sys_get_temp_dir();        
        
        $fp = fopen($dir . DIRECTORY_SEPARATOR . 'driver.zip', 'w+');
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        
        curl_exec($ch);
    
        curl_close($ch);
    
        fclose($fp);
    
        $zip = new \ZipArchive;
    
        $content = null;

        if ($zip->open($dir . DIRECTORY_SEPARATOR . 'driver.zip') === TRUE) {
            
            $zip->extractTo($dir);
            $zip->close();

            $content = file_get_contents($dir . DIRECTORY_SEPARATOR . "chromedriver.exe");

        }else{
            throw new \Exception("Failed to open the zip file");
        }

        return $content;
    }

    public function getExecutable(?string $version = null, bool $force = false) : ?string
    {
        $version = $version ?? $this->getChromeDriverVersion($this->getChromeVersion());
        
        if($this->checkVersion($version) && $force === false){
            return null;
        };

        return $this->download($version);
    }

    public function saveExecutable(bool $force = false) : void
    {
        $content = $this->getExecutable(null, $force);
        
        if($content === null){
            return;
        }
        
        $this->clean();

        file_put_contents($this->dir . DIRECTORY_SEPARATOR . "chromedriver.exe", $content);
        file_put_contents($this->dir . DIRECTORY_SEPARATOR . ".version", $this->version);

    }

    private function clean(): self
    {

        $iterator = new DirectoryIterator($this->dir);
        
        foreach ($iterator as $file) {
            
            if($file->isFile() && !$file->isDot()){
                unlink($this->dir . DIRECTORY_SEPARATOR . $file->getFilename());
            }

        }

        return $this;
    }

    private function checkVersion($version):bool
    {
        $file = $this->dir . DIRECTORY_SEPARATOR . ".version";

        if(!is_file($file)){
            return false;
        }

        $content = file_get_contents($file);

        if($content == $version){
            return true;
        }

        return false;
    }
}