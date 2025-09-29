<?php

namespace TypiCMS\Modules\Events\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Filters\Filter;

/**
 * @implements Filter<Model>
 */
class FilterRegistrations implements Filter
{
    /** @return Builder<Model> */
    public function __invoke(Builder $query, mixed $value, string $property): Builder
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        $columns = explode(',', $property);

        return $query->where(function (Builder $query) use ($columns, $value): void {
            foreach ($columns as $column) {
                if ($column === 'event_name') {
                    $query->orWhereHas('event', function ($query) use ($value): void {
                        $query->where('title', 'like', '%' . $value . '%');
                    });
                } else {
                    $query->orWhere($column, 'like', '%' . $value . '%');
                }
            }
        });
    }
}
