<!DOCTYPE html>
<html lang="en">

<head>
    @component('components.header')
        <!-- Page Title -->
        @slot('page_title')
            新規利用登録
        @endslot
    @endcomponent
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">アカウントの作成</h1>
                            </div>

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />

                            {{-- フォーム --}}
                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf

                                {{-- ユーザーネーム --}}
                                <div class="form-group">
                                    <input id="name" type="text" class="form-control form-control-user"
                                        name="name" :value="old('name')" placeholder="ユーザーネーム" required autofocus>
                                </div>

                                {{-- メールアドレス --}}
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control form-control-user"
                                        placeholder="メールアドレス" name="email" :value="old('email')" required>
                                </div>

                                {{-- パスワード --}}
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input id="password" type="password" class="form-control form-control-user"
                                            placeholder="パスワード" name="password" required autocomplete="new-password">
                                    </div>

                                    {{-- パスワードの確認 --}}
                                    <div class="col-sm-6">
                                        <input id="password_confirmation" type="password"
                                            class="form-control form-control-user" placeholder="パスワードの確認"
                                            name="password_confirmation" required>
                                    </div>
                                </div>

                                {{-- 送信 --}}
                                <button class="btn btn-primary btn-user btn-block">
                                    {{ __('Register') }}
                                </button>

                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">{{ __('Already registered?') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>
