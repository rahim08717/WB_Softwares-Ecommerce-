<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail; 

class ContactMessageController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Contacts/Index', [
            'messages' => Contact::latest()->paginate(10)
        ]);
    }

    public function show($id)
    {
        return Inertia::render('Admin/Contacts/Show', [
            'message' => Contact::findOrFail($id)
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['reply_message' => 'required']);

        $contact = Contact::findOrFail($id);

        try {
            Mail::raw($request->reply_message, function ($message) use ($contact) {
                $message->to($contact->email)
                        ->subject('Reply to: ' . $contact->subject);
            });

            $contact->update(['is_replied' => true]);

            return redirect()->route('admin.contacts.index')->with('success', 'Reply sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return back()->with('success', 'Message deleted successfully!');
    }
}
