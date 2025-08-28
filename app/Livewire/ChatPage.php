<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Joblist;
use App\Models\Conversation;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatPage extends Component
{
    use WithFileUploads;
    public $myfile;
    public $message;
    public $recipient_id=null;
    public $job_id=null;
    public $service_id=null;
    public $active_contact;

    public function mount(Request $request)
    {
        if (role_name(Auth::user()->id) == 'Administrator') {
            if ($request->recipient) {
                $this->active($request->recipient, '', '');
            }
        } else {
            if (role_name(Auth::user()->id) == 'Employee') {
                if ($request->recipient && $request->job && $request->service) {
                    $this->active($request->recipient, $request->job, $request->service);
                }
            }
            if (role_name(Auth::user()->id) == 'Customer') {
                if ($request->recipient && $request->job && $request->service) {
                    $this->active($request->recipient, $request->job, $request->service);
                }
            }
        }
    }

    
    public function active($recipient_id, $job_id, $service_id)
    {
        $this->reset(['recipient_id','job_id']);
        $this->recipient_id = $recipient_id ? $recipient_id : NULL;
        $this->job_id = $job_id ? $job_id : NULL;
        $this->service_id = $service_id ? $service_id : NULL;
    }

    public function send()
    {
        $this->validate(
            [
                'recipient_id' => 'required',
                'message' => 'required'
            ],
            [
                'recipient_id.required' => 'Select an User.',
                'message.required' => 'Type Your Message Here.'
            ]
        );

        Conversation::create([
            'sender_id' => Auth::user()->id, 
            'recipient_id' => $this->recipient_id ? $this->recipient_id : null,
            'joblist_id'   => $this->job_id ? $this->job_id : null,
            'content' => $this->message ? $this->message : null
        ]);

        $this->reset(['message']);
    }

    public function render()
    {
        /* FILE UPLOAD */
        if ($this->myfile) {

            $filename      = $this->myfile->getClientOriginalName();
            $fileExtension = $this->myfile->getClientOriginalExtension();
            $uploaded      = Storage::disk('ftp')->put('uploads', $this->myfile);
            if ($uploaded) {
                Conversation::create([
                    'sender_id'    => Auth::user()->id,
                    'recipient_id' => $this->recipient_id,
                    'content'      => chatStandardFileFormat($uploaded,$fileExtension)
                ]);
                $this->reset('myfile');
            } else {
                //dd('not-uploaded');
            }


            /*$allowedExtensions = ['jpg', 'png', 'jpeg','mp4','mp3','ogv','pdf'];
            $fileExtension = $this->myfile->getClientOriginalExtension();
        
            if (in_array($fileExtension, $allowedExtensions)) {
                
            }*/
        }      
        /* FILE UPLOAD */

        if (role_name(Auth::user()->id) == 'Administrator') {
            $data['contacts'] = User::where('id','!=',1)->get()->map(function ($item) {
                return [
                    'user_id' => $item->id,
                    'service' => null,
                    'service_id' => null,
                    'job_id' => null,
                ];
            })->toArray();
        } else {
            /* PROPERTIES FOR EMPLOYEE PANEL */
            if (role_name(Auth::user()->id) == 'Employee') {
                $data = Joblist::where('employee_id', Auth::user()->id)
                    ->whereIn('job_status', ['1', '2', '3'])
                    ->select('id','user_id', 'service_id')
                    ->get();

                $data['contacts'] = $data->map(function ($item) {
                    return [
                        'user_id' => $item->user_id,
                        'service' => 'Job: '.serviceName($item->service_id),
                        'service_id' => $item->service_id,
                        'job_id' => $item->id,
                    ];
                })->toArray();

                $data['conversations'] = Conversation::where('sender_id', Auth::user()->id)->orWhere('recipient_id', Auth::user()->id)->get();
            }


            /* PROPERTIES FOR CUSTOMER PANEL */
            if (role_name(Auth::user()->id) == 'Customer') {
                $data = Joblist::where('user_id', Auth::user()->id)
                    ->whereIn('job_status', ['1', '2', '3'])
                    ->select('id','employee_id', 'service_id')
                    ->get();

                $data['contacts'] = $data->map(function ($item) {
                    return [
                        'user_id' => $item->employee_id,
                        'service' => 'Job: '.serviceName($item->service_id),
                        'service_id' => $item->service_id,
                        'job_id' => $item->id,
                    ];
                })->toArray();
            }
        }

        $recipientId = $this->recipient_id;
        $data['conversations'] = Conversation::where(function ($query) use ($recipientId) {
            $query->where('sender_id', Auth::user()->id)->where('recipient_id', $recipientId)
                ->orWhere('sender_id', $recipientId)->where('recipient_id', Auth::user()->id);
        })->get();


        // dd($data['conversations']);
        

        return view('livewire.chat-page', $data);
    }
}
