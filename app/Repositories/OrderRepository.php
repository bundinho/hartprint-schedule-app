<?php
namespace App\Repositories;

use Illuminate\Support\Collection;

interface OrderRepository extends Repository
{
    /**
     * @param array $data
     * @return object
     */
    public function createOrUpdate(array $data): object;

    /**
     * Summary of getBy
     * @param array $data
     * @return object|null
     */
    public function getBy(array $data): object|null;

    /**
     * Summary of listOrdersToSchedule
     * @return \Illuminate\Support\Collection
     */
    public function listOrdersToSchedule(): Collection;
}
