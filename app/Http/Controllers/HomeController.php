<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Biography;
use App\Models\Music;
use App\Models\User;
use App\Notifications\Contact;
use App\Service\Recaptcha;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function landing()
    {
        return view('front.landing');
    }

    public function biography()
    {
        $bio = Biography::orderBy('year', 'DESC')->get();
        $user = User::first();

        return view('front.biography', compact('user', 'bio'));
    }

    public function music()
    {
        $musics = Music::all();

        return view('front.music', compact('musics'));
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function send(ContactRequest $request, Recaptcha $recaptcha)
    {
        if ($recaptcha->validate($request->get('token'))) {
            $contact = [];
            $fields = ['email', 'name', 'subject', 'message'];

            foreach ($fields as $field) {
                $contact[$field] = $request->get($field);
            }

            Notification::route('mail', User::first()->email)->notify(new Contact($contact));

        } else {
            return redirect()->back()->with('error', "Le recaptcha n'est pas valide");
        }

        return redirect()->back();
    }

    public function legal()
    {
        return view('front.legal');
    }
}
