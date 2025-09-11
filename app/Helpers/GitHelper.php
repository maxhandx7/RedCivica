<?php 

namespace App\Helpers;

class GitHelper
{
    public static function lastCommit()
    {
        $version = trim(shell_exec('git log -1 --pretty="%s"'));
        $server =$_SERVER["SERVER_NAME"] == "127.0.0.1";

        if ($server) {
            $version = "Desarrollo Local";
        } else {
            $version = trim(shell_exec('git log -1 --pretty="%s"'));
        }
    
        return $version;
    }
}