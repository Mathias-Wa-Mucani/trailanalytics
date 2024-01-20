<?php

namespace App\Repositories;

use App\Models\AppraisalNationalDeskReview;
use App\Models\AppraisalNationalFieldReview;
use App\Models\AppraisalNationalFieldReviewDetail;
use App\Models\User;
use App\Models\Views\ViewPwdGroupApplication;
use Illuminate\Support\Collection;

class AppraisalFieldReviewDetailRepository extends Repository implements AppraisalFieldReviewDetailRepositoryInterface
{
    protected $pwdRepository;
    protected $fieldReviewRepository;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(
        AppraisalNationalFieldReviewDetail $model,
        PwdRegistrationRepositoryInterface $pwdRepository
        // AppraisalFieldReviewDetailRepositoryInterface $fieldReviewRepository
    ) {
        parent::__construct($model);
        $this->pwdRepository = $pwdRepository;
        // $this->fieldReviewRepository = $fieldReviewRepository;
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

        // check if verifying member is part of application group
        if (!in_array(@$data['member_verifying_id'], $membersIds)) {
            return "Member Verifying does not belong to Application Group";
        }


        $fieldReviewDetail = $this->getByFieldReview(@$data['appraisal_national_b_fieldreview_id']);
        $fieldReviewDetail = $fieldReviewDetail ? $this->update($data, $fieldReviewDetail->id) : $this->create($data);

        /**
         * save field decision
         */
        $fieldReview->fielddecision_id = $data['fielddecision_id'];
        $fieldReview->fielddecision_comments = $data['fielddecision_comments'];
        $fieldReview->fielddecision_id = $data['fielddecision_id'];
        $fieldReview->fielddecision_financial_year_id = $data['fielddecision_financial_year_id'];
        $fieldReview->fielddecision_quarter_id = $data['fielddecision_quarter_id'];
        $fieldReview->save();
        // return "Now we are here";
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
