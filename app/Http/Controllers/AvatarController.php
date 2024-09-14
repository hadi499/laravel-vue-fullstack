<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'avatar' => 'image|file|max:1024|nullable',
        ];


        $validatedData = $request->validate($rules);

        if ($request->file('avatar')) {
            if ($request->oldAvatar) {
                Storage::delete($request->oldAvatar);
            }
            $validatedData['avatar'] = $request->file('avatar')->store('avatars');
        } else {

            $validatedData['avatar'] = $request->oldAvatar;
        }

        $request->user()->update([
            'avatar' => $validatedData['avatar'],
        ]);



        return back();
    }
}
