<?php

namespace App\Repositories;

use App\Classes\GeneralHelper;
use App\Classes\ModelHelper;
use App\Http\Controllers\FileUploadController;
use App\Models\Disability;
use App\Models\PwdRegistration;
use App\Models\Village;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;

class PwdRegistrationRepository extends Repository implements PwdRegistrationRepositoryInterface
{
    protected $data = array();
    protected $user;
    protected $pwdSupportRequiredRepository;
    protected $pwdServicesReceivedRepository;
    protected $fileService;
    private $pwd;
    public $relations = [];
    /**
     * PwdRegistrationRepository constructor.
     *
     * @param PwdRegistration $model
     */
    public function __construct(
        PwdRegistration $model,
        PwdSupportRequiredRepositoryInterface $pwdSupportRequiredRepository,
        PwdServicesReceivedRepositoryInterface $pwdServicesReceivedRepository,
        FileUploadController $fileService
    ) {
        parent::__construct($model);
        $this->pwdServicesReceivedRepository = $pwdServicesReceivedRepository;
        $this->pwdSupportRequiredRepository = $pwdSupportRequiredRepository;
        $this->fileService = $fileService;
        $this->relations = ['district', 'county', 'subcounty', 'educational_level', 'educational_certificate', 'disability', 'disability_severity', 'disability_cause', 'services_received', 'support_required'];
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    public function SavePwd($data, $extra = null)
    {
        // return $extra->allFiles();
        $pwd_data = array(
            'device_pwd_number' => @$data['device_pwd_number'],
            'nin' => @$data['nin'],
            'caretaking' => @$data['caretaking'],
            'caretaker_id' => @$data['caretaker_id'],
            'surname' => @$data['surname'],
            'given_name' => @$data['given_name'],
            'other_name' => @$data['other_name'],
            'dob' => @$data['dob'],
            'sex' => @$data['sex'],
            'contact' => json_encode(array(
                'pri_telephone' => @$data['pri_telephone'],
                'sec_telephone' => @$data['sec_telephone'],
                'email' => @$data['email'],
                'box_number' => @$data['box_number'],
            )),

            'village_id' => @$data['village_id'],
            'address' => @$data['address'],
            'limitation' => @$data['limitation'],

            'educ_level_id' => @$data['educ_level_id'],
            'educ_certificate_id' => @$data['educ_certificate_id'],
            'educ_comment' => @$data['educ_comment'],


            'disability_type_id' => @$data['is_caretaker'] ? null : @$data['disability_type_id'],
            'disability_cause_id' => @$data['is_caretaker'] ? null : @$data['disability_cause_id'],
            'disability_severity_id' => @$data['is_caretaker'] ? null : @$data['disability_severity_id'],
            'other_disability' => @$data['is_caretaker'] ? null : @$data['other_disability'],
            'house_hold_size' => @$data['house_hold_size'],
            'slums' => @$data['slums'],
            'hiv' => @$data['hiv'],
            'single_parent' => @$data['single_parent']
        );


        /**
         * check if device pwd number exists
         */
        // if ($this->getByDeviceNumber($data['device_pwd_number'])) {
        //     return "PWD_EXISTS";
        // }

        $data['services_received'] = @$data['services_received'] ?? [];
        $data['support_required'] = @$data['support_required'] ?? [];
        $data['disability_guiding'] = @$data['disability_guiding'] ?? [];

        $caretakerIndex = GeneralHelper::SearchMDArrayByValue(GeneralHelper::CareakingParts(), 'slug', IS_CARETAKER);

        $caretakerIndex = GeneralHelper::CareakingParts()[$caretakerIndex]['index'];

        /**
         * if pwd is not caretaker
         */
        if ((int)@$data['caretaking'] !== 2) {
            if (!is_array($result = $this->ValidateDisabilityGuiding(@$data['disability_type_id'], $data['disability_guiding']))) {
                return $result;
            }

            if (@$data['services_received']) {
                if (!is_array($result = $this->ValidateServicesReceived(@$data['services_received']))) {
                    return $result;
                }
            } else {
                $data['services_received'] = [];
            }

            if (@$data['support_required']) {
                if (!is_array($result = $this->ValidateSupportRequired(@$data['support_required']))) {
                    return $result;
                }
            }
        }

        if (!is_array($result = $this->ValidateUploadDocuments($extra))) {
            return $result;
        }

        if (@$data['pwd_number'] && !$this->getByPwdNumber(@$data['pwd_number'])) {
            return "PWD_NOT_FOUND";
        }

        if (@$data['village_id']) {
            if (!Village::find(@$data['village_id'])) {
                return "VILLAGE_NOT_FOUND";
            }
        }


        $pwd = $this->getByPwdNumber(@$data['pwd_number']) ?? $this->getByDeviceNumber(@$data['device_pwd_number']);
        $this->pwd = $pwd ? $this->update($pwd_data, $pwd->id) : $this->create($pwd_data);


        /**
         * upload documents
         */
        $extra['pwd_number'] = $this->pwd->pwd_number;
        $this->UploadDisabilityPhotographs($extra);
        // return $pwd;

        if (@$this->pwd->IsCaretaker()) {
            return $this->pwd;
        }


        $data['pwd_number'] = $this->pwd->pwd_number;

        /**
         * save pwd description
         */
        $disability_description_data = array(
            'pwd_number' => $this->pwd->pwd_number,
            'disability_guiding' => @$data['disability_guiding']
        );
        $this->SavePwdDisabilityDescription($disability_description_data);


        /**
         * save pwd services received
         */
        $services_received_data = array(
            'pwd_number' => $this->pwd->pwd_number,
            'services_received' => @$data['services_received']
        );
        $this->SavePwdServicesReceived(@$services_received_data);


        /**
         * save pwd support required
         */
        $support_required_data = array(
            'pwd_number' => $this->pwd->pwd_number,
            'support_required' => @$data['support_required']
        );

        $this->SavePwdSupportRequired($support_required_data);

        /**
         * save disability causes
         */
        $disability_causes_data = array(
            'pwd_number' => $this->pwd->pwd_number,
            'disability_causes' => @$data['disability_causes']
        );

        $this->SaveDisabilityCauses($disability_causes_data);

        return $this->pwd;
    }

    private function ValidateDisabilityGuiding($disability_type_id, $disabiltyGuideRequestIds)
    {
        $disability = Disability::with('guide')->find($disability_type_id);
        // if(){

        // }
        $disabilityGuideIds = $disability->guide()->pluck('id')->toArray();
        foreach ($disabiltyGuideRequestIds as $guideRequestId) {
            if (!in_array($guideRequestId, $disabilityGuideIds)) {
                return "Disability guiding does not match Disability type";
            }
        }
        return $disabiltyGuideRequestIds;
    }

    private function ValidateServicesReceived($servicesRequestIds)
    {
        $services = $this->pwdServicesReceivedRepository->all()->pluck('id')->toArray();
        foreach (@$servicesRequestIds as $serviceRequestId) {
            if (!in_array($serviceRequestId, $services)) {
                return "SERVICE_NOT_FOUND";
            }
        }
        return $servicesRequestIds;
    }

    private function ValidateSupportRequired($supportRequestIds)
    {
        $support = $this->pwdSupportRequiredRepository->all()->pluck('id')->toArray();
        foreach (@$supportRequestIds as $supportRequestId) {
            if (!in_array($supportRequestId, $support)) {
                return "SUPPORT_METHOD_NOT_FOUND";
            }
        }
        return $supportRequestIds;
    }

    private function ValidateUploadDocuments($data)
    {
        $files = $data->allFiles();
        $filesKeys = array_keys($files);
        /**
         * Check if photograhs are valid
         */
        if (count($filesKeys)) {
            if (!GeneralHelper::array_contains($filesKeys, GeneralHelper::PwdDisabilityPhotographTypes())) {
                return "INVALID_DOCUMENTS";
            }
        }
        return $filesKeys;
    }

    public function updatePwd($data)
    {
        if (!@$data['pwd_number']) {
            return "REQUEST_MISSING_PWD_NUMBER";
        }

        return $this->update_by_field($data, 'pwd_number', @$data['pwd_number']);
    }

    public function getByPwdNumber($pwd_number)
    {
        return $this->with($this->relations)->wherePwdNumber(@$pwd_number)->first();
    }

    public function getByDeviceNumber($device_number)
    {
        return $this->with($this->relations)->whereDevicePwdNumber(@$device_number)->first();
    }

    /**
     * Save pwd identification details
     */
    public function SavePwdIdentification($data)
    {
        if (!in_array($data['sex'], ModelHelper::getSexs())) {
            return "INVALID_SEX";
        }

        if (@$data['pwd_number']) {
            return $this->updatePwd($data);
        }

        return $this->create($data);
    }

    /**
     * Save pwd contact details
     * Contact data is converted to json
     */
    public function SavePwdContact($data)
    {
        // check for pwd number
        if (!@$data['pwd_number']) {
            return "PWD_NUMBER_NOT_FOUND";
        }
        $_contact = array(
            'contact' => $data
        );
        unset($_contact['contact']['pwd_number']);
        return $this->update_by_field($_contact, 'pwd_number', @$data['pwd_number']);
    }

    /**
     * Save pwd disability details
     */
    public function SavePwdDisabilityDescription($data)
    {
        $disabiltyGuideRequestIds = @$data['disability_guiding'] ?? [];
        $pwdGuideRecordIds = $this->pwd->disability_guide()->pluck('disability_guiding_id')->toArray();

        foreach ($disabiltyGuideRequestIds as $guideRequestId) {
            if (!in_array($guideRequestId, $pwdGuideRecordIds)) {
                $this->pwd->disability_registration_guiding()
                    ->create(
                        [
                            'disability_guiding_id' => $guideRequestId,
                            'created_by' => @auth()->user()->id,
                            'updated_by' => @auth()->user()->id
                        ]
                    );
            }
        }

        $this->pwd->disability_guide()->whereNotIn('disability_guiding_id', $disabiltyGuideRequestIds)->delete();

        /**
         * Delete disability guide for pwd if has other disability
         */
        if ($this->pwd->disability->isOther()) {
            $this->pwd->disability_guide()->delete();
        }

        // unset($data['disability_guiding']);
        // return $this->updatePwd($data);
    }

    /**
     * Save pwd services received
     */
    public function SavePwdServicesReceived($data)
    {
        $servicesRequestIds = @$data['services_received'] ?? [];

        $pwdServicesRecordIds = $this->pwd->services_received()->pluck('pwd_service_received_id')->toArray();

        foreach ($servicesRequestIds as $serviceRequestId) {
            if (!in_array($serviceRequestId, $pwdServicesRecordIds)) {
                $this->pwd->services_received()
                    ->create([
                        'pwd_service_received_id' => $serviceRequestId,
                        'created_by' => @auth()->user()->id,
                        'updated_by' => @auth()->user()->id
                    ]);
            }
        }
        $this->pwd->services_received()->whereNotIn('pwd_service_received_id', $servicesRequestIds)->delete();
        return $this->pwd;
    }


    /**
     * Save pwd support required
     */
    public function SavePwdSupportRequired($data)
    {
        $supportRequestIds = $data['support_required'];
        $pwdSupportRecordsIds = $this->pwd->support_required()->pluck('pwd_support_required_id')->toArray();

        foreach ($supportRequestIds as $supportRequestId) {
            if (!in_array($supportRequestId, $pwdSupportRecordsIds)) {
                $this->pwd->support_required()
                    ->create([
                        'pwd_support_required_id' => $supportRequestId,
                        'created_by' => @auth()->user()->id,
                        'updated_by' => @auth()->user()->id
                    ]);
            }
        }

        $this->pwd->support_required()->whereNotIn('pwd_support_required_id', $supportRequestIds)->delete();
        return $this->pwd;
    }

    public function UploadDisabilityPhotographs($data)
    {
        $files = $data->allFiles();
        $documents = [];

        foreach ($files as $key => $file) {
            $documents['documents'][$key] = $file;
            $documents['documents'][$key];
        }

        if (count($documents)) {
            $this->fileService->uploadFiles($documents, $files, "PwdRegistration", $this->pwd->id, 'disability');
        }
        return $this->pwd;
    }


    /**
     * Save pwd services received
     */
    public function SaveDisabilityCauses($data)
    {
        $causesRequestIds = @$data['disability_causes'] ?? [];

        $currentRecordIds = $this->pwd->disability_causes()->pluck('stp_disability_cause_id')->toArray();

        foreach ($causesRequestIds as $causeRequestId) {
            if (!in_array($causeRequestId, $currentRecordIds)) {
                $this->pwd->disability_causes()
                    ->create([
                        'stp_disability_cause_id' => $causeRequestId,
                        'created_by' => @auth()->user()->id,
                        'updated_by' => @auth()->user()->id
                    ]);
            }
        }
        $this->pwd->disability_causes()->whereNotIn('stp_disability_cause_id', $causesRequestIds)->delete();
        return $this->pwd;
    }

    public function getPwds()
    {
        return $this->model->PwdAuthUserList()->sortByDesc('created_at');
        // return $this->model->PwdAuthUserList()->sortByDesc('created_at');
    }
}
