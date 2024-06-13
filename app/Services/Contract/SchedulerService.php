<?php
namespace App\Services\Contract;

use Illuminate\Support\Collection;

interface SchedulerService
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function generate(): Collection;
}
