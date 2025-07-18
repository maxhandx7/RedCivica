<?php 

namespace App\Helpers;

class GitHelper
{
    public static function lastCommit()
    {
        $version = trim(shell_exec('git log -1 --pretty="%s"'));
        return $version ? $version : 'Pruebas';
    }
}