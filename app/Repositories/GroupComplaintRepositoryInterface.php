<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface GroupComplaintRepositoryInterface
{
   public function all(): Collection;
   public function addComplaint($data);
}
