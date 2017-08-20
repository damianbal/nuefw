<?php

namespace Core;
use Core\Database\Database;
use Core\Database\QueryBuilder;
use Core\ModelQueryBuilder;
use RedBeanPHP\R;

//class_alias('\RedBeanPHP\R','\R');

class ModelQueryBuilder
{
    public $qb = null;
    public $model_class = null;

    public function __construct($querybuilder, $modelclass)
    {
        $this->qb = $querybuilder;
        $this->model_class = $modelclass;
    }

    public function builder()
    {
        $this->qb->selectAll();

        return $this;
    }

    public function where($d)
    {
        $this->qb->where($d);

        return $this;
    }

    public function orWhere($d)
    {
        $this->qb->orWhere($d);

        return $this;
    }

    public function orderBy($col, $t = "ASC")
    {
        $this->qb->orderBy($col,$t);

        return $this;
    }

    public function limit($a,$b)
    {
        $this->qb->limit($a,$b);

        return $this;
    }

    public function get()
    {
        return $this->qb->getModels($this->model_class);
    }
}

class Model
{
    public static $table          = '';
    public $bean                  = null;

    public static                  $dates = true;

    public function __set ( $name , $value )
    {
        $this->bean[$name] = $value;
    }

    /**
     * @static
     */
    public static function create($data)
    {

        $r = R::dispense(static::$table);

        foreach($data as $key => $value)
        {
            $r[$key] = $value;
        }

        $r['created_at'] = R::isoDateTime();
        $r['updated_at'] = R::isoDateTime();

        $id = R::store($r);

        $m = new static();
        $m->bean = $r;
        return $m;

    }

    public function __get ( $name )
    {
        return $this->bean[$name];
    }

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * Returns query builder for table which is set for this Model
     *
     * @return \Core\Database\QueryBuilder
     */
    //public static function builder() : \Core\Database\QueryBuilder
    //{
    //    return QueryBuilder::builder(static::$table);
    //}
    public static function builder()
    {
        $mqb = new ModelQueryBuilder(QueryBuilder::builder(static::$table), static::class);

        return $mqb->builder();
    }

    /**
     *
     */
    public static function wipe()
    {
        Database::wipeTable(static::$table);
    }

    public function hasMany($model_class, $key)
    {
        // SELECT * FROM $model_class WHERE key=$key
        $m = [];
        $m = $model_class::builder()->where([$key => $this->get('id')])->get();
        return $m;
    }

    public function hasOne($model_class, $key)
    {
        $m = [];
        $m = $model_class::builder()->where([$key => $this->get('id')])->limit(0,1)->get();
        return $m;
    }

    public function get($name)
    {
        return $this->bean[$name];
    }

    /**
     *
     * @param $id integer
     *
     * @return \Core\Model
     */
    public static function find($id) : \Core\Model
    {
        $model = new static();
        $model->bean = R::load(static::$table, $id);
        return $model;
    }

    /**
     *
     * @return
     */
    public static function where($data)
    {
        $query_builder = QueryBuilder::builder(static::$table)->selectAll()->where($data)->get();

        $models = [];

        foreach($query_builder as $k)
        {
            $model       = new static();
            $model->bean = R::load( static::$table, $k['id'] );

            $models[] = $model;
        }

        return $models;
    }

    /**
     *
     * @return array
     */
    public static function all() : array
    {
        $query_builder = QueryBuilder::builder(static::$table)->selectAll()->get();

        $models = [];

        foreach($query_builder as $k)
        {
            $model       = new static();
            $model->bean = R::load( static::$table, $k['id'] );

            $models[] = $model;
        }

        return $models;
    }

    /**
     *
     * @return void
     */
     public function delete()
     {
         R::trash($this->bean);
     }

    /**
     *
     * @return void
     */
    public function save($update_date = true) : void
    {
        if($update_date)
        {
            $this->bean->updated_at = R::isoDateTime();
        }
        
        R::store($this->bean);
    }
}
