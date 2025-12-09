<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail; // ইমেইল পাঠানোর জন্য

class ContactMessageController extends Controller
{
    // সব মেসেজ দেখানো
    public function index()
    {
        return Inertia::render('Admin/Contacts/Index', [
            'messages' => Contact::latest()->paginate(10)
        ]);
    }

    // মেসেজ ডিটেইলস এবং রিপ্লাই ফর্ম
    public function show($id)
    {
        return Inertia::render('Admin/Contacts/Show', [
            'message' => Contact::findOrFail($id)
        ]);
    }

    // রিপ্লাই পাঠানো (ইমেইল)
    public function reply(Request $request, $id)
    {
        $request->validate(['reply_message' => 'required']);

        $contact = Contact::findOrFail($id);

        // ১. ইমেইল পাঠানো (আপাতত Raw মেইল, পরে Mailable ক্লাস ব্যবহার করা যাবে)
        // নোট: এটা কাজ করার জন্য .env ফাইলে মেইল কনফিগারেশন থাকতে হবে
        try {
            Mail::raw($request->reply_message, function ($message) use ($contact) {
                $message->to($contact->email)
                        ->subject('Reply to: ' . $contact->subject);
            });

            // ২. স্ট্যাটাস আপডেট
            $contact->update(['is_replied' => true]);

            return redirect()->route('admin.contacts.index')->with('success', 'Reply sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    // মেসেজ ডিলিট
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return back()->with('success', 'Message deleted successfully!');
    }
}
