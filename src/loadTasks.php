<?php
namespace Evis\Robo;
use \Evis\Robo\TestEvis;

trait loadTasks
{
    /**
     * Example task to compile assets
     *
     * @param string $pathToCompileAssets
     * @return \MyAssetTasks\CompileAssets
     */
    protected function taskTestEvis($frase = 'DEFAULT')
    {
        // Always construct your tasks with the `task()` task builder.
        return new TestEvis($frase);
    }
}