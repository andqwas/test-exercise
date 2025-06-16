<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends AbstractFilter
{
    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const STATUS = 'status';
    public const CREATED_AT_FROM = 'created_at_from';
    public const CREATED_AT_TO = 'created_at_to';

    protected function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::DESCRIPTION => [$this, 'description'],
            self::STATUS => [$this, 'status'],
            self::CREATED_AT_FROM => [$this, 'createdAtFrom'],
            self::CREATED_AT_TO => [$this, 'createdAtTo'],
        ];
    }

    public function title(Builder $builder, $value): void
    {
        $builder->where('title', 'like', "%{$value}%");
    }

    public function description(Builder $builder, $value): void
    {
        $builder->where('description', 'like', "%{$value}%");
    }

    public function status(Builder $builder, $value): void
    {
        $builder->where('status', $value);
    }

    public function createdAtFrom(Builder $builder, $value): void
    {
        $builder->whereDate('created_at', '>=', $value);
    }

    public function createdAtTo(Builder $builder, $value): void
    {
        $builder->whereDate('created_at', '<=', $value);
    }
}
