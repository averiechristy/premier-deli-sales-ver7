@extends('layouts.superadmin.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Supplier
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform"  action="/superadminupdatesupplier/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                      
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kode Supplier</label>
    <input name="kode_supplier" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->kode_supplier}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Supplier</label>
    <input name="nama_supplier" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_supplier}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Alamat Supplier</label>
    <textarea name="alamat_supplier" type="text"  class="form-control " style="border-color: #01004C;" value=""> {{$data->alamat_supplier}}</textarea>
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

        let kodesupplier = document.forms["saveform"]["kode_supplier"].value;
        let namasupplier = document.forms["saveform"]["nama_supplier"].value;
        let alamatsupplier = document.forms["saveform"]["alamat_supplier"].value;
     

        if(kodesupplier == "") {
        alert("Kode supplier tidak boleh kosong");
    return false;
    }
    else if (kodesupplier.length != 3) {
            alert("Kode supplier harus terdiri dari 3 karakter");
            return false;
        }
    else if(namasupplier == "") {
        alert("Nama supplier tidak boleh kosong");
    return false;
    }

    else if(alamatsupplier == "") {
        alert("Alamat supplier tidak boleh kosong");
    return false;
    }


     }
</script>


@endsection