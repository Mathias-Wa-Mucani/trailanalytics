<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface ComplaintCategoryRepositoryInterface
{
   public function all(): Collection;
}
