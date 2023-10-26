<?php

namespace WhiteFalcon\Traits;

trait GreenMagic
{
    private static $REQUESTS_NAMESPACE = '\\App\\Http\\Requests\\';
    
    protected $timestamps = [
        'created_at'
    ];

    protected $additionalColumns = [
        'id' => 'id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dateFormat = 'd-m-Y';

    protected $timeFormat = 'H:i:s';

    protected function getFromRequest($timestamps = false)
    {
        $columns = $this->process(($this->makeRequest())->rules());
        \array_walk($columns, fn(&$value, $key) => $value = $this->{$key});
        
        return $timestamps ? $this->timestamps($columns) : $columns;
    }

    protected function process($columns)
    {
        $columns = \array_filter(
            $columns,
            fn($column) => !\in_array($column, $this->hidden),
            ARRAY_FILTER_USE_KEY
        );
        
        return \array_unique([...$this->additionalColumns, ...$columns]);

    }

    private function makeRequest()
    {
        return new (
            static::$REQUESTS_NAMESPACE 
            . 'Store' 
            . str_replace('Resource', '', class_basename($this)) 
            . 'Request'
        );
    }

    private function timestamps($columns)
    {
        return \array_merge($columns, $this->beautifyTimeStamps($this->timestamps));
    }

    private function beautifyTimeStamps($timestamps)
    {
        foreach ($timestamps as $timestamp)
            $columns[$timestamp] = [
                'date' => $this->{$timestamp}->format($this->dateFormat),
                'time' => $this->{$timestamp}->format($this->timeFormat)
            ];
        return $columns;
    }

}
