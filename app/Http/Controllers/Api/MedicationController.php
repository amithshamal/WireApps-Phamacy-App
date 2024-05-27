<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Medication\StoreMedicationRequest;
use App\Http\Requests\Medication\UpdateMedicationRequest;
use App\Http\Resources\MedicationResource;
use App\Models\Medication;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Helpers\Helper;
use App\Repositories\Medication\MedicationRepositoryInterface;

class MedicationController extends Controller
{
    protected $medicationRepository;

    public function __construct(MedicationRepositoryInterface $medicationRepository)
    {
        $this->medicationRepository = $medicationRepository;
    }

    public function setup()
    {
        echo 'How to apply Repository Design Pattern<br />';
        echo 'mkdir app/Repositories/Medication<br />';
        echo 'touch app/Repositories/Medication/MedicationRepositoryInterface.php and touch app/Repositories/Medication/MedicationRepository.php/<br />';
        echo 'include all,create,find,update,delete and forceDelete for interface and implement it in MedicationRepository class<br />';
        echo 'create medicationRepository instance in controller class and call to relevant method in medicationRepository class<br />';
        echo 'bind service class to app/Providers/AppServiceProvider<br />';
        echo 'use $this->app->bind(MedicationRepositoryInterface::class, MedicationRepository::class); or <br />';
        echo 'use $this->app->bind(MedicationRepository::class); (only add concrete class) <br />';
    }


    public function index()
    {
        $Medications = $this->medicationRepository->all();
        return response()->json([
            'status' => true,
            'data' => MedicationResource::collection($Medications)
        ], Response::HTTP_OK);
    }


    public function store(StoreMedicationRequest $request)
    {
        if (Helper::validatePermission('medication.create')) {
            $medication = $this->medicationRepository->create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'medication created successfully!',
                'data' => new MedicationResource($medication)
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to perform this action',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function show(Medication $medication)
    {
        try {
            return response()->json([
                'status' => true,
                'data' => new MedicationResource($medication)
            ], Response::HTTP_OK);
        } catch (NotFoundHttpException $e) {
            return response()->json(['error' => 'Medication not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(UpdateMedicationRequest $request, Medication $medication)
    {

        if (Helper::validatePermission('medication.update')) {
            $this->medicationRepository->update($medication,$request->all());
            return response()->json([
                'status' => true,
                'message' => 'Medication updated successfully!',
                'data' => new MedicationResource($medication)
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to perform this action',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function destroy(Medication $medication)
    {
        if (Helper::validatePermission('medication.permanently.delete') || Helper::validatePermission('medication.delete')) {
            if (Helper::validatePermission('medication.permanently.delete')) {
                $this->medicationRepository->forceDelete($medication);
            } else if (Helper::validatePermission('medication.delete')) {
                $this->medicationRepository->delete($medication);
            }
            return response()->json([
                'status' => true,
                'message' => 'Medication deleted successfully!',
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not authorized to perform this action',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
