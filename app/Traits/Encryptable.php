<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        if (in_array($key, $this->encryptable)) {
            try {
                $value = Crypt::decrypt($value);
            } catch (\Throwable $th) {
                return $value;
            }
        }
        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            try {
                //code...
                $value = Crypt::encrypt($value);
            } catch (\Throwable $th) {
                //throw $th;
                $value = $value;
            }
        }

        return parent::setAttribute($key, $value);
    }
}
