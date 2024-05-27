<?php
namespace App\Repositories\Medication;

use App\Models\Medication;

interface MedicationRepositoryInterface{

    public function all();

    public function create($data);

    public function update(Medication $medication,$data);

    public function delete(Medication $medication);
    
    public function forceDelete(Medication $medication);
}
