<?php


namespace App\Infrastructure\Traits;


use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

trait DateScopeTrait
{
    public function scopeByDate(Builder $query,$variable, $date): Builder
    {
        return $query->where($variable, 'like', $date.'%');
    }

    public function scopeDateStartsBefore(Builder $query,$variable, $date): Builder
    {
        return $query->where($variable, '<=', Carbon::parse($date));
    }

    public function scopeDateEndsBefore(Builder $query,$variable, $date): Builder
    {
        return $query->where($variable, '>=', Carbon::parse($date));
    }

    public function scopeDateInBetween(Builder $query,$variable, $start_date,$end_date): Builder
    {
        return $query->where($variable, '<=', Carbon::parse($start_date))->where($variable,'>=',Carbon::parse($end_date));
    }
}
