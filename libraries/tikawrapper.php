<?php

//use Symfony\Component\Process\Process;

class TikaWrapper
{
    private function execute($option, $filepath)
    {

        $dir = __DIR__.'/';
        $command = 'java -jar '.$dir.'tika-app-1.4.jar '.$option.' '.escapeshellarg($filepath);


        exec($command,$output,$return_var);

        $output = implode("\n", $output);

        if (empty($output)) {
            return FALSE;
            //throw new \RuntimeException('command: '.$command. 'output: '.$output);
        }

        return $output;

    }

    public function getText($filepath)
    {
        return $this->execute("--text", $filepath);
    }

    public function getTextMain($filepath)
    {
        return $this->execute("--text-main", $filepath);
    }


    public function getLanguage($filepath)
    {
        return $this->execute("--language", $filepath);
    }

    public function getContentType($filepath)
    {
        return $this->execute("--detect", $filepath);
    }

    public function getXhtml($filepath)
    {
        return $this->execute("--xml", $filepath);

    }
    public function getHtml($filepath)
    {
        return $this->execute("--html", $filepath);
    }

    public function getMetaData($filepath)
    {
        $jsonMeta = $this->execute("--json", $filepath);
        if($jsonMeta){
            return json_decode($jsonMeta);
        }else{
            return FALSE;
        }
    }


}
