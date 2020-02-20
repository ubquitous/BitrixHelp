<?php


namespace Custom;


class GetScripts
{
    public static function includeScript()
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[0];
        if(isset($trace['class'])){

        }
    }
}