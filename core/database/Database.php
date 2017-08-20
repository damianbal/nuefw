<?php

namespace Core\Database;

class_alias('\RedBeanPHP\R','\R');

class Database
{
    /**
     *
     * @param $table string
     *
     * @return void
     */
    public function wipeTable($table) : void
    {
        \R::wipe($table);
    }

    /**
     *
     * @param $query string
     * @param $data array
     *
     * @return array
     */
    public static function get($query, $data = [])
    {
        return \R::getAll($query, $data);
    }

    /**
     * @static
     */
    public static function createTableForModel($model_class, $data, $seed = false)
    {
        $m = $model_class::create($data);

        if(!$seed) {
            $m->delete();
        }
    }

    /**
     *
     * @param $table_name string
     * @param $data array
     *
     * @return void
     */
    public static function createTable($table_name, $data) : void
    {
        $r = \R::dispense($table_name);

        foreach($data as $key => $value)
        {
            if($value == 'string')
            {
                $r[$key] = 'string';
            }
            else if($value == 'bool')
            {
                $r[$key] = FALSE;
            }
            else if($value = 'integer')
            {
                $r[$key] = 99999999999;
            }
        }

        $id = \R::store($r);
        \R::trash($r);
    }
}
