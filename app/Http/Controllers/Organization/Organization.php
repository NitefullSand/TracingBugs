<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Organizations;
use Illuminate\Http\Request;

class Organization extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the organization's infomation.
     * @param  interge $id organization's id.
     * @return 
     */
    public function showOrganization($id)
    {
    	$organization = Organizations::whereId($id)->firstOrFail();
        return view('organization\organization')->with('organization', $organization);
    }
}

