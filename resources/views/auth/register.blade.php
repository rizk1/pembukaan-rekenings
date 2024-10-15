@extends('layout.auth-layout')
@section('title', 'Register')
@section('content')
<div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

        <div class="card card-primary mt-5">
          <div class="card-header"><h4>Register</h4></div>

          <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{url('/register')}}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="email">Nama</label>
                    <input id="email" type="text" class="form-control" value="{{old('name')}}" name="name" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your name
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" value="{{old('email')}}" name="email" required autofocus>
                    <div class="invalid-feedback">
                    Please fill in your email
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                    </div>
                    <div class="input-group">
                        <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-eye toggle-password" style="cursor: pointer;"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback">
                        please fill in your password
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password_confirmation" class="control-label">Password Confirmation</label>
                    </div>
                    <div class="input-group">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-eye toggle-password" style="cursor: pointer;"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback">
                        please fill in your password confirmation
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>

          </div>
        </div>
        <div class="mt-5 text-muted text-center">
          Already have an account? <a href="{{route('login')}}">Login</a>
        </div>
      </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            $(this).toggleClass('fa-eye fa-eye-slash');
            let input = $(this).closest('.input-group').find('input');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
        });
    });
</script>
@endsection
