<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;


class UserController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Profile', ['user' => User::first()]);
    }

    public function update(UserRequest $request)
    {
        $user = User::first();
        foreach(['email', 'youtube', 'linkedin', 'facebook'] as $field) {
            $user->$field = $request->get($field);
        }

        $user->description = [
            'en' => $request->get('description_en'),
            'fr' => $request->get('description_fr')
        ];

        if ($request->get('password') !== 'undefined') {
            $user->password = Hash::make($request->get('password'));
        }

        if ($request->file('picture')) {
            $file = $request->file('picture');
            $file->storePubliclyAs('/user', $file->getClientOriginalName(), ['disk' => 'public']);
            $user->picture = '/storage/user/' . $file->getClientOriginalName();
        }

        $user->save();

        return Inertia::render('Admin/Profile', ['user' => User::first()]);
    }
}
