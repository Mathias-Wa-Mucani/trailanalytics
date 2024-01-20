<?php

namespace App\Repositories;

use App\Classes\CacheKeys;
use App\Models\PublicationCategory;
use App\Models\User;
use Illuminate\Support\Collection;

class PublicationCategoryRepository extends Repository implements PublicationCategoryRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param PublicationCategory $model
     */
    public function __construct(PublicationCategory $model)
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
