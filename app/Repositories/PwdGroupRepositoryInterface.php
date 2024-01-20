<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface PwdGroupRepositoryInterface
{
   public function all(): Collection;
   public function SavePwdGroup(array $data, $extra = null);
   public function getByGroupNumber($grp_number);
   public function getGroups();
}
