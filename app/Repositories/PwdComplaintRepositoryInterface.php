<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface PwdComplaintRepositoryInterface
{
   public function all($reporter_type = 1): Collection;
   public function addComplaint($data, $extra = null);
   public function closeComplaint($data, $extra = null);
}
