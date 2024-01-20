<?php

namespace App\Repositories;

use App\Models\PwdService;
use App\Models\PwdServiceReceived;
use Illuminate\Support\Collection;

class PwdServicesReceivedRepository  extends Repository implements PwdServicesReceivedRepositoryInterface
{

    /**
     * PwdServiceReceived constructor.
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
