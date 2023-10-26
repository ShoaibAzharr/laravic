<?php

namespace WhiteFalcon\Traits;

trait BlueMagic
{
    public function fetchIndex($query) 
    {
        return $this->all();
    }

    public function fetchShow($query, $idOrModel) 
    {
        return $this->entity($idOrModel);
    }

    public function fetchStore($query, $requestData) 
    {
        return $this->create($requestData);
    }

    public function fetchCreate($query) 
    {
        return [];
    }

    public function fetchEdit($query, $idOrModel) 
    {
        return $this->entity($idOrModel);
    }

    public function fetchUpdate($query, $requestData, $idOrModel) 
    {
        return $this->entity($idOrModel)->update($requestData);
    }
 
    public function fetchDestroy($query, $idOrModel) 
    {
        return $this->entity($idOrModel)->delete();
    }

    private function entity($idOrModel) 
    {
        return $idOrModel instanceof ($this->model()) ? $idOrModel : $this->findOrFail($idOrModel);
    }
}
