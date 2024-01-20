<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface PwdSupportRequiredRepositoryInterface
{
   public function all(): Collection;
}
