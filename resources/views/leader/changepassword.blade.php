@extends('layouts.leader.app')

@section('content')



<div class="container">

@if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

                    <div class="row">
                       
                            <img src="{{asset('img/undraw_profile.svg')}}" style="height: 100px; width: 100px;">
                            <h3 style="margin-top: 34px; margin-left: 12px;"> {{ Auth::user()->nama }}</h3>
                            

                           
                       
                    </div>
                    <form method="POST" action="{{ route('leader-change-password') }}">
        @csrf

            <hr>
            <div class="form-group mb-4">
    <div class="password-container position-relative">
        <input id="current_password" type="password" name="current_password" class="form-control" placeholder="Current Password">
       
        <i class="toggle-password fas fa-eye eye-toggle"></i>
    </div>
    @if($errors->has('current_password'))
        <p class="text-danger">{{ $errors->first('current_password') }}</p>
    @endif
</div>

<div class="form-group mb-4">
    <div class="password-container position-relative">
        <input id="new_password" type="password" name="new_password" class="form-control" placeholder="New Password">
      
        <i class="toggle-password1 fas fa-eye eye-toggle"></i>
        
    </div>
    @if($errors->has('new_password'))
        <p class="text-danger">{{ $errors->first('new_password') }}</p>
    @endif
</div>

<div class="form-group mb-4">
    <div class="password-container position-relative">
        <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password">
        <i class="toggle-password2 fas fa-eye eye-toggle"></i>
    </div>
    @if($errors->has('new_password_confirmation'))
        <p class="text-danger">{{ $errors->first('new_password_confirmation') }}</p>
    @elseif($errors->has('new_password'))
        <p class="text-danger">{{ $errors->first('new_password') }}</p>
    @endif
</div>


       

      
        <div class="mb-3">
            <button class="btn btn-primary" type="submit">Ubah Password</button>
        </div>
    </form>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('current_password');
    const togglePasswordIcon = document.querySelector('.toggle-password');

    togglePasswordIcon.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('new_password');
    const togglePasswordIcon = document.querySelector('.toggle-password1');

    togglePasswordIcon.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('new_password_confirmation');
    const togglePasswordIcon = document.querySelector('.toggle-password2');

    togglePasswordIcon.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
        }
    });
});
</script>
@endsection