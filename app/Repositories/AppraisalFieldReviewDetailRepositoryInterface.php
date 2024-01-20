<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface AppraisalFieldReviewDetailRepositoryInterface
{
   public function addFieldReview(array $attributes);
   public function getByDeskReview($desk_review_id);
}
