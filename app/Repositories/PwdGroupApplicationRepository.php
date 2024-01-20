<?php

namespace App\Repositories;

use App\Classes\GeneralHelper;
use App\Http\Controllers\FileUploadController;
use App\Models\BudgetItem;
use App\Models\GroupRole;
use App\Models\PwdGroupApplication;
use App\Models\PwdRegistration;
use App\Models\UnitMeasure;
use App\Models\User;
use Illuminate\Support\Collection;

class PwdGroupApplicationRepository extends Repository implements PwdGroupApplicationRepositoryInterface
{
    private $application;
    private $extra;
    private $request_data;
    protected $fileService;

    /**
     * PwdGroupRepository constructor.
     *
     * @param PwdGroupApplication $model
     */
    public function __construct(
        PwdGroupApplication $model,
        FileUploadController $fileService
    ) {
        parent::__construct($model);
        $this->fileService = $fileService;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    public function SavePwdGroupApplication(array $data, $extra = null)
    {
        $this->request_data = $data;
        $this->extra = $extra;
        /**
         * check if application exists
         */
        $application = $this->getByApplicationNumber(@$data['app_number']) ?? $this->getByDeviceNumber(@$data['device_app_number']);
        $this->application = $application ? $this->update($data, $application->id) : $this->create($data);

        /**
         * Validate existance of members and application roles
         */
        // if (!is_array($result = $this->ValidateGroupMembers(@$data['members']))) {
        //     return $result;
        // }

        //Validate documents
        if (!is_array($result = $this->ValidateUploadDocuments(@$extra))) {
            return $result;
        }

        //Validate budget items
        if (!is_array($result = $this->validateBudgetItems())) {
            return $result;
        }


        // Add members
        // $this->addMembers(@$data['members']);

        // add application documents 
        $this->addGroupDocuments();
        if (count(@$this->request_data['budget'])) $this->addBudgetItems();
        if (count(@$this->request_data['sales_projection']))  $this->addSalesProjection();


        return $this->application;
    }

    public function getByApplicationNumber($application_number)
    {
        return $this->model->whereAppNumber(@$application_number)->first();
    }

    public function getByDeviceNumber($device_number)
    {
        return $this->model->whereDeviceAppNumber(@$device_number)->first();
    }

    private function validateBudgetItems()
    {
        foreach ($this->request_data['budget'] as $item) {
            //Check if member exists
            if (!UnitMeasure::find(@$item['stp_unit_measure_id'])) return "UNIT_MEASURE_NOT_FOUND";
            // return $disabiltyGuideRequestIds;
        }

        return $this->request_data;
    }


    private function ValidateUploadDocuments($data)
    {
        $files = $data->allFiles();
        $filesKeys = array_keys($files);
        /**
         * Check if documents are valid
         */
        if (!GeneralHelper::array_contains($filesKeys, GeneralHelper::PwdGroupApplicationDocumentTypes())) {
            return "INVALID_DOCUMENTS";
        }

        return $filesKeys;
    }

    /**
     * Adds to budget
     */
    private function addBudgetItems()
    {
        // $existingIds = $this->application->members()->pluck('id');
        $existingBudgetItems = $this->application->budget_items()->pluck('item_name')->toArray();
        $budgetItems = array();
        foreach ($this->request_data['budget'] as $item) {
            if (!in_array($item['item_name'], $existingBudgetItems)) {
                $this->application->budget_items()->create(
                    [
                        'item_name' => @$item['item_name'],
                        'stp_unit_measure_id' => @$item['stp_unit_measure_id'],
                        'quantity' => @$item['quantity'],
                        'unit_price' => @$item['unit_price'],
                        'comment' => @$item['comment'],
                    ]
                );
            } else {
                $currentItem = $this->application->budget_items()->where('item_name', $item['item_name'])->first();
                $currentItem->stp_unit_measure_id = @$item['stp_unit_measure_id'];
                $currentItem->quantity = @$item['quantity'];
                $currentItem->unit_price = @$item['unit_price'];
                $currentItem->comment = @$item['comment'];
                $currentItem->save();
            }
            array_push($budgetItems, $item['item_name']);
        }
        $this->application->budget_items()->whereNotIn('item_name', $budgetItems)->delete();
    }

    /**
     * Adds sales projection 
     */
    private function addSalesProjection()
    {
        // $existingIds = $this->application->members()->pluck('id');
        $existingItems = $this->application->sales_projections()->pluck('product_name')->toArray();
        $items = array();
        foreach ($this->request_data['sales_projection'] as $item) {
            if (!in_array($item['product_name'], $existingItems)) {
                $this->application->sales_projections()->create(
                    [
                        'product_name' => @$item['product_name'],
                        'quantity' => @$item['quantity'],
                        'unit_price' => @$item['unit_price'],
                    ]
                );
            } else {
                $currentItem = $this->application->sales_projections()->where('product_name', $item['product_name'])->first();
                $currentItem->product_name = @$item['product_name'];
                $currentItem->quantity = @$item['quantity'];
                $currentItem->unit_price = @$item['unit_price'];
                $currentItem->save();
            }
            array_push($items, $item['product_name']);
        }
        $this->application->sales_projections()->whereNotIn('product_name', $items)->delete();
    }

    /**
     * Uploads application documents
     */
    private function addGroupDocuments()
    {

        $files = $this->extra->allFiles();
        $documents = array();
        $filesKeys = array_keys($files);

        foreach ($files as $key => $file) {
            $documents['documents'][$key] = $file;
            $documents['documents'][$key];
        }

        if (count($documents)) {
            $this->fileService->uploadFiles($documents, $files, class_basename($this->application), $this->application->id);
        }

        // $fileService

        return $this->application;
    }

    public function getApplications()
    {
        return $this->model->AuthUserList()->sortByDesc('created_at');
    }
}
