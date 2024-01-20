<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface PwdServicesReceivedRepositoryInterface
{
   public function all(): Collection;
}
