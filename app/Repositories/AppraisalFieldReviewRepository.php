<?php

namespace App\Repositories;

use App\Models\AppraisalNationalDeskReview;
use App\Models\AppraisalNationalFieldReview;
use App\Models\User;
use App\Models\Views\ViewPwdGroupApplication;
use Illuminate\Support\Collection;

class AppraisalFieldReviewRepository extends Repository implements AppraisalFieldReviewRepositoryInterface
{
    protected $pwdRepository;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(
        AppraisalNationalFieldReview $model,
        PwdRegistrationRepositoryInterface $pwdRepository
    ) {
        parent::__construct($model);
        $this->pwdRepository = $pwdRepository;
    }

    /**
     * @return Collection
     */
    public function addFieldReview($data)
    {
        $fieldReview = AppraisalNationalFieldReview::find($data['appraisal_national_b_fieldreview_id']);
        if (!$fieldReview) {
            return "Field review not found";
        }

        $application_view = ViewPwdGroupApplication::with('application')->find($fieldReview->application_id);
        // var_dump($application_view);

        // get application group members
        $membersIds = $application_view->application->group->members->pluck('pwd_registration_id')->toArray();
       
        var_dump($membersIds);
        // check if verifying member is part of application group
        if (!in_array(@$data['member_verifying_id'], $membersIds)) {
            return "Member Verifying does not belong to Application Group";
        }

        
        $fieldReview = $this->getByFieldReview(@$data['appraisal_national_b_fieldreview_id']);
        $fieldReview = $fieldReview ? $this->update($data, $fieldReview->id) : $this->create($data);
        
        return "Now we are here";
        return $fieldReview;
    }

    public function getByDeskReview($deskReview_id)
    {
        return $this->model->where('appraisal_national_deskreview_id', $deskReview_id)->first();
    }

    public function getByFieldReview($fieldReview_id)
    {
        return $this->model->where('appraisal_national_b_fieldreview_id', $fieldReview_id)->first();
    }
}
