<?php

namespace App\Repositories;

use App\Classes\CacheKeys;
use App\Models\ComplaintGrievanceCategory;
use Illuminate\Support\Collection;

class ComplaintCategoryRepository extends Repository implements ComplaintCategoryRepositoryInterface
{
    public function __construct(ComplaintGrievanceCategory $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->remember(CacheKeys::REMEMBER_TIME)->cacheTags(class_basename($this->model))->get();
    }
}
