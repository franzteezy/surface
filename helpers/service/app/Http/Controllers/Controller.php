<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    //get single
    public static function get($attr = null)
    {
    }

    //get many
    public static function fetch(Request $request)
    {
    }

    //create/save single
    public static function put(Request $request)
    {
    }

    //delete single
    public static function delete($attr = null)
    {
    }

    /***********HELPSERS***********/
    public static function getSql($builder)
    {
        $sql = $builder->toSql();
        foreach ($builder->getBindings() as $binding) {
            $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }

    public static function isUpdating($updates, $key): bool
    {
        if (!$updates) return true;
        if (in_array($key, $updates)) return true;
        if (array_key_exists($key, $updates)) return true;
        return false;
    }
}
