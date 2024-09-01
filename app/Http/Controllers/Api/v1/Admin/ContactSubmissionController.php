<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyToContactSubmissionMail;

class ContactSubmissionController extends Controller
{

    public function index()
    {
        $key = request()->input('search');
        $perPage = request()->input('per_page', 10);

        $submissions = Contact::latest()->paginate($perPage);
        return $submissions;
    }

    // Show a specific contact submission by ID
    public function show($id)
    {
        $Contact = Contact::findOrFail($id);
        return response()->json($Contact);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required',
        ]);

        $Contact = Contact::findOrFail($id);

        try {
            // Send the reply email
            Mail::to($Contact->email)->send(new ReplyToContactSubmissionMail(
                $Contact->fullname,
                $request->reply_message
            ));

            // Mark the submission as replied and change the status to processed
            $Contact->replied = true;
            $Contact->status = 'processed';
            $Contact->save();

            return response()->json([
                'message' => 'Reply sent successfully and status updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,closed',
        ]);

        $Contact = Contact::findOrFail($id);
        $Contact->status = $request->status;
        $Contact->save();

        return response()->json([
            'message' => 'Status updated successfully',
            'Contact' => $Contact,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required',
            'body' => 'sometimes|required',
        ]);

        $Contact = Contact::findOrFail($id);
        $Contact->update($request->all());

        return response()->json($Contact);
    }

    public function destroy($id)
    {
        $Contact = Contact::findOrFail($id);
        $Contact->delete();

        return response()->json(['message' => 'Contact submission deleted successfully']);
    }
}
