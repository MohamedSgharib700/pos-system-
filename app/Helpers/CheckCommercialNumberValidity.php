<?php

namespace App\Helpers;

use App\Services\Wathq\Wathq;
use Illuminate\Validation\ValidationException;


class CheckCommercialNumberValidity
{



    /**
     * check validity of commercial registeration number of new registered manager.
     *
     * @param  string  $commercial_registration_number
     * @param  string  $identity_number
     * @param  object  $commercial_registration_info
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check($commercial_registration_number, $identity_number, $commercial_registration_info)
    {

       // check that commercial registeration number of manager is equal commercial registeration number from wathq
       if( ! $this->checkEqualityOfCommercialRegistrationNumber($commercial_registration_number, $commercial_registration_info)) {
            throw ValidationException::withMessages([
                'commercial_registration_number' => trans('general.invalid_data')
            ]);
       }

       // check that identity of manager exists on parties of wathq response
       if( ! $this->checkIdentityNumberIncludedInParties($identity_number, collect($commercial_registration_info['parties']))) {
            throw ValidationException::withMessages([
                'commercial_registration_number' => trans('general.invalid_data')
            ]);
       }

       // check that commercial registeration is active
       if( ! $this->isActiveCommercialRegistration($commercial_registration_info['status'])) {
            throw ValidationException::withMessages([
                'commercial_registration_number' => trans('general.commercial_registeration_unactive')
            ]);
       }

       return true;
    }

    /**
     * check equality of commercial registeration number  of manager and response back from wathq service.
     *
     * @param  string  $commercial_registration_number
     * @param  object  $commercial_registration_info
     * @return bool
     */
    protected function checkEqualityOfCommercialRegistrationNumber($commercial_registration_number, $commercial_registration_info)
    {
      return $commercial_registration_info['crNumber'] == $commercial_registration_number;
    }

     /**
     * check that identity number  of manager included in response back from wathq service.
     *
     * @param  string  $identity_number
     * @param  Illuminate\Support\Collection  $parties
     * @return bool
     */
    protected function checkIdentityNumberIncludedInParties($identity_number, $parties)
    {
        return $parties->contains('identity.id',$identity_number);
    }

     /**
     * check that commercial registeration number  of manager is active from response back from wathq service.
     *
     * @param  array  $status
     * @return bool
     */
    protected function isActiveCommercialRegistration($status)
    {
        return $status['id'] == 'active';
    }
}
