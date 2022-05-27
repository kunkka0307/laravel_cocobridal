<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UserLoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;
use App\Models\Student;
use App\Models\Tutor;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $guardName;
    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('auth.' . $this->guardName)
            ->except([
                'showLoginForm',
                'logout',
                'login',
                'redirectToProvider',
                'handleProviderCallback'
            ]);
        
        $this->middleware('guest:' . $this->guardName)->except(['logout', 'handleProviderCallback']);
    }

    public function guard()
    {
        return Auth::guard($this->guardName);
    }

    protected function getRoleByGuard()
    {
        $roles = Role::pluck('id', 'name')->toArray();

        switch ($this->guardName) {
            case 'student':
                return $roles[Role::STUDENT] ?? UserRole::SUBSCRIBER;
            case 'tutor':
                return $roles[Role::TUTOR] ?? UserRole::TUTOR;
            case 'admin':
                return $roles[Role::ADMINISTRATOR] ?? UserRole::ADMINISTRATOR;
            default:
                return '';
        }
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['is_active'] = true;
        $credentials['role_id'] = $this->getRoleByGuard();

        if ($this->guard()->attempt($credentials, $request->filled('remember'))) {
            $this->guard()->user()->update([
                'login_at'      => \Carbon\Carbon::now()
            ]);
            if ($request->session()->has('login_after')) {
                $url = $request->session()->pull('login_after');
                $request->session()->forget('login_after');
                return redirect($url);
            }
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function loginPost()
    {
        $credentials = request()->only('email', 'password');
        $credentials['is_active'] = true;
        $credentials['role_id'] = $this->getRoleByGuard();

        if ($this->guard()->attempt($credentials)) {
            return Redirect::intended();
        }
        return back();
    }

    public function showLoginForm()
    {
        var_dump("asdfadsf");
        die('');
        return view($this->guardName . '.login');
    }

    public function me()
    {
        return $this->guard()->user();
    }

    public function logout()
    {
        $this->guard()->logout();

        return redirect(route($this->guardName . '.login'));
    }

    public function redirectToProvider($provider)
    {
        if (in_array($provider, ['google', 'line'])) {
            if ($provider === 'line') {
                return Socialite::driver($provider)->with(['bot_prompt' => 'aggressive'])->redirect();
            }

            return Socialite::driver($provider)->redirect();
        }

        return redirect(route('student.login'));
    }

    private function detectAvatar($provider, $userSocial, $userDecode)
    {
        switch ($provider) {
            case 'line':
            case 'google':
                return $userSocial['picture'] ?? null;
            case 'facebook':
                return $userDecode->avatar ?? null;
            case 'github':
                return $userSocial['avatar_url'] ?? null;
            default:
                return null;
        }
    }

    public function handleProviderCallback($provider)
    {
        try {
            $userDecode = Socialite::driver($provider)->user();
            $userSocial = $userDecode->user;
            if (empty($userSocial) || !isset($userSocial['email'])) {
                throw new \Exception('Cannot get email');
            }

            $userEmail = $userSocial['email'];
            $friend_add = request()->session()->pull("friend_add");
            $tutor_friend_add = request()->session()->pull("tutor_friend_add");

            if ($provider === 'line' && isset($friend_add)) {
                $user = User::where('email', $userEmail)->first();

                $current_id = Auth::guard('student')->check() ? Auth::guard('student')->user()->id : null;

                $friendship_status_changed = request()->get('friendship_status_changed');
                
                if (isset($user) && $user->id != $current_id) {
                    return redirect()->route('mypage', ['system.message.danger' => 'すでに登録済みLINEアカウントです。']);
                }

                $user = Student::where('line_email', $userEmail)->first();
                if (isset($user) && $user->user->id != $current_id) {
                    return redirect()->route('mypage', ['system.message.danger' => 'すでに登録済みLINEアカウントです。']);
                }

                $user = Tutor::where('line_email', $userEmail)->first();
                if (isset($user)) {
                    return redirect()->route('mypage', ['system.message.danger' => 'このラインアカウントは講師アカウントで登録されているため登録できません。']);
                }

                $user = Auth::guard('student')->user();
                $user->student->update([
                    'line_uid' => $userSocial['sub'] ?? null,
                    'line_email' => $userEmail,
                    'line_follow' => ($friendship_status_changed == true || $friendship_status_changed == 'true') ? 1 : 0
                ]);

                $user->update([
                    'login_at'      => \Carbon\Carbon::now()
                ]);

                return redirect()->route('mypage', ['system.message.success' => 'LINEアカウントを連携しました。']);
            }

            if ($provider === 'line' && isset($tutor_friend_add)) {
                $user = User::where('email', $userEmail)->first();

                $current_id = Auth::guard('tutor')->check() ? Auth::guard('tutor')->user()->id : null;

                $friendship_status_changed = request()->get('friendship_status_changed');
                
                if (isset($user) && $user->id != $current_id) {
                    return redirect()->route('tutor.profile.show')->with(['system.message.danger' => 'すでに登録済みLINEアカウントです。']);
                }

                $user = Tutor::where('line_email', $userEmail)->first();
                if (isset($user) && $user->user->id != $current_id) {
                    return redirect()->route('tutor.profile.show')->with(['system.message.danger' => 'すでに登録済みLINEアカウントです。']);
                }

                $user = Student::where('line_email', $userEmail)->first();
                if (isset($user)) {
                    return redirect()->route('tutor.profile.show')->with(['system.message.danger' => 'このラインアカウントはユーザーアカウントで登録されているため登録できません。']);
                }

                $user = Auth::guard('tutor')->user();
                $user->tutor->update([
                    'line_uid' => $userSocial['sub'] ?? null,
                    'line_email' => $userEmail,
                    'line_follow' => ($friendship_status_changed == true || $friendship_status_changed == 'true') ? 1 : 0
                ]);

                $user->update([
                    'login_at'      => \Carbon\Carbon::now()
                ]);

                return redirect()->route('tutor.profile.show')->with(['system.message.success' => 'LINEアカウントを連携しました。']);
            }

            $user = User::firstOrNew([
                'email' => $userEmail,
                'role_id' => $this->getRoleByGuard(),
            ]);

            if (!$user->exists) {
                $user->email = $userEmail;
                $user->name = $userSocial['name'] ?? '';
                $user->is_active = 1;
                $user->avatar = $this->detectAvatar($provider, $userSocial, $userDecode);
                $user->save();
            }

            if ($provider === 'line' && $user->role_id === \App\Enums\UserRole::SUBSCRIBER) {
                $friendship_status_changed = request()->get('friendship_status_changed');

                \App\Models\Student::updateOrCreate(
                    [
                        'user_id' => $user->id
                    ],
                    [
                        'line_uid' => $userSocial['sub'] ?? null,
                        'line_email' => $userEmail,
                        'line_follow' => ($friendship_status_changed == true || $friendship_status_changed == 'true') ? 1 : 0
                    ]
                );
            }

            $this->guard()->login($user);

            $user->update([
                'login_at'      => \Carbon\Carbon::now()
            ]);

            $intended_url = request()->session()->get('url.intended', url('/'));
            if ($intended_url === url('/')) {
                return redirect()->to(route('mypage')); // mypageへ転送
            }
            return Redirect::intended();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect(route('student.login', [
                'system.message.danger' => 'ソーシャルアカウントでメールが設定しない場合はログインできません。メールを追加してください。またはメール登録でご登録ください。',
            ]));
        }
    }
}
