<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Customertype;
use App\Models\Smtpserver;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Jobs\InvoiceSenderByEmail;

class ApiController extends Controller
{
    public function sendInvoices(Request $request)
    {
        $domain = parse_url(config('app.url'), PHP_URL_HOST);
        $requested_domain = $request->getHost();
        $invoiceId  = $request->invoice_id;
        $templateId = $request->template_id;
        if ($domain == $requested_domain) {
            // sending the invoice to multiple emails
            if ($invoiceId && $templateId) {
                foreach ($request->emails as $key => $email) {
                    dispatch(new InvoiceSenderByEmail($invoiceId, $templateId, $email));
                }
            }
            // sending invoice copy to admin email
            if (gettype($request->emails) == 'array' && count($request->emails) > 0) {
                if (customerEmail(1)) {
                    dispatch(new InvoiceSenderByEmail($invoiceId, $templateId, customerEmail(1)));
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice Successfully Sent.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to Sent!',
            ], 500);
        }
    }

    public function savingCustomerType(Request $request)
    {

        $request->validate(['name' => 'required'],['name.required'=>'Enter Name of Customer Type.']);

        $domain = parse_url(config('app.url'), PHP_URL_HOST);
        $requested_domain = $request->getHost();

        if ($domain == $requested_domain) {

            $check_exists = Customertype::where('name', 'LIKE', '%'.$request->name.'%')->first();
            
            if (!$check_exists) {

                $type = Customertype::create(['name' => $request->name]);

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Saved Successfully.',
                    'data'    => $type,
                ], 200);
            } else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'This Name Already Exists!',
                ], 500);

            }
        }  else {
            
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to Save!',
            ], 500);
        }
    }
}
