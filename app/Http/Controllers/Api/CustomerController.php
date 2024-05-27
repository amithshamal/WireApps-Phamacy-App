<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Helpers\Helper;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository; // 2. bind only concert class

class CustomerController extends Controller
{
    protected $customerRepository;
    
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    // 2. bind only concert class
    // public function __construct(CustomerRepository $customerRepository)
    // {
    //     $this->customerRepository = $customerRepository;
    // }

    public function index()
    {
        $customers = $this->customerRepository->all();
        return response()->json([
            'status' => true,
            'data' => CustomerResource::collection($customers)
        ], Response::HTTP_OK);
    }

    public function store(StoreCustomerRequest $request)
    {
        if (Helper::validatePermission('customer.create')) {
            $customer = $this->customerRepository->create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Customer created successfully!',
                'data' => new CustomerResource($customer)
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to perform this action',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function show(Customer $customer)
    {
        return response()->json([
            'status' => true,
            'data' => new CustomerResource($customer)
        ], Response::HTTP_OK);
    }


    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        if (Helper::validatePermission('customer.update')) {
            $updatedCustomer = $this->customerRepository->update($customer, $request->all());
            return response()->json([
                'status' => true,
                'message' => 'Customer updated successfully!',
                'data' => new CustomerResource($updatedCustomer)
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to perform this action',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }


    public function destroy(Customer $customer)
    {
        if (Helper::validatePermission('customer.permanently.delete') || Helper::validatePermission('customer.delete')) {
            if (Helper::validatePermission('customer.permanently.delete')) {
                $this->customerRepository->forceDelete($customer);
            } else if (Helper::validatePermission('customer.delete')) {
                $this->customerRepository->delete($customer);
            }
            return response()->json([
                'status' => true,
                'message' => 'Customer deleted successfully!',
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to perform this action',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
