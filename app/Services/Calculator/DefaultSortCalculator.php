<?php
namespace App\Services\Calculator;

use App\Services\Contract\SortCalculator;

class DefaultSortCalculator implements SortCalculator
{

    /**
     *
     * @param \Illuminate\Support\Collection $data
     * @return \Illuminate\Support\Collection
     */
    public function process(\Illuminate\Support\Collection $data): \Illuminate\Support\Collection
    {
        return $data;
    }
}
