<?php

namespace Adnduweb\Ci4Core\Traits;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;

trait LibphoneTraits
{
    public function phoneInternational($numero, $codeAlpha = false)
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $telephone = $phoneUtil->parse($numero, strtoupper($codeAlpha));

            if (!$phoneUtil->isValidNumber($telephone)) {
                return array('status' => 422, 'message' => lang('Core.number_bad_format'));
            }
            $formattedNumbertelephone = $phoneUtil->format($telephone, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
            return array('status' => 200, 'message' => $formattedNumbertelephone);
        } catch (\libphonenumber\NumberParseException $e) {
            return array('status' => 422, 'message' => $e->getMessage());
        }
    }
}