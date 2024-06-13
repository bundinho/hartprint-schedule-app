<?php
namespace App\Repositories;

interface Repository
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function all();


    /**
     * @param array $data
     * @return object
     */
    public function create(array $data);

    /**
     * @param int $id
     * @return object|null
     */
    public function find(int $id);
}
