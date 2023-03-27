<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'email' => 'required|email',
                'subject' => 'required|string',
                'message' => 'required|string',
                'subscription' => 'nullable|boolean',
            ],
            [
                'email.required' => "L'email è obbligatoria",
                'email.email' => "l'email non è valida",
                'subject.required' => 'Il messaggio deve avere un oggetto',
                'message.required' => 'Il messaggio deve avere un contenuto',
                'subscription.boolean' => 'Il valore del checkbox non è valido',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // checking if user wants to be subscribed to newsletter
        if (Arr::exists($data, 'subscription')) {
            $exists = Contact::where('email', $data['email'])->count();
            if (!$exists) {
                $contact = new Contact();
                $contact->email = $data['email'];
                $contact->save();
            }
        }

        // Sending of Email
        $mail = new ContactMessageMail(
            sender: $data['email'],
            subject: $data['subject'],
            message: $data['message'],
        );

        Mail::to(env('MAIL_FROM_ADDRESS'))->send($mail);
        return response(null, 204);
    }
}
