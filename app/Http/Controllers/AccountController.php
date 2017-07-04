<?php

namespace App\Http\Controllers;

use Auth;
use Cloudder;
use Hash;
use Illuminate\Http\Request;
use Storage;

class AccountController extends Controller
{
    protected $user;
    protected $id;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->id = $this->user->id;
    }

    public function getAccountPage()
    {
        return view('account.dashboard')->withAccount($this->user);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email|min:3|unique:users,email,'.$this->id,
            'fullname'  => 'required|min:3',
        ]);

        $values = $request->all();
        $this->user->fill($values)->save();

        return redirect()->back()->with('info', 'Your Profile has been updated successfully');
    }

    public function updateAvatar(Request $request)
    {
        $this->validate($request, [
            'file_name'     => 'required|mimes:jpeg,bmp,png|between:1,7000',
        ]);

        $user = Auth::user();
        $file = $request->file('file_name');
        $filename = $file->getRealPath();
        $entension = $file->getClientOriginalExtension();
        $filepath = "avatars/{$user->id}.".$entension;
        Storage::put($filepath, file_get_contents($filename));

//        Cloudder::upload($filename, null);
//        list($width, $height) = getimagesize($filename);
//        $fileUrl = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);
//        $this->user->update(['avatar' => $fileUrl]);

        $this->user->update(['avatar' => $filepath]);
        return redirect()->back()->with('info', '你的头像更新成功.');
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $this->user->password = Hash::make($request->password);
        $this->user->save();

        return redirect()->back()->with('info', '密码修改成功');
    }

    public function redirectToConfirmDeletePage()
    {
        return view('account.confirm');
    }

    public function dontDeleteAccount()
    {
        return redirect('/account');
    }

    public function deleteAccount(Request $request)
    {
        $this->user->delete();

        $request->session()->flush();

        return redirect('/');
    }
}
