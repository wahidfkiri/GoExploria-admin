<?php 

namespace Vendor\MailMarketing\Controllers;

use App\Http\Controllers\Controller;

class MailMarketingController extends Controller
{
    public function index()
    {
        return view('mail-marketing::components.index');
    }
}