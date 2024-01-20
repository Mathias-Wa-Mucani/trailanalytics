<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface AppraisalFieldReviewRepositoryInterface
{
   public function addFieldReview(array $attributes);
   public function getByDeskReview($desk_review_id);
   public function getByFieldReview($field_review_id);
}
