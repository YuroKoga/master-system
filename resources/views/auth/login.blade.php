<!DOCTYPE html>
<html lang="ja">

<head>
    @component('components.header')
        <!-- Page Title -->
        @slot('page_title')
            ログイン
        @endslot
    @endcomponent
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <!-- Validation Errors -->
                                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">おかえりなさい！</h1>
                                    </div>

                                    {{-- 入力フォーム --}}
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf

                                        {{-- メールアドレス --}}
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email"
                                                name="email" :value="old('email')" aria-describedby="emailHelp"
                                                placeholder="メールアドレスを入力してください...">
                                        </div>

                                        {{-- パスワード --}}
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password"
                                                name="password" placeholder="パスワード" autocomplete="current-password"
                                                required>
                                        </div>

                                        {{-- ログイン状態の保持 --}}
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input id="remember_me" type="checkbox" class="custom-control-input"
                                                    name="remember">
                                                <label class="custom-control-label"
                                                    for="remember_me">{{ __('Remember me') }}</label>
                                            </div>
                                        </div>

                                        {{-- 送信 --}}
                                        <button class="btn btn-primary btn-user btn-block">
                                            {{ __('Log in') }}
                                        </button>
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Googleでログイン
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Facebookでログイン
                                        </a>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        @if (Route::has('password.request'))
                                            <a class="small"
                                                href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">新規アカウント登録</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('/') }}">トップへ戻る</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
