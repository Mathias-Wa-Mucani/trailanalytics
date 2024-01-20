<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface PublicationCategoryRepositoryInterface
{
   public function all(): Collection;
}
