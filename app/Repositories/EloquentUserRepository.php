<?php
namespace App\Repositories;

use App\Models\User;

/**
 * Summary of EloquentUserRepository
 */
class EloquentUserRepository implements UserRepository
{
    public function __construct(protected User $user)
    {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->user->orderBy('name', 'asc')->get();
    }


    /**
     * @param array $data
     * @return object
     */
    public function create(array $data)
    {
        return $this->user->create($data);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function find(int $id)
    {
        return $this->user->find($id);
    }
}
