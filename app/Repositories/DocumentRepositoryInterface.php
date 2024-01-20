<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface DocumentRepositoryInterface
{
   public function all(): Collection;
   public function getByDocmentTag($tag);
   public function getById($id);
}
