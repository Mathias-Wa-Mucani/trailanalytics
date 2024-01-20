<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface PwdRegistrationRepositoryInterface
{
    public function all(): Collection;
    public function SavePwdIdentification($data);
    public function SavePwdContact($data);
    // public function SavePwdLocation($data);
    public function SavePwdDisabilityDescription($data);
    public function SavePwdServicesReceived($data);
    public function SavePwdSupportRequired($data);
    public function getByPwdNumber($pwd_number);
    public function getByDeviceNumber($device_number);
    public function getPwds();

    public function updatePwd($data);
    public function UploadDisabilityPhotographs($data);
    public function SavePwd($data, $extra = null);
}
