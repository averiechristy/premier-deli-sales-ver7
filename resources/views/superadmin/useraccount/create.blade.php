@extends('layouts.superadmin.app')

@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Akun User Baru
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('superadmin.useraccount.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

                                       <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Pilih Role</label>
    <select name="role_id" id="role_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Role --</option>
      @foreach ($role as $item)
                <option value="{{$item->id}}"> {{$item -> jenis_role}}</option>
      @endforeach
    </select>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama User</label>
    <input name="nama_user" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>
                                


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Email</label>
    <input name="email" type="email"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">No Handphone</label>
    <input name="no_hp" type="number" class="form-control " style="border-color: #01004C;" value="" oninput="validasiNumber(this)" />
</div>

<script>
function validasiNumber(input) {
    // Hapus karakter titik (.) dari nilai input
    input.value = input.value.replace(/\./g, '');

    // Pastikan hanya karakter angka yang diterima
    input.value = input.value.replace(/\D/g, '');
}
</script>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Password</label>
        <input name= "password" type="text"  class="form-control "  value="12345678" readonly></div>

        <div id="userSelect" style="display: none;">
                    <div class="form-group mb-4">
                        <label for="" class="form-label" style="color:black;">Report To</label>
                        <select name="selected_user" id="selected_user_a"  class="form-control" style="border-color: #01004C;"
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
                        <select name="selected_user" id="selected_user_b" class="form-control" style="border-color: #01004C;"
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
    let email = document.forms["saveform"]["email"].value;
    let nohp = document.forms["saveform"]["no_hp"].value;
    let reportA = document.getElementById("selected_user_a").value;
    let reportB = document.getElementById("selected_user_b").value;


   
    
  if (koderole == "" ) {
    alert("Role tidak boleh kosong");
    return false;
  } else if (namauser == "" ){
    alert("Nama user tidak boleh kosong");
    return false;
  } else if (email == "" ){
    alert("Email tidak boleh kosong");
    return false;
  } else if (nohp == ""){
    alert("No handphone tidak boleh kosong");
    return false;
  } 

  if ( koderole == 5 ) {
       
        if (reportA == "") {
            alert("Report To tidak boleh kosong");
            return false;
        }
    }
    if ( koderole == 2 || koderole == 4 ) {
       
       if (reportB == "") {
           alert("Report To tidak boleh kosong");
           return false;
       }
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


<script>
window.onload = function () {
    var inputFields = document.getElementsByTagName('input');
    for (var i = 0; i < inputFields.length; i++) {
        if (inputFields[i].type !== 'date' && inputFields[i].name !== '_token'  && inputFields[i].name !== 'password') {
            inputFields[i].value = '';
        }
    }

    var textareaFields = document.getElementsByTagName('textarea');
    for (var j = 0; j < textareaFields.length; j++) {
        textareaFields[j].value = '';
    }

    var selectFields = document.getElementsByTagName('select');
    for (var k = 0; k < selectFields.length; k++) {
        selectFields[k].selectedIndex = 0; // Mengatur indeks pilihan ke 0
    }
    
    if (window.history && window.history.pushState) {
        window.addEventListener('popstate', function () {
            window.location.reload();
        });
    }
};

</script>
@endsection