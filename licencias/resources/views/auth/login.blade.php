@extends('generals.auth_template')

@section('content')
    <div class="content overflow-hidden">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <!-- Login Block -->
                <div class="block block-themed animated fadeIn">
                    <div class="block-header bg-primary">
                        <h3 class="block-title">Login</h3>
                    </div>
                    <div class="block-content block-content-full block-content-narrow">
                        <!-- Login Title -->
                        <img src="{{ asset(env('LOGO')) }}" class="responsive-img" style="width: 100%; height: 200px">
                        <!-- END Login Title -->

                        <!-- Login Form -->
                        <!-- jQuery Validation (.js-validation-login class is initialized in js/pages/base_pages_login.js) -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-login form-horizontal push-30-t push-50" method="POST" action="/auth/login">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input type="password" class="form-control" name="password" id="password">
                                        <label for="login-password">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-md-4">
                                    <button class="btn btn-block btn-primary" type="submit"><i class="si si-login pull-right"></i> Entrar</button>
                                </div>
                            </div>
                        </form>
                        <!-- END Login Form -->
                    </div>
                </div>
                <!-- END Login Block -->
            </div>
        </div>
    </div>
    <!-- END Login Content -->
@endsection