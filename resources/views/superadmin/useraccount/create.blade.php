@extends('layouts.superadmin.app')

@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan User Akun Baru
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('superadmin.useraccount.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

                                       <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Pilih Role</label>
    <select name="role_id" id="role_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Role --</option>
      @foreach ($role as $role)
                <option value="{{$role->id}}"> {{$role -> jenis_role}}</option>
      @endforeach
    </select>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama User</label>
    <input name="nama_user" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>
                                
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Username</label>
    <input name="username" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Email</label>
    <input name="email" type="email"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">No Handphone</label>
    <input name="no_hp" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Password</label>
        <input name= "password" type="text"  class="form-control "  value="12345678" readonly></div>

        <div id="userSelect" style="display: none;">
                    <div class="form-group mb-4">
                        <label for="" class="form-label" style="color:black;">Report To</label>
                        <select name="selected_user" class="form-control" style="border-color: #01004C;"
                            aria-label=".form-select-lg example">
                            <option value="" selected disabled>-- Pilih Role --</option>
      @foreach ($user as $item)
                <option value="{{$item->id}}"> {{$item -> nama}}</option>
      @endforeach
                        </select>
                    </div>
                </div>

                <div id="userSelectmanager" style="display: none;">
                    <div class="form-group mb-4">
                        <label for="" class="form-label" style="color:black;">Report To</label>
                        <select name="selected_user" class="form-control" style="border-color: #01004C;"
                            aria-label=".form-select-lg example">
                            <option value="" selected disabled>-- Pilih Role --</option>
      @foreach ($manager as $item)
                <option value="{{$item->id}}"> {{$item -> nama}}</option>
      @endforeach
                        </select>
                    </div>
                </div>
                
        <div class="form-group mb-4">
                                                <button type="submit" class="btn btn-pd " style="">Simpan</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
      
  
<script>

function validateForm() {
    let koderole = document.forms["saveform"]["role_id"].value;
    let namauser = document.forms["saveform"]["nama_user"].value;
    let username = document.forms["saveform"]["username"].value;
    let email = document.forms["saveform"]["email"].value;

  if (koderole == "" ) {
    alert("Kode role tidak boleh kosong");
    return false;
  } else if (namauser == "" ){
    alert("Nama user tidak boleh kosong");
    return false;
  } else if (username == "" ){
    alert("Username tidak boleh kosong");
    return false;
  }else if (email == "" ){
    alert("Email tidak boleh kosong");
    return false;
  }
}

document.getElementById("role_id").addEventListener("change", function () {
        var role_id = this.value;
        var userSelectDiv = document.getElementById("userSelect");
        console.log(userSelectDiv);

        if (role_id == 5) {
            userSelectDiv.style.display = "block";
            // You can populate options dynamically here
        } else {
            userSelectDiv.style.display = "none";
        }
    });

    
document.getElementById("role_id").addEventListener("change", function () {
        var role_id = this.value;
        var userSelectDiv = document.getElementById("userSelectmanager");
        console.log(userSelectDiv);

        if (role_id == 4) {
            userSelectDiv.style.display = "block";
            // You can populate options dynamically here
        } 

        else if (role_id == 2) {
            userSelectDiv.style.display = "block";
            // You can populate options dynamically here
        } 
        
        else {
            userSelectDiv.style.display = "none";
        }
    });
</script>


@endsection