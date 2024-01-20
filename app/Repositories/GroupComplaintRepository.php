<?php

namespace App\Repositories;

use App\Classes\CacheKeys;
use App\Models\PwdGroupComplaint;
use Illuminate\Support\Collection;

class GroupComplaintRepository extends Repository implements GroupComplaintRepositoryInterface
{
    public function __construct(PwdGroupComplaint $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        // return $this->model->remember(CacheKeys::REMEMBER_TIME)->cacheTags(class_basename($this->model))->get();
        return $this->model->AuthUserList()->get();
    }

    /**
     * Adds new pwd complaint
     */
    public function addComplaint($data)
    {
        return $this->create($data);
    }
}
