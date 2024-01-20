<?php

namespace App\Repositories;

use App\Classes\GeneralHelper;
use App\Http\Controllers\FileUploadController;
use App\Models\GroupRole;
use App\Models\PwdGroupRegistration;
use App\Models\PwdRegistration;
use App\Models\User;
use Illuminate\Support\Collection;

class PwdGroupRepository extends Repository implements PwdGroupRepositoryInterface
{
    private $group;
    private $extra;
    private $request_data;
    protected $fileService;

    /**
     * PwdGroupRepository constructor.
     *
     * @param PwdGroupRegistration $model
     */
    public function __construct(
        PwdGroupRegistration $model,
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

    public function SavePwdGroup(array $data, $extra = null)
    {
        $this->request_data = $data;
        $this->extra = $extra;
        $group_data = array(
            'device_grp_number' => @$data['device_grp_number'],
            'grp_name' => @$data['grp_name'],
            'date_established' => @$data['date_established'],
            'is_home' => @$data['is_home'],
            'village_id' => @$data['village_id'],
            'address' => @$data['address'],
        );

        // if (!is_array($result = $this->Va($data['disability_type_id'], $data['disability_guiding']))) {
        //     return $result;
        // }

        /**
         * check if group exists
         */
        $group = $this->getByGroupNumber(@$data['grp_number']) ?? $this->getByDeviceNumber(@$data['device_grp_number']);
        $this->group = $group ? $this->update($group_data, $group->id) : $this->create($group_data);

        /**
         * Validate existance of members and group roles
         */
        if (!is_array($members = $this->ValidateGroupMembers(@$data['members']))) {
            return $members;
        }

        // Validate documents
        if (!is_array($result = $this->ValidateUploadDocuments(@$extra))) {
            return $result;
        }

        // Add members
        $this->addMembers(@$members);

        // add group documents 
        $this->addGroupDocuments();

        return $this->group;
    }

    public function getByGroupNumber($pwd_number)
    {
        return $this->model->whereGrpNumber(@$pwd_number)->first();
    }

    public function getByDeviceNumber($device_number)
    {
        return $this->model->whereDeviceGrpNumber(@$device_number)->first();
    }

    private function ValidateGroupMembers($members)
    {
        $membersArray = array();
        $i = 0;
        foreach ($members as $member) {
            //Check if member exists
            if (!$foundMember = PwdRegistration::wherePwdNumber(@$member['pwd_number'])->first()) return "PWD_NOT_FOUND";

            //Check if group role exists
            if (!GroupRole::find(@$member['role_id'])) return "ROLE_NOT_FOUND";

            $membersArray[$i]['role_id'] = $member['role_id'];
            $membersArray[$i]['member_id'] = $foundMember['id'];
            $i++;
        }
        // return $disabiltyGuideRequestIds;

        return $membersArray;
    }


    private function ValidateUploadDocuments($data)
    {
        $files = $data->allFiles();
        $filesKeys = array_keys($files);
        /**
         * Check if documents are valid
         */
        if (!GeneralHelper::array_contains($filesKeys, GeneralHelper::PwdGroupDocumentTypes())) {
            return "INVALID_DOCUMENTS";
        }

        return $filesKeys;
    }

    /**
     * Adds members to group
     */
    private function addMembers($members)
    {
        // var_dump($members);
        // $existingIds = $this->group->members()->pluck('id');
        $existingMemberIds = $this->group->members()->pluck('pwd_registration_id')->toArray();
        $memberIds = array();
        foreach ($members as $member) {
            if (!in_array($member['member_id'], $existingMemberIds)) {
                $this->group->members()->create(
                    [
                        'pwd_registration_id' => $member['member_id'],
                        'stp_group_role_id' => $member['role_id'],
                    ]
                );
            }
            array_push($memberIds, $member['member_id']);
        }
        $this->group->members()->whereNotIn('pwd_registration_id', $memberIds)->delete();
    }

    /**
     * Uploads group documents
     */
    private function addGroupDocuments()
    {
        $files = $this->extra->allFiles();
        $documents = array();
        foreach ($files as $key => $file) {
            $documents['documents'][$key] = $file;
            $documents['documents'][$key];
        }

        if (count($documents)) {
            $this->fileService->uploadFiles($documents, $files, class_basename($this->group), $this->group->id);
        }

        // $fileService

        return $this->group;
    }

    public function getGroups()
    {
        return $this->model->AuthUserList()->sortByDesc('created_at');
    }
}
