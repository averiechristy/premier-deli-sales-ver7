@extends('layouts.adminproduk.app')
@section('content')



<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Edit Produk 
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="/updateproduk/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kode Produk</label>
    <input name="kode_produk" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->kode_produk}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Produk</label>
    <input name="nama_produk" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_produk}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Harga Beli</label>
    <input name="harga_beli" type="number"  class="form-control " style="border-color: #01004C;"  value="{{$data->harga_beli}}" oninput="validasiNumber(this)"/>
</div>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Harga Jual</label>
    <input name="harga_jual" type="number"  class="form-control " style="border-color: #01004C;" value="{{$data->harga_jual}}" oninput="validasiNumber(this)"/>
</div>
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kode Supplier</label>
    <input name="kode_supplier" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->kode_supplier}}" />
</div>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Supplier</label>
    <input name="nama_supplier" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_supplier}}" />
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
function validasiNumber(input) {
    // Hapus karakter titik (.) dari nilai input
    input.value = input.value.replace(/\./g, '');

    // Pastikan hanya karakter angka yang diterima
    input.value = input.value.replace(/\D/g, '');
}
</script>
  
<script>
    function validateForm() {
    let kodeproduk = document.forms["saveform"]["kode_produk"].value;
    let namaproduk = document.forms["saveform"]["nama_produk"].value;
    let hargabeli = document.forms["saveform"]["harga_beli"].value;
    let hargajual = document.forms["saveform"]["harga_jual"].value;
    

    if(kodeproduk == "") {
        alert("Kode produk tidak boleh kosong");
    return false;
    }

    else if (namaproduk == "" ) {
    alert("Nama produk tidak boleh kosong");
    return false;
    } else if (hargabeli == ""){
        alert("Harga beli tidak boleh kosong");
    return false;
    }
    else if(hargajual == ""){
        alert("Harga jual tidak boleh kosong");
    return false;
    }

    }
</script>

@endsection