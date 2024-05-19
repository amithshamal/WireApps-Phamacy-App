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


class MedicationController extends Controller
{

    public function index()
    {
        $Medications = Medication::all();
        return response()->json([
            'status' => true,
            'data' => MedicationResource::collection($Medications)
        ], Response::HTTP_OK);
    }


    public function store(StoreMedicationRequest $request)
    {
        if (Helper::validatePermission('medication.create')) {
            $medication = Medication::create($request->all());

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
            if (!$medication) {
                return response()->json(['message' => 'Medication not found'], Response::HTTP_NOT_FOUND);
            }

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
        $validatedData = $request->validated();

        if (Helper::validatePermission('medication.update')) {
            if (!$medication) {
                return response()->json(['message' => 'Medication not found'], Response::HTTP_NOT_FOUND);
            }
            $medication->update($request->all());
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
            if (!$medication) {
                return response()->json(['message' => 'Medication not found'], Response::HTTP_NOT_FOUND);
            }
            if (Helper::validatePermission('medication.permanently.delete')) {
                $medication->forceDelete();
            } else if (Helper::validatePermission('medication.delete')) {
                $medication->delete();;
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
