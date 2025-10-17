<link href="{{ url('final_eagri/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<section class="py-5" style="background: linear-gradient(180deg, #f0f9f1 0%, #eaf6ea 100%);">
    <div class="col-lg-6 mx-auto mt-5 jumbotron shadow-sm" style="border-radius:12px;">
        <form class="form-group" action="{{ route('admin_login_check') }}" method="POST">
            @csrf
            <div class="text-center mb-3">
                <h1 class="text-agro">Admin Login</h1>
                <p class="small text-muted">Access the AgroConnect control panel</p>
                <h5 class="text-danger">{{ Session::get('msg') }}</h5>
                <h5 class="text-danger">{{ Session::get('login_error') }}</h5>
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="text" id="email" name="email" placeholder="admin@agroconnect.com"
                    class="form-control" required>
                <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : ' ' }}</span>
            </div>

            <div class="control-group">
                <label>Password</label>
                <input type="password" id="password" name="password" placeholder="Your password" class="form-control"
                    required>
            </div>

            <div class="control-group mt-3">
                <button class="btn btn-agro btn-block">Login</button>
            </div>
        </form>

        <div class="mt-3 d-flex justify-content-between">
            <button class="btn btn-outline-success" data-toggle="modal" data-target="#ForgotPasswordModal">Forgot
                Password</button>
            <!-- Optional: link to public site -->
            <a href="{{ route('home') }}" class="btn btn-link">Back to Site</a>
        </div>
    </div>
</section>

<div class="modal" id="ForgotPasswordModal">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h3>Forgot Password</h3>
                <button class="close text-dark" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin_pw_change_link') }}" method="post">

                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="" class="form-control"
                            placeholder="Enter your email" required>
                        <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : ' ' }}</span>
                    </div>
                    <input type="submit" value="Send" class="btn btn-success btn-block">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ url('final_eagri/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ url('final_eagri/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
