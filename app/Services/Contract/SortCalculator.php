<?php
namespace App\Services\Contract;

use Illuminate\Support\Collection;

interface SortCalculator
{
    /**
     * @param \Illuminate\Support\Collection $data
     * @return \Illuminate\Support\Collection
     */
    public function process(Collection $data): Collection;
}
