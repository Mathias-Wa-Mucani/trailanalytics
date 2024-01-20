<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface PwdGroupApplicationRepositoryInterface
{
   public function all(): Collection;
   public function SavePwdGroupApplication(array $data, $extra = null);
   public function getByApplicationNumber($application_number);
   public function getApplications();
}
