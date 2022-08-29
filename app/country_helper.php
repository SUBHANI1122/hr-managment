<?php

if (!function_exists('getCountryZone')) {
    /**
     * return status array
     */
    function getCountryZone()
    {
        return [
            'Pakistan' => 'Asia/Karachi',
            'India' => 'Asia/Kolkata',
        ];
    }
}

if (!function_exists('getCountryName')) {
    /**
     * return status array
     */
    function getCountryName($countryId)
    {
        $country = \App\Country::select('name')->where('id', $countryId)->first();
        return $country;
    }
}
