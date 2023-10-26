<?php

namespace WhiteFalcon\Decorators\Commands;

use Illuminate\Support\Str;
use function Laravel\Prompts\text;
use function Laravel\Prompts\select;

use function Laravel\Prompts\confirm;
use Illuminate\Filesystem\Filesystem;

class ModelMakeCommand extends BaseModelMakeCommand
{
    use WhiteMagic;

    protected function modelMigrationExists()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));
        $migrations = (new Filesystem)->files(database_path(DIRECTORY_SEPARATOR.'migrations'));

        foreach($migrations as $migration)
            if (\preg_match("~create_{$table}_table~", $path = $migration->getPathname())) {
                return $path;
            }
        return false;
    }

    protected function generateMigrationColumns($path)
    {
        (new Filesystem())->put(
            $path,
            \preg_replace(
                '~//~',
                $this->makeMigrationColumns(),
                (new Filesystem())->get($path)
            )
        );
    }

    protected function makeMigrationColumns()
    {
        $columns = '';
        foreach ($this->columnsAttributes as $column) {
            $this->comment(
                $codeLine = sprintf(
                "\$table->%s('%s')%s;",
                    $column->type,
                    $column->name,
                    $column->nullable ? '->nullable()' : ''
                )
            );
            $columns .= $codeLine . "\n" . str_repeat("\x20", 12);
        }
        return $columns;
    }


    protected function handleColumnsAttributes()
    {
        $this->columnsAttributes = $this->askColumnQuestions(\range(1, $this->promptNoOfColumns()));
    }

    protected function askColumnQuestions($columns)
    {
        \array_walk($columns, [$this, 'prompts']);
        return $columns;
    }

    protected function promptNoOfColumns()
    {
        return text(
            \str(__FUNCTION__)->remove('prompt')->headline() . '?',
            required: true,
            validate: fn (string $value) => match (true) {
                !is_numeric($value) => 'Value must be integer.',
                default => null
            },
            hint: 'No. of columns you want to add',
        );
    }

    protected function prompts(&$column)
    {
        $column = (object) [
            'name' => $this->promptColumnName($column),
            'type' => $this->promptColumnType(),
            'nullable' => $this->promptNullable()
        ];
    }

    protected function promptColumnName($columnNo)
    {
        return text(
            \sprintf('%s: %s?', $columnNo, \str(__FUNCTION__)->remove('prompt')->headline()),
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 2 => 'The name must be at least 2 characters.',
                strlen($value) > 255 => 'The name must not exceed 255 characters.',
                default => null
            },
            hint: 'Name of the column'
        );
    }

    protected function promptColumnType()
    {
        return $this->getColumnTypeFromKey(
            select(
                \str(__FUNCTION__)->remove('prompt')->headline() . '?',
                $this->getColumnTypeOptions(),
                default: 's'
            )
        );
    }

    protected function promptNullable()
    {
        return confirm(
            \str(__FUNCTION__)->remove('prompt')->headline() . '?',
            false,
            hint:'Column is nullable'
        );
    }

    protected function getColumnTypeOptions()
    {
        return $this->indentArray([
            's'  => 's: string %s VARCHAR (255)',
            'f'  => 'f: foreignId %s UNSIGNED BIGINT WITH FOREIGN KEY',
            't'  => 't: text %s VARCHAR (65535)',
            'u'  => 'u: unsignedInteger %s INTEGER (0 to 4294967295)',
            'i'  => 'i: integer %s INTEGER (-2147483648 to 2147483647)',
            'b'  => 'b: boolean %s TINY INTEGER (0 to 255)',
            'ti' => 'ti: tinyInteger %s TINY INTEGER (0 to 255)',
            'bi' => 'bi: bigInteger %s BIG INTEGER (-9223372036854775808 to 9223372036854775807)',
            'ui' => 'ui: unsignedBigInteger %s BIG INTEGER (0 to 18446744073709551615)',
            'lt' => 'lt: longText %s LONG TEXT (4GB)',
        ]);
    }

    protected function indentArray($array, $from = '%s', $max = 25)
    {
        foreach ($array as $key => $string)
            $array[$key] = $this->indent(
                $string,
                ($max - \strpos($string, $from))
            );

        return $array;
    }

    protected function indent($string, $difference, $char = '.')
    {
        return \sprintf($string, \str_repeat($char, $difference));
    }

    protected function getColumnTypeFromKey($key)
    {
        return match ($key) {
            's' => 'string',
            'f' => 'foreignId',
            't' => 'text',
            'u' => 'unsignedInteger',
            'b' => 'boolean',
            'i' => 'integer',
            'ti' => 'tinyInteger',
            'bi' => 'bigInteger',
            'ui' => 'unsignedBigInteger',
            'lt' => 'longText',
        };
    }
}
