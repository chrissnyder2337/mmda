<?php

//use Symfony\Component\Process\Process;

class TikaWrapper
{
    private function execute($option, $filepath)
    {

        $dir = __DIR__.'/';
        $command = 'java -jar '.$dir.'tika-app-1.4.jar '.$option.' '.$filepath;

        //$process = new Process($command);
        //$process->setWorkingDirectory($cwd);

        exec($command,$output,$return_var);
        //$process->run();
        print "<pre>";
        print_r($command);
        print_r($dir);
        print_r($output);

        $output = implode("\n", $output);

        print_r($output);
        print "</pre>";
        if (empty($output)) {
            throw new \RuntimeException($output);
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
        return json_decode($jsonMeta);
    }


}
