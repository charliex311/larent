<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Template;
use App\Models\Paymentmethod;
use App\Models\Deposithistory;
use App\Models\Customertransaction;
use App\Models\Stripething;
use App\Http\Controllers\ApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload-single-via-ftp', function(Request $request){
    $file     = $request->file('filename');
    $uploadID = $request->input('upload_id');
    if ($uploadID) {
        $service = \App\Models\Service::find($uploadID);
        if ($service) {
            $datafile = [];
            $remotePath = 'uploads/' . $file->getClientOriginalName();
            $datafile[] = [
                'caption' => $request->media_caption,
                'file'    => ftpImage($remotePath)
            ];
            Storage::disk('ftp')->put($remotePath, fopen($file, 'r+'));


            // Decode the existing files, default to an empty array if null
            $files = json_decode($service->files, true) ?? [];
    
            // Merge the existing files with the new datafile
            $updated_files = is_array($files) && count($files) > 0 ? array_merge($files, $datafile) : $datafile;
    
            // Update the service record with the new files
            $service->update(['files' => json_encode($updated_files)]);
        }
    }
    return redirect('/admin/services');
});

Route::post('/upload-via-ftp', function(Request $request){
    
    $uploadedFiles  = $request->file('files');
    $uploadID = $request->input('upload_id');

    //Log::info($request->all());

    if ($uploadID) {
        $service = \App\Models\Service::find($uploadID);
        
        if ($service) {

            $datafile = [];
            if ($uploadedFiles && is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    $remotePath = 'uploads/' . $file->getClientOriginalName();
                    $datafile[] = [
                        'caption' => $request->media_caption,
                        'file'    => ftpImage($remotePath)
                    ];
                    Storage::disk('ftp')->put($remotePath, fopen($file, 'r+'));
                }
            }

            // Decode the existing files, default to an empty array if null
            $files = json_decode($service->files, true) ?? [];
    
            // Merge the existing files with the new datafile
            $updated_files = is_array($files) && count($files) > 0 ? array_merge($files, $datafile) : $datafile;
    
            // Update the service record with the new files
            $service->update(['files' => json_encode($updated_files)]);
        }
    }
    
});


Route::post('/update-event', function(Request $request){
    
    $service    = \App\Models\Joblist::find($request->id);
    $start_date = $request->start;
    $end_date   = $request->end;

    if ($service && $start_date) {

        $job_date = $service->job_date;

        if ($job_date) {

            $time         = $job_date->toTimeString();
            $updated_date = $start_date.' '.$time;
            $service->update(['job_date' => $updated_date]);

        } else {
            if ($end_date) {

                $checkin_time     = $service->checkin->toTimeString();
                $updated_checkin  = $start_date.' '.$checkin_time;
                
                $checkout_time    = $service->checkout->toTimeString();
                $updated_checkout = $end_date.' '.$checkout_time;

                $service->update([
                    'checkin'  => $updated_checkin,
                    'checkout' => $updated_checkout
                ]);
            }
        }
    }
});


