<?php


namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
            'role_id' => 'required',
            'email_verified_at' => '',
        ]);
        
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role_id'],
                'email_verified_at' => intval($data['email_verified_at']) ? date("Y-m-d H:i:s") : '',
            ]);

            $wallet = Wallet::create([
                    'balance' => 0,
                    'user_id' => $user->id,
                ]);

            DB::commit();
            return redirect()->route('dashboard.administrator.users.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public static function ban(User $user) :void
    {
        $user->banned_at = date("Y-m-d H:i:s");
        $user->save();
        $user->refresh();
    }

    public static function unban($user) :void
    {
        $user->banned_at = null;
        $user->save();
        $user->refresh();
    }
}
