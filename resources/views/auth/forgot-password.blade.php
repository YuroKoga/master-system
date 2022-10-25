<!DOCTYPE html>
<html lang="ja">

<head>
    @component('components.header')
        <!-- Page Title -->
        @slot('page_title')
            Forgot Password
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
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">パスワードを忘れましたか？</h1>
                                        <p class="mb-4">
                                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                        </p>
                                    </div>
                                    {{-- <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

                                    <!-- Validation Errors -->
                                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                                    <form class="user" method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="メールアドレスを入力してください...">
                                        </div>

                                        <a href="login.html" class="btn btn-primary btn-user btn-block">
                                            パスワードのリセット
                                        </a>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.html">新規アカウント登録</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.html">ログイン</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
