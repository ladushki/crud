<?php
/**
 * Created by PhpStorm.
 * User: larissa
 * Date: 2019-09-21
 * Time: 10:03
 */

use Illuminate\Support\Facades\DB;

if (!function_exists('ddd'))
{
    /**
     * Dump the passed variables and end the script.
     * Quick fix for not rendering dd() in browser's network tab.
     *
     * @param array $args
     */
    function ddd($args)
    {
        http_response_code(500);
        call_user_func_array('dd', $args);
    }
}

if (!function_exists('ddd_query'))
{
    $_global_query_count = 0;
    /**
     * Dump the next database query.
     * Quick fix for not rendering dd_query() in browser's network tab.
     *
     * @param int $count
     *
     * @return void
     */
    function dd_query($count = 1)
    {
        DB::listen(function($query) use ($count)
        {

            global $_global_query_count;

            while(strpos($query->sql, '?')) {
                $query->sql = preg_replace('/\?/', '"' . array_shift($query->bindings) . '"', $query->sql, 1);
            }

            if (++$_global_query_count === $count) {
                dd($query->sql);
            } else {
                dp($query->sql);
            }
        });
    }
}
if (!function_exists('dp')) {
    function dp(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }
    }
}
if (!function_exists('studly_case')) {
    function studly_case($str)
    {
      return \Illuminate\Support\Str::studly($str);
    }
}
