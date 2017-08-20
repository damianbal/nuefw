<?php

namespace Core\Database;

class_alias('\RedBeanPHP\R','\R');

class QueryBuilder
{
    public $table = '';
    public $query = "";
    public $data  = [];

    protected function __construct() {}

    public static function builder($table)
    {
        $q = new QueryBuilder();
        $q->table = $table;
        return $q;
    }

    public function selectAll()
    {
        $this->query .= "SELECT * FROM " . $this->table . " ";

        return $this;
    }

    public function orderBy($col, $t = "ASC")
    {
        $this->query .= "ORDER BY " . $col . " " . $t . " ";

        return $this;
    }

    /*
    public function where($key, $val)
    {
        $this->query .= "WHERE ".$key . "=:" . $key . " ";

        $this->data[':' . $key] = $val;

        return $this;
    }
    */

    public function where($column_values)
    {
        $this->query .= "WHERE ";

        foreach($column_values as $key => $value)
        {
            $this->query .= $key . "=:" . $key ." AND ";

            $this->data[':' . $key] = $value;
        }

        $new_query_str = substr($this->query, 0, -4);
        $this->query = $new_query_str;

        return $this;
    }

    public function orWhere($column_values)
    {
        $this->query .= "OR ";

        foreach($column_values as $key => $value)
        {
            $this->query .= $key . "=:" . $key ." OR ";

            $this->data[':' . $key] = $value;
        }

        $new_query_str = substr($this->query, 0, -3);
        $this->query = $new_query_str;

        return $this;

    }

    public function limit($a = 0, $b = 1)
    {
        $this->query .= "LIMIT ". $a . "," . $b;

        return $this;
    }

    public function get()
    {
        return \R::getAll($this->query, $this->data);
    }

    /**
     *
     * @return array
     */
    public function getModels($model_class)
    {
        $models = [];

        foreach($this->get() as $k)
        {
            $model       = new $model_class();
            $model->bean = \R::load( $model::$table, $k['id'] );

            $models[] = $model;
        }

        return $models;
    }
}
