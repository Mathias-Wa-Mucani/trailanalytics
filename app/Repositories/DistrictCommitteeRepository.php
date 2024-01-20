<?php

namespace App\Repositories;

use App\Models\DistrictCommittee;
use App\Models\User;
use Illuminate\Support\Collection;

class DistrictCommitteeRepository extends Repository implements DistrictCommitteeRepositoryInterface
{

    /**
     * DistrictCommitteeRepository constructor.
     *
     * @param DistrictCommittee $model
     */
    public function __construct(DistrictCommittee $model)
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

    public function getByDistrict($district_id)
    {
        return $this->model->whereDistrictId($district_id)->get();
    }

    public function AddNewMember($data)
    {
        return $this->create($data);
    }
}
