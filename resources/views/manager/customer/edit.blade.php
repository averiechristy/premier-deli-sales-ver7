@extends('layouts.manager.app')
@section('content')


<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Edit Customer 
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="/managerupdatecustomer/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Customer</label>
    <input name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_customer}}" />
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Kategori</label>
    <select name="kategori" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Kategori --</option>
     
        @foreach ($kategori as $item)
                <option value="{{$item->id}}"{{ old('kategori_id', $data->kategori_id) == $item->id ? 'selected' : '' }}> {{$item -> kategori}}</option>
      @endforeach
    </select>
</div>



<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Sumber</label>
    <select name="sumber" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Sumber --</option>
     
        @foreach ($sumber as $item)
                <option value="{{$item->id}}"{{ old('sumber_id', $data->sumber_id) == $item->id ? 'selected' : '' }}> {{$item -> sumber}}</option>
      @endforeach
    </select>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama PIC</label>
    <input name="nama_pic" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data ->nama_pic}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Jabatan PIC</label>
    <input name="jabatan_pic" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data -> jabatan_pic}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nomor Handphone</label>
    <input name="no_hp" type="number"  class="form-control " style="border-color: #01004C;" value="{{$data -> no_hp}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Email</label>
    <input name="email" type="email"  class="form-control " style="border-color: #01004C;" value="{{$data->email}}" />
</div>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="lokasi" type="text"  class="form-control " style="border-color: #01004C;" value="" >{{$data -> lokasi}}</textarea>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Produk yang digunakan sebelumnya</label>
    <textarea name="produk_sebelumnya" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->produk_sebelumnya}}">{{$data->produk_sebelumnya}}</textarea>
</div>
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
        let namaCustomer = document.forms["saveform"]["nama_customer"].value;
        let kategori = document.forms["saveform"]["kategori"].value;
        let sumber = document.forms["saveform"]["sumber"].value;
        let namaPIC = document.forms["saveform"]["nama_pic"].value;
        let jabatanPIC = document.forms["saveform"]["jabatan_pic"].value;
        let noHP = document.forms["saveform"]["no_hp"].value;
        let email = document.forms["saveform"]["email"].value;
        let lokasi = document.forms["saveform"]["lokasi"].value;

       if (namaCustomer == "") {
            alert("Nama customer harus diisi.");
            return false;
        }
        if (kategori == "") {
            alert("Kategori harus diisi.");
            return false;
        }

        if (sumber == "") {
            alert("Sumber harus diisi.");
            return false;
        }

        if (namaPIC == "") {
            alert("Nama PIC harus diisi.");
            return false;
        }

        if (jabatanPIC == "") {
            alert("Jabatan PIC harus diisi.");
            return false;
        }

        if (noHP == "") {
            alert("No handphone harus diisi.");
            return false;
        }

        if (email == "") {
            alert("Email harus diisi.");
            return false;
        }

        if (lokasi == "") {
            alert("Alamat harus diisi.");
            return false;
        }

        // Jika semua validasi terpenuhi, form akan disubmit
        return true;
    }
</script>

@endsection