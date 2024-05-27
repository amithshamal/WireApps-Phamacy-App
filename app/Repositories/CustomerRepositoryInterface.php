<?php

namespace App\Repositories;

use App\Models\Customer;

interface CustomerRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function update(Customer $customer, array $data);

    public function delete(Customer $customer);

    public function forceDelete(Customer $customer);
}
