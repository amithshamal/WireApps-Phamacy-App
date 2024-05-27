<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function all()
    {
        return Customer::all();
    }

    public function create(array $data)
    {
        return Customer::create($data);
    }

    public function find($id)
    {
        return Customer::find($id);
    }

    public function update(Customer $customer, array $data)
    {
        $customer->update($data);
        return $customer;
    }

    public function delete(Customer $customer)
    {
        return $customer->delete();
    }

    public function forceDelete(Customer $customer)
    {
        return $customer->forceDelete();
    }
}
