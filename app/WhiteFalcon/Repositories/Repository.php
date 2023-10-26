<?php


namespace WhiteFalcon\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\ForwardsCalls;

abstract class Repository
{
    use ForwardsCalls;

    private $model;

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function model();


    public function __construct()
    {
        $this->makeModel();
    }


    public function __call($method, $parameters)
    {
        if(\strpos($method,'fetch') !== false)
        {
            $method = \lcfirst(\substr($method, \strlen('fetch')));
            \array_shift($parameters);
        }

        return $this->forwardCallTo($this->model, $method, $parameters);
    }


    public static function __callStatic($method, $parameters)
    {
        return (new static)->forwardScopeCall('fetch'. \ucfirst($method), $parameters);
    }


    public function forwardScopeCall($method, $parameters)
    {
        return $this->$method($this->model,...$parameters);
    }


    public function makeModel()
    {
        $model = \resolve($this->model());

        $model instanceof Model ?: throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->model = $model;
    }

}
