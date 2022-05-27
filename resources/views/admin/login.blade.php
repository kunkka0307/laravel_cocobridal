@extends('layouts.admin')

@section('content')
    {{ Form::open(['route' => 'admin.login.do', 'method' => 'POST']) }}
        <section class="sec_register container3">
            <h3 class="sec_title">ログイン</h3>
            <div class="register_box">
                <div>
                    <input type="text" class="input input_full_width" name="email" placeholder="メールアドレス">
                    @error('email')
                        <div class="invalid">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input_div">
                    <input type="password" class="input input_full_width" name="password" placeholder="パスワード">
                    @error('password')
                        <div class="invalid">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input_div mt2 next_login_check_box">
                    <input type="checkbox" name="remember" id="next_login_check"><label for="next_login_check" class="next_login_check">次回から自動ログイン</label>
                </div>
                <div class="submit_btn mt4">
                    <button type="submit" class="submit_pink_btn">ログイン</button>
                </div>
            </div>
        </section>
    {{ Form::close() }}
@endsection
