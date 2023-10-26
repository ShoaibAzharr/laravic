<?php

namespace WhiteFalcon\Traits;

trait BlackMagic
{
    protected $entity;

    private $name;

    public function __call($name, $arguments)
    {
        if( \preg_match('&make&', $name) ) {
            goto makeClass;
        }

        $this->entity = \str_replace('Controller', '', class_basename($this));

        return $this->forwardCall($this->name = $name, $arguments);

        // will make the namespace & entity optional attributes for devs who are weak in naming convention  
        makeClass: return match (\str_replace('make', '', $name)) {
            'Repository' => '\\App\\Repositories\\' . $this->entity  . 'Repository',
            'Resource' => '\\App\\Http\\Resources\\' . $this->entity . 'Resource',
            'Request' => '\\App\\Http\\Requests\\'. \ucfirst($this->name) . $this->entity . 'Request',
            'View' => (string) \str($this->entity)->plural()->lower() . '.' . $this->name,
        };
        
    }

    private function forwardCall($name, $arguments)
    {
        $this->args($arguments);

        return $this->response( $this->makeRepository()::$name(...$arguments ), $name);
    }

    private function response($data, $name)
    {
        return \is_a($this, \WhiteFalcon\Contracts\ApiResponse::class) 
        ? $this->handleApiResponse($data, $name)
        :( \is_a($this, \WhiteFalcon\Contracts\ViewResponse::class) 
        ? $this->handleViewResponse($data, $name, \str($this->entity)->camel())
        : $data);
    }

    private function handleApiResponse($data, $name) 
    {
        return match ($name) {
            'index' => $this->makeResource()::collection( $data ),
            'store', 'show' => $this->makeResource()::make( $data ),
            'update' => $this->json($this->updateMessage()),
            'destroy' => $this->json($this->deleteMessage()),
            default => $this->json( $data )
        };
    }

    private function handleViewResponse($data, $name, $entity) 
    {
        return match ($name) {
            'index' => \view($this->makeView())->{'with' . $entity->plural()}($data),
            'store' => \back()->withSuccess($this->createMessage())->{'with' . $entity}($data),
            'edit', 'show' => \view($this->makeView())->{'with' . $entity}($data),
            'create' => \view($this->makeView()),
            'update' => \back()->withSuccess($this->updateMessage()),
            'destroy' => \back()->withSuccess($this->deleteMessage()),
            default => $this->json( $data )
        };
    }

    protected function createMessage()
    {
        return $this->beautifyName($this->entity) . ' created successfully';
    }

    protected function updateMessage()
    {
        return $this->beautifyName($this->entity) . ' updated successfully';
    }

    protected function deleteMessage()
    {
        return $this->beautifyName($this->entity) . ' deleted successfully';
    }

    protected function json($data, $statusCode = 200)
    {
        return \response()->json([ 'data' => $data ], $statusCode);
    }

    private function beautifyName($name)
    {
        return (string) \str($name)->headline();
    }

    public function __get($name)
    {
        return  \property_exists( $this, $name ) ? $this->{$name} : false;
    }

    private function args( &$arguments )
    {
        if (\in_array($this->name, ['store', 'update'])) $this->handleRequestData($arguments);

        return;
    }

    private function handleRequestData( &$arguments )
    {
        // thinking of providing the dev an option to modify request data, will implement further if required 
        \array_unshift($arguments, \class_exists($class = $this->makeRequest()) ? \resolve($class)->validated() : \request()->all());
        !\is_a($this, \WhiteFalcon\Contracts\OwnByUser::class) ?: $arguments[0][ $this->userForeignKey ?: 'user_id' ] = \auth()->id() ?: 1; //@TODO: remove default 1 after testing
        
        return;
    }
}
