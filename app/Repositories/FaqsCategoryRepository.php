<?php

namespace App\Repositories;

use App\Classes\CacheKeys;
use App\Models\FaqsCategory;
use App\Models\PublicationCategory;
use App\Models\User;
use Illuminate\Support\Collection;

class FaqsCategoryRepository extends Repository implements FaqsCategoryRepositoryInterface
{

    /**
     *
     * @param FaqsCategory $model
     */
    public function __construct(FaqsCategory $model)
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
