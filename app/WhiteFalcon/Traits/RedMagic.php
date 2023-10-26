<?php

namespace WhiteFalcon\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait RedMagic
{
    private static $magicRelations = [
        'hasOne',
        'hasMany',
        'belongsTo',
    ];

    private static $requests = [];

    private static $MODELS_NAMESPACE = '\\App\\Models\\';
    private static $REQUESTS_NAMESPACE = '\\App\\Http\\Requests\\';

    public static function bootRedMagic()
    {
        \config('white.model.disable_strictness', false) ?: self::forceModelStrictness(); 

        $definedRelations = self::getDefinedRelations($class = static::class);
        \array_walk($definedRelations, [$class, 'doMagic'], $class );
    }

    public function initializeRedMagic()
    {
        !\is_a($this, \WhiteFalcon\Contracts\FillableFromRequest::class) ?: $this->setFillableFromRequest(static::class);
    }

    private static function forceModelStrictness()
    {
        \config('white.model.allow_lazy_loading', false) ?: Model::preventLazyLoading( $isNotProduction = !app()->environment('production') );
        \config('white.model.silently_discard_attributes', false) ?: Model::preventSilentlyDiscardingAttributes( $isNotProduction );
    }

    private function setFillableFromRequest($class)
    {
        //setting this as static property to avoid multiple calling for same model or on every initialize
        $this->fillable = static::$requests[$class] ?? static::$requests[$class] = $this->mergedFillableFromRequestRules($class);
    }
    
    private function mergedFillableFromRequestRules($class)
    {
        return \array_unique(
            [
                ...$this->fillable,
                ...\array_keys(($this->makeRequestClass($class))->rules()),
                ...((\property_exists($class, 'BelongsTo') and \in_array('user', $class::$BelongsTo)) ? ['user_id'] : [])
            ]
        );
    }

    private static function doMagic($relation, $key, $model)
    {
        static::setMagicRelations($relation, $model);
    }

    private static function setMagicRelations($relation, $model)
    {
        foreach ($model::$$relation as $key => $relationship)
            $targetModel = ( \is_numeric($key) ? self::$MODELS_NAMESPACE : $key ) . Str::singular( \ucfirst($relationship) );
            $model::resolveRelationUsing($relationship, fn ($modelInstance) => $modelInstance->{$relation}($targetModel, self::makeForeignKeyName($model, $relation, $relationship)));
    }

    private static function getDefinedRelations($class)
    {
        $attributes = \get_class_vars($class);
        return \array_filter(self::$magicRelations, fn($relation) => isset($attributes[$relation]) and \is_array($attributes[$relation]) );
    }

    private static function makeForeignKeyName($model, $relation, $relationship)
    {
        return \lcfirst( ( \in_array($relation, ['BelongsTo']) ? $relationship : \class_basename($model) ) ) . '_id';
    }

    private function makeRequestClass($class)
    {
        return new (self::$REQUESTS_NAMESPACE . 'Store' . \class_basename($class) . 'Request');
    }
}
