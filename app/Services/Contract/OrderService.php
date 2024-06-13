<?php
namespace App\Services\Contract;

interface OrderService
{
    /**
     * Summary of createOrDelete
     * @param array $data
     * @return object
     */
    public function createOrUpdate(array $data): object;
}
