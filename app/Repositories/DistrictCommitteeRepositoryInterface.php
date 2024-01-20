<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface DistrictCommitteeRepositoryInterface
{
   public function all(): Collection;
   public function create(array $attributes);
   public function getByDistrict($district_id);
   public function AddNewMember($data);
}
