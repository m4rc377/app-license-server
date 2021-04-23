<?php
/* 
	Author: Irfa Ardiansyah <irfa.backend@protonmail.com>
*/
namespace Irfa\AppLicenseServer\Func;

use Irfa\AppLicenseServer\Core\SerialManager;

class License extends SerialManager
{
    private $serial;
    public function register($params,$expired)
    {
        return $this->createLicense($params,$expired);
    }

    public function serial($serial)
    {
        $this->serial = $serial;
        return $this;
    }

    public function disable()
    {
         return $this->disableSN($this->serial);
    }

    public function enable()
    {
        return $this->enableSN($this->serial);
    }

    public function renew($date)
    {
        return $this->renewSN($this->serial,$date);
    }

    public function check()
    {
        if($this->exists($this->serial))
        {
            if($this->expired($this->serial))
            {
                return (object)['active' => false,'message' => "Serial Number is Expired"];
            }
            
            if($this->disabled($this->serial))
            {
                return (object)['active' => false,'message' => "Serial Number is Disabled"];
            }
             return (object)['active' => true, 'expired' => ['status' => $this->expired($this->serial), 'date' => $this->expiredDate($this->serial)], 'message' => "Serial Number is valid till ". $this->expiredDate($this->serial)];
        } else{
            return (object)['active' => false,'message' => "Serial Number invalid"];
        }
    }
}
