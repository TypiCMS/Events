<?php

namespace TypiCMS\Modules\Events\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterRegistrations implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        $columns = explode(',', $property);

        return $query->where(function (Builder $query) use ($columns, $value) {
            foreach ($columns as $column) {
                if ($column === 'event_name') {
                    $query->orWhereHas('event', function ($query) use ($value) {
                        $query->where('title', 'like', '%' . $value . '%');
                    });
                } else {
                    $query->orWhere($column, 'like', '%' . $value . '%');
                }
            }
        });
    }
}