Route::post('/submit-new-journal', function(Request $request){

    $job = \App\Models\Joblist::find($request->job_id);
    if($job){
        
        if ($request->id) {

            $journals          = json_decode($job->journals, true) ?? [];
            $journalId         = $request->id;
            $newJournalContent = $request->journal;

            $filteredJournals = array_filter($journals, function($journal) use ($journalId) {
                return isset($journal['id']) && $journal['id'] === $journalId;
            });
    
            $foundJournal = reset($filteredJournals);
            if ($foundJournal) {
                foreach ($journals as &$journal) {
                    if ($journal['id'] === $journalId) {
                        $journal['journal'] = $newJournalContent;
                        $journal['updated_at'] = Carbon::now();
                        break;
                    }
                }
    
                $job->journals = json_encode($journals);
                $job->save();
            }

            $merged_journals = json_decode($job->journals, true) ?? [];

        } else {

            $old_journals = json_decode($job->journals, true) ?? [];
    
            $new_journal = [
                'id'         => Str::uuid()->toString(),
                'user_id'    => $request->user_id,
                'journal'    => $request->journal,
                'role_name'  => $request->role_name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
    
            $merged_journals = array_merge($old_journals, [$new_journal]);
    
            $job->update([
                'journals' => json_encode($merged_journals)
            ]);
        }


        $currentUserId = $request->user_id;
    
        if (role_name($currentUserId) == 'Administrator') {

            foreach ($merged_journals as &$journal) {
                $journal['full_name'] = fullName($journal['user_id']);
            }

            return response()->json([
                'success' => true,
                'journals' => $merged_journals
            ], 200);

        } else {
            
            $user_journals = [];
            foreach ($merged_journals as &$journal) {
                if ($journal['user_id'] == $currentUserId) {
                    $journal['full_name'] = fullName($journal['user_id']);
                    $user_journals[] = $journal;
                }
            }

            return response()->json([
                'success' => true,
                'journals' => $user_journals
            ], 200);
        }

    } else {
        return response()->json([
            'success' => false,
            'message' => 'Job not found.'
        ], 404);
    }
});


Route::post('/delete-journal', function(Request $request){

    
    $job = \App\Models\Joblist::find($request->job_id);
    if($job){
        
        $journals = json_decode($job->journals, true);
        $journalId = $request->journal_id;
        $currentUserId = $request->user_id;

        $journals = array_filter($journals, function($journal) use ($journalId) {
            return isset($journal['id']) && $journal['id'] !== $journalId; // Only keep journals that don't match the ID
        });

        $journals = array_values($journals);
        $job->journals = json_encode($journals);
        $job->save();


        $merged_journals = json_decode($job->journals, true);

        if (role_name($currentUserId) == 'Administrator') {
            
            foreach ($merged_journals as &$journal) {
                $journal['full_name'] = fullName($journal['user_id']);
            }

            return response()->json([
                'success' => true,
                'journals' => $merged_journals
            ], 200);
        } else {

            $user_journals = [];
            foreach ($merged_journals as &$journal) {
                if ($journal['user_id'] == $currentUserId) {
                    $journal['full_name'] = fullName($journal['user_id']);
                    $user_journals[] = $journal;
                }
            }

            return response()->json([
                'success' => true,
                'journals' => $user_journals
            ], 200);
        }
        

    } else {
        return response()->json([
            'success' => false,
            'message' => 'Job not found.'
        ], 404);
    }
});


Route::post('/balance-topup', function(Request $request){

    $stripe = Stripething::first();

    if ($stripe) {

        Stripe::setApiKey($stripe->public_key);
        $userID      = $request->user_id;
        $description = 'balance top-up';
    
        if ($userID) {
    
            $data = [
                'amount'      => $request->amount, // Amount in cents
                'currency'    => 'usd',
                'source'      => $request->token,
                'description' => $description,
            ];
        
            try{
                $charge = Charge::create($data);
                $transactionId = $charge->id;
                $payment_method_row = Paymentmethod::where('name',  'stripe')->first();
                
                if ($payment_method_row && $payment_method_row->status == 'enable') {
                    $deposit = Deposithistory::create([
                        'user_id'         => $userID,
                        'payment_method'  => 'Stripe',
                        'payment_details' => $transactionId,
                        'amount'          => doubleval($request->amount),
                        'notes'           => $description,
                    ]);
                    if ($deposit) {
                        Customertransaction::create([
                            'user_id'           => $deposit->user_id,
                            'amount'            => 0,
                            'transaction_id'    => $deposit->payment_details,
                            'deposithistory_id' => $deposit->id,
                            'type'              => 'deposit',
                            'status'            => 'in_review'
                        ]);
                    }
                }
    
                return back()->with('message', 'Payment Successfull.');
            } catch(\Exception $e){
                return back()->withError('Error!', $e->getMessage());
            }
        }
    } else {
      return back()->withError('Error!', 'Invalid');
    }
});


Route::post('/email-body', function(Request $request) {
    $template = Template::find($request->id);

    if ($template) {
        $body = $template->body;
        return response()->json(['body' => $body]);
    } else {
        return response()->json(['body' => '']);
    }
});



Route::post('/send-invoices', [ApiController::class, 'sendInvoices']);
Route::post('/saving-customer-type', [ApiController::class, 'savingCustomerType']);