<?php

namespace App\Repositories;

use App\Classes\CacheKeys;
use App\Classes\GeneralHelper;
use App\Models\PwdComplaint;
use App\Models\PwdComplaintGrievance;
use App\Http\Controllers\FileUploadController;
use App\Models\PwdComplaintGrievanceClosure;
use App\Models\PwdGroupRegistration;
use App\Models\PwdRegistration;
use Illuminate\Support\Collection;

class PwdComplaintRepository extends Repository implements PwdComplaintRepositoryInterface
{
    protected $fileService;
    private $complaint;
    private $complaint_model;
    public function __construct(
        PwdComplaintGrievance $model,
        FileUploadController $fileService
    ) {
        parent::__construct($model);
        $this->fileService = $fileService;
    }

    /**
     * @return Collection
     */
    public function all($reporter_type = 1): Collection
    {
        // return $this->model->remember(CacheKeys::REMEMBER_TIME)->cacheTags(class_basename($this->model))->get();
        return $this->model->AuthUserList($reporter_type)->get();
    }

    /**
     * Adds new pwd complaint
     */
    public function addComplaint($data, $extra = null)
    {
        unset($data['issue_doc']);
        unset($data['issue_photo']);
        if (in_array(@$data['complainer_id'], [1, 2])) {
            if (@$data['complainer_id'] == 1 && !PwdRegistration::find(@$data['complainer_id'])) return "PWD_NOT_FOUND";

            if (@$data['complainer_id'] == 2 && !PwdGroupRegistration::find(@$data['complainer_id'])) return "PWD_GROUP_NOT_FOUND";
        } else {
            return "RECORD_NOT_FOUND";
        }

        if (!is_array($result = $this->ValidateDocuments($extra))) {
            return $result;
        }

        $this->complaint = $this->save_data($data);
        $this->complaint_model = "PwdComplaintGrievance";

        $this->UploadDocuments($extra, 'open');

        return $this->complaint;
    }

    /**
     * Adds new pwd complaint
     */
    public function closeComplaint($data, $extra = null)
    {
        unset($data['response_doc']);
        unset($data['response_photo']);

        if (!is_array($result = $this->ValidateDocuments($extra))) {
            return $result;
        }

        // $complaint = $this->model->find($data['pwd_cg_record_id']);
        $closure = PwdComplaintGrievanceClosure::where('pwd_cg_record_id', @$data['pwd_cg_record_id'])->first();

        $closure = $closure ? $closure : new PwdComplaintGrievanceClosure();
        $closure->pwd_cg_record_id = @$data['pwd_cg_record_id'];
        $closure->stp_cg_category_id = @$data['stp_cg_category_id'];
        $closure->response_description = @$data['response_description'];
        $closure->closed_financial_year_id = @$data['closed_financial_year_id'];
        $closure->closed_quarter_id = @$data['closed_quarter_id'];
        $closure->response_date = now();
        $closure->closed_by = auth()->id();
        $closure->closed_by = auth()->id();
        $closure->created_by = auth()->id();
        $closure->save();
        $this->complaint = $closure;
        $this->complaint_model = "PwdComplaintGrievanceClosure";

        $this->UploadDocuments($extra, 'closure');

        return $this->complaint;
    }

    private function ValidateDocuments($data)
    {
        $files = $data->allFiles();
        $filesKeys = array_keys($files);
        /**
         * Check if photograhs are valid
         */
        if (count($filesKeys)) {
            if (!GeneralHelper::array_contains($filesKeys, GeneralHelper::ComplaintDocumentTypes())) {
                return "INVALID_DOCUMENTS";
            }
        }
        return $filesKeys;
    }

    public function UploadDocuments($data, $section = null)
    {
        $files = $data->allFiles();
        $documents = array();

        foreach ($files as $key => $file) {
            $documents['documents'][$key] = $file;
            $documents['documents'][$key];
        }

        if (count($documents)) {
            $this->fileService->uploadFiles($documents, $files, $this->complaint_model, $this->complaint->id, $section);
        }
        return $this->complaint;
    }
}
