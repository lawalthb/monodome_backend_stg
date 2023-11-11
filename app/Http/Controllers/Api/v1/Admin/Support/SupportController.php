<?php

namespace App\Http\Controllers\Api\v1\Admin\Support;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\SupportAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SupportTicketResource;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->input('per_page', 15);

        $page_title = "Support Tickets";
        $supports = SupportTicket::with('user')->latest()->paginate($perPage);

        return $this->success(['supports' => SupportTicketResource::collection($supports)], 'Support Tickets retrieved successfully');
    }


    public function pendingTicket(){

        $getPaginate = request()->input('per_page', 15);

        $supports = SupportTicket::whereIn('status', [0,2])->latest()->with('user')->paginate($getPaginate);
        return $this->success(['supports' => SupportTicketResource::collection($supports)], 'Pending Tickets retrieved successfully');

    }


       public function closeTicket(){

        $getPaginate = request()->input('per_page', 15);

        $supports = SupportTicket::whereIn('status', [3])->latest()->with('user')->paginate($getPaginate);
        return $this->success(['supports' => SupportTicketResource::collection($supports)], 'Close Tickets retrieved successfully');

    }


       public function answeredTicket(){

        $getPaginate = request()->input('per_page', 15);

        $supports = SupportTicket::whereIn('status', [1])->latest()->with('user')->paginate($getPaginate);
        return $this->success(['supports' => SupportTicketResource::collection($supports)], 'Answered Ticket retrieved successfully');

    }



      public function ticketReply($id){

        $getPaginate = request()->input('per_page', 15);
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $supports = SupportMessage::with('ticket')->where('supportticket_id', $ticket->id)->latest()->get();
        return $this->success(['supports' => SupportTicketResource::collection($supports)], 'Ticket Reply retrieved successfully');

    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id)
    {
        $ticket = SupportTicket::with('user')->where('id', $id)->firstOrFail();
        $message = new SupportMessage();
        if ($request->replayTicket == 1) {

            $imgs = $request->file('attachments');
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx');

            $this->validate($request, [
                'attachments' => [
                    'array',
                    'max:5', // Maximum 5 files can be uploaded
                    function ($attribute, $value, $fail) use ($allowedExts) {
                        foreach ($value as $file) {
                            if (!($file instanceof \Illuminate\Http\UploadedFile)) {
                                return $fail("Invalid file type");
                            }
                            $ext = strtolower($file->getClientOriginalExtension());
                            if (($file->getSize() / 1000000) > 2) {
                                return $fail("Images MAX 2MB ALLOW!");
                            }
                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                            }
                        }
                    },
                ],
                'message' => 'required',
            ]);

            $ticket->status = 1;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            $message->supportticket_id = $ticket->id;
            $message->admin_id = Auth::id();
            $message->message = $request->message;
            $message->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_message_id = $message->id;
                        $attachment->attachment = $this->uploadFile('support',  $file);
                        $attachment->save();
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Could not upload your ' . $file];
                        return back()->withNotify($notify)->withInput();
                    }
                }
            }

            // notify($ticket, 'ADMIN_SUPPORT_REPLY', [
            //     'ticket_id' => $ticket->ticket,
            //     'ticket_subject' => $ticket->subject,
            //     'reply' => $request->message,
            //     'link' => route('ticket.view',$ticket->ticket),
            // ]);

            $notify[] = ['success', "Support ticket replied successfully"];
            return $this->success(new SupportTicketResource($ticket), 'Support ticket replied successfully!!');

        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->save();
            $notify[] = ['success', "Support ticket closed successfully"];
            return $this->success(new SupportTicketResource($ticket), 'Support ticket closed successfully!');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $message_id)
    {
        $message = SupportMessage::findOrFail($message_id);

    if ($message->attachments()->count() > 0) {
        foreach ($message->attachments as $attachment) {
            @unlink(getImageFile($attachment->image));
            $attachment->delete();
        }
    }

    $message->delete();
    $notify[] = ['success', 'Delete Successfully'];

    return $this->success($notify, 'Message deleted successfully');
    }

    public function ticketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail($ticket_id);
        $file = $attachment->attachment;

        $full_path = getImageFile($file);

        $title = Str::slug($attachment->supportMessage->ticket->subject);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);


        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }


    public function searchTickets(Request $request)
{

    $perPage = request()->input('per_page', 15);

    if (!$request->search) {
        return $this->error('Invalid request');
    }

    $items = SupportTicket::where('ticket', 'LIKE', '%' . $request->search . '%')->paginate($perPage);

    $page_title = 'Support Ticket';
    $empty_message = 'No Result Found for the search ' . $request->search;

    if ($items->count() <= 0) {
        return $this->error($empty_message);
    }

    return $this->success(compact('page_title', 'items', 'empty_message'), 'Search results retrieved successfully');
}
}
