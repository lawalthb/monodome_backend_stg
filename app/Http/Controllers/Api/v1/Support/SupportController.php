<?php

namespace App\Http\Controllers\Api\v1\Support;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Traits\ApiStatusTrait;
use Illuminate\Support\Carbon;
use App\Traits\FileUploadTrait;
use App\Models\SupportAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SupportTicketResource;
use App\Http\Resources\SupportMessageResource;

class SupportController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $perPage = request()->input('per_page', 15);

        if (Auth::id() == null) {
            return $this->error("User not found");
        }

        $page_title = "Support Tickets";
        $supports = SupportTicket::where('user_id', Auth::id())->latest()->paginate($perPage);

        return $this->success(['supports' => SupportTicketResource::collection($supports), 'page_title' => $page_title], 'Support Tickets retrieved successfully');
    }


    public function openSupportTicket()
{
    if (!Auth::user()) {
        return $this->error("User not found");
    }

    $page_title = "Support Tickets";
    $user = Auth::user();

    return $this->success(['page_title' => $page_title, 'user' => $user], 'Open Support Ticket page loaded successfully');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $files = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');


        $this->validate($request, [
            'attachments' => [
                'max:4096',
                function ($attribute, $value, $fail) use ($files, $allowedExts) {
                    foreach ($files as $file) {
                        $ext = strtolower($file->getClientOriginalExtension());
                        if (($file->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                        }
                    }
                    if (count($files) > 5) {
                        return $fail("Maximum 5 files can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);

        $active = SupportTicket::where('email', $request->email)->whereIn('status', [0, 1, 2])->where('isClosed', 0)->latest('updated_at')->first();

        if ($active) {
            return $this->error("You already have an open ticket, please wait.");
        }

        $user = auth()->user();
        $ticket->user_id = $user->id;
        $random = rand(100000, 999999);
        $ticket->ticket = $random;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->subject = $request->subject;
        $ticket->last_reply = now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->attachment =  $this->uploadFile('support/', $request->file('attachments'));
                    $attachment->save();
                } catch (\Exception $exp) {
                    return $this->error('Could not upload your ' . $file);
                }
            }
        }

        // notify($ticket, 'ADMIN_SUPPORT_REPLY', [
        //     'ticket_id' => $ticket->ticket,
        //     'ticket_subject' => $ticket->subject,
        //     'reply' => $request->message,
        //     'link' => route('ticket.view', $ticket->ticket),
        // ]);

        return $this->success(new SupportTicketResource($ticket), 'Ticket created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ticket)
    {
    $page_title = "Support Tickets";
    $my_ticket = SupportTicket::where('ticket', $ticket)->latest()->first();

    if (!$my_ticket) {
        return $this->error("Ticket not found");
    }

    $messages = SupportMessage::where('supportticket_id', $my_ticket->id)->latest()->get();

    return $this->success([
        'my_ticket' => new SupportTicketResource($my_ticket),
        'messages' => SupportMessageResource::collection($messages),
        'page_title' => $page_title,
        'user' => auth()->user()
    ], 'Ticket details retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function replyTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $message = new SupportMessage();

        $notify = []; // Define $notify here


        if ($request->replayTicket == 1) {
            $imgs = $request->file('attachments');
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc','docx');

            $this->validate($request, [
                'attachments' => [
                    'max:4096',
                    function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                        foreach ($imgs as $img) {
                            $ext = strtolower($img->getClientOriginalExtension());
                            if (($img->getSize() / 1000000) > 2) {
                                return $fail("Images MAX  2MB ALLOW!");
                            }
                            if (!in_array($ext, $allowedExts)) {

                                        return $this->error("Only png, jpg, jpeg, pdf doc docx files are allowed");

                            }
                        }
                        if (count($imgs) > 5) {
                                        return $this->error("Maximum 5 files can be uploaded");
                        }
                    },
                ],
                'message' => 'required',
            ]);

            $ticket->status = 2;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            $message->supportticket_id = $ticket->id;
            $message->message = $request->message;
            $message->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_message_id = $message->id;
                        $attachment->attachment = $this->uploadFile('support/', $request->file('attachments'));
                        $attachment->save();

                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Could not upload your ' . $file];

                          return $this->error( $notify,'error',422);
                    }
                }
            }

            //    notify($ticket, 'ADMIN_SUPPORT_REPLY', [
            //     'ticket_id' => $ticket->ticket,
            //     'ticket_subject' => $ticket->subject,
            //     'reply' => $request->message,
            //     'link' => route('ticket.view',$ticket->ticket),
            // ]);

            $notify[] = ['success', 'Support ticket replied successfully!'];
        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->isClosed = 1;
            $ticket->last_reply = Carbon::now();
            $ticket->save();
            $notify[] = ['success', 'Support ticket closed successfully!'];
        }

        return $this->success(new SupportTicketResource($ticket), 'Ticket replied successfully!');

    }

    public function ticketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->attachment;

        $full_path = getImageFile($file);

        $title = Str::slug($attachment->supportMessage->ticket->subject);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);


        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }
}
