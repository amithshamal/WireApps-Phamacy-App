<?php

namespace App\Repositories\Medication;

use App\Models\Medication;

class MedicationRepository implements MedicationRepositoryInterface
{

    public function all()
    {
        return Medication::all();
    }

    public function create($data)
    {
        return Medication::create($data);
    }

    public function update(Medication $medication, $data)
    {
        return $medication->update($data);
    }

    public function find()
    {
    }

    public function delete(Medication $medication)
    {
        return $medication->delete();
    }

    public function forceDelete(Medication $medication)
    {
        return $medication->forceDelete();
    }
}
