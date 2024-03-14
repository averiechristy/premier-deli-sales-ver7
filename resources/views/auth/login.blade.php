<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Premier Deli - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">
</head>

<body style="background-color: #9B5718;" class="body">
<img src="img/logopremier.png" alt="" height="100px" width="100px">
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5" style="height: 500px;">
                    <div class="card-body p-0" style="margin-top:50px;">
                        <!-- Nested Row within Card Body -->
                       
                      
                            <div class="">
                                <div class="p-5">
                                    <div class="text-center mb-5" >
                                        <img src="img/logo.png" alt="" height="50%" width="50%">
                                        
                                    </div>
                                    @include('components.alert')
                                    <form action="{{route('login')}}" method="post" class="user">
                                    @csrf
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukan Email">
                                        </div>
                                        <div class="form-group mb-4">
                                        <div class="password-container" style="position: relative;">
    <input type="password" id="password" name="password"  class="form-control form-control-user" placeholder="Masukan Password" required>
    <i class="toggle-password fas fa-eye" style=" position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    cursor: pointer;"></i>
</div>
</div>         
                                        
                                        <button type="submit" class="btn btn-pd btn-user btn-block">Login</button>
                                      
                                       
                                    </form>
                                   
                                  
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

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
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
</body>

</html>