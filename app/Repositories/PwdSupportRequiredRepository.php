<?php

namespace App\Repositories;

use App\Models\PwdService;
use App\Models\PwdSupportRequired;
use Illuminate\Support\Collection;

class PwdSupportRequiredRepository  extends Repository implements PwdSupportRequiredRepositoryInterface
{

    /**
     * PwdSupportRequired constructor.
     *
     * @param PwdService $model
     */
    public function __construct(PwdService $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
