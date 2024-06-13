<?php
namespace App\Repositories;

use App\Models\Product;

/**
 * Summary of EloquentUserRepository
 */
class EloquentProductRepository implements ProductRepository
{
    public function __construct(protected Product $product)
    {
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->product->orderBy('name', 'asc')->get();
    }


    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->product->create($data);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id)
    {
        return $this->product->find($id);
    }
}
