@extends('layouts.superadmin.app')
@section('content')
<div class="container">
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                       Edit Akun User
                                    </div>

                                    <div class="card-body">
                                       <form name="saveform" action="/updateuser/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Pilih Role</label>
    <select name="role_id" id="role_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Role --</option>
    @foreach ($role as $item)
                <option value="{{$item->id}}"{{ old('role_id', $data->role_id) == $item->id ? 'selected' : '' }}> {{$item -> jenis_role}}</option>
      @endforeach
    </select>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama User</label>
    <input name="nama_user" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama}}" />
</div>
                                
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Email</label>
    <input name="email" type="email"  class="form-control " style="border-color: #01004C;" value="{{$data->email}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">No Handphone</label>
    <input name="no_hp" type="number"  class="form-control " style="border-color: #01004C;" value="{{$data->no_hp}}" oninput="validasiNumber(this)" />
</div>

<script>
function validasiNumber(input) {
    input.value = input.value.replace(/\./g, '');

    input.value = input.value.replace(/\D/g, '');

}
</script>

<div id="userSelect" style="display: none;">
                    <div class="form-group mb-4">
                        <label for="" class="form-label" style="color:black;">Report To</label>
                        <select name="selected_user" id="selected_user_a"  class="form-control" style="border-color: #01004C;"
                            aria-label=".form-select-lg example">
                            <option value="" selected disabled>-- Pilih Role --</option>
      @foreach ($user as $item)
                <option value="{{$item->id}}" {{ old('selected_user', $data->report_to) == $item->id ? 'selected' : '' }}> {{$item -> nama}}</option>
      @endforeach
                        </select>
                    </div>
                </div>

                <div id="userSelectmanager" style="display: none;">
                    <div class="form-group mb-4">
                        <label for="" class="form-label" style="color:black;">Report To</label>
                        <select name="selected_user" id="selected_user_b"  class="form-control" style="border-color: #01004C;"
                            aria-label=".form-select-lg example">
                            <option value="" selected disabled>-- Pilih Role --</option>
      @foreach ($manager as $item)
                <option value="{{$item->id}}" {{ old('selected_user', $data->report_to) == $item->id ? 'selected' : '' }}> {{$item -> nama}}</option>
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
  } else if (nohp == "") {
    alert ("No handphone tidak boleh kosong");
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


// Tambahkan logika untuk menentukan kapan menampilkan opsi "Report To"
function checkRoleAndDisplayUserSelect(role_id) {
    var userSelectDiv = document.getElementById("userSelect");
    var userSelectManagerDiv = document.getElementById("userSelectmanager");

    if (role_id == 5) {
        userSelectDiv.style.display = "block";
        userSelectManagerDiv.style.display = "none";   
    } else if (role_id == 4) {
        userSelectManagerDiv.style.display = "block";
        userSelectDiv.style.display = "none";
    } else if (role_id == 2) {
        userSelectManagerDiv.style.display = "block";
        userSelectDiv.style.display = "none";
    } else {
        userSelectDiv.style.display = "none";
        userSelectManagerDiv.style.display = "none";
        document.getElementById("selected_user_a").value = "";
        document.getElementById("selected_user_b").value = "";
    }
}

// Tambahkan event listener untuk memanggil fungsi di atas ketika peran dipilih berubah
document.getElementById("role_id").addEventListener("change", function () {
    var role_id = this.value;
    checkRoleAndDisplayUserSelect(role_id);
});


// Panggil fungsi di atas saat halaman dimuat untuk menyesuaikan tampilan awal berdasarkan nilai yang ada
var initialRoleId = document.getElementById("role_id").value;
checkRoleAndDisplayUserSelect(initialRoleId);

</script>


@endsection