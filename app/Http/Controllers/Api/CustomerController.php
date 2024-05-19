<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Helpers\Helper;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'status' => true,
            'data' => CustomerResource::collection($customers)
        ], Response::HTTP_OK);
    }


    public function store(StoreCustomerRequest $request)
    {
        if (Helper::validatePermission('customer.create')) {
            $customer = Customer::create($request->all());
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
            $customer->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Customer updated successfully!',
                'data' => new CustomerResource($customer)
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
                $customer->forceDelete();
            } else if (Helper::validatePermission('customer.delete')) {
                $customer->delete();;
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
