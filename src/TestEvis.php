<?php
namespace Evis\Robo;

class TestEvis implements \Robo\Contract\TaskInterface
{
    // configuration params
    protected $frase;

    function __construct($frase)
    {
        $this->frase = $frase;
       
    }

    // must implement Run
    function run()
    {
       echo "\n".$this->frase."\n\n";
    }
}
?>