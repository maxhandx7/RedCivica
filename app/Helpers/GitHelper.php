<?php 

namespace App\Helpers;

class GitHelper
{
    public static function lastCommit()
    {
        return trim(shell_exec('git log -1 --pretty="%h - %s"'));
    }
}