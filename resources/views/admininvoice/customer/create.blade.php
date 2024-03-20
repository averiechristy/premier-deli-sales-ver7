@extends('layouts.admininvoice.app')
@section('content')






<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Customer Baru
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="{{route('admininvoice.customer.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Customer</label>
    <input name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Kategori</label>
    <select name="kategori" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Kategori --</option>
     
                <option value="Hotel"> Hotel</option>
                <option value="Restaurant"> Restaurant</option>
                <option value="Cafe"> Cafe</option>
    </select>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Sumber</label>
    <input name="sumber" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama PIC</label>
    <input name="nama_pic" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Jabatan PIC</label>
    <input name="jabatan_pic" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nomor Handphone</label>
    <input name="no_hp" type="number"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Email</label>
    <input name="email" type="email"  class="form-control " style="border-color: #01004C;" value="" />
</div>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="lokasi" type="text"  class="form-control " style="border-color: #01004C;" value=""></textarea>
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
            alert("Nama Customer harus diisi");
            return false;
        }
        if (kategori == "") {
            alert("Kategori harus dipilih");
            return false;
        }

        if (sumber == "") {
            alert("Sumber harus diisi");
            return false;
        }

        if (namaPIC == "") {
            alert("Nama PIC harus diisi");
            return false;
        }

        if (jabatanPIC == "") {
            alert("Jabatan PIC harus diisi");
            return false;
        }

        if (noHP == "") {
            alert("Nomor Handphone harus diisi");
            return false;
        }

        if (email == "") {
            alert("Email harus diisi");
            return false;
        }

        if (lokasi == "") {
            alert("Alamat harus diisi");
            return false;
        }

        // Jika semua validasi terpenuhi, form akan disubmit
        return true;
    }
</script>
@endsection