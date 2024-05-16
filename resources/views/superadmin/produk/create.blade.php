@extends('layouts.superadmin.app')
@section('content')



<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Produk Baru
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="{{route('superadmin.produk.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Pilih Supplier</label>
    <select name="supplier_id" id="supplier_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Supplier --</option>
      @foreach ($supplier as $data)
                <option value="{{$data->id}}"> {{$data -> kode_supplier}} - {{$data -> nama_supplier}}</option>
      @endforeach
    </select>
</div>
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kode Produk</label>
    <input name="kode_produk" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Produk</label>
    <input name="nama_produk" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Harga Beli</label>
    <input name="harga_beli" type="number"  class="form-control " style="border-color: #01004C;"  value="0" oninput="validasiNumber(this)"/>
</div>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Harga Jual</label>
    <input name="harga_jual" type="number"  class="form-control " style="border-color: #01004C;" value="0" oninput="validasiNumber(this)"/>
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
let supplier = document.forms["saveform"]["supplier_id"].value;
let kodeproduk = document.forms["saveform"]["kode_produk"].value;
let namaproduk = document.forms["saveform"]["nama_produk"].value;
let hargabeli = document.forms["saveform"]["harga_beli"].value;
let hargajual = document.forms["saveform"]["harga_jual"].value;

if (supplier == "") {
        alert("Supplier harus dipilih");
        return false;
    } else if (kodeproduk == "") {
        alert("Kode produk tidak boleh kosong");
        return false;
    } else if (namaproduk == "") {
        alert("Nama produk tidak boleh kosong");
        return false;
    } else if (hargabeli == "") {
        alert("Harga beli tidak boleh kosong");
        return false;
    } else if (parseFloat(hargabeli) === 0) {
        alert("Harga beli tidak boleh 0");
        return false;
    } else if (hargajual == "") {
        alert("Harga jual tidak boleh kosong");
        return false;
    } else if (parseFloat(hargajual) === 0) {
        alert("Harga jual tidak boleh 0");
        return false;
    }

}

</script>

<script>
window.onload = function () {
    var inputFields = document.getElementsByTagName('input');
    for (var i = 0; i < inputFields.length; i++) {
        if (inputFields[i].type !== 'date' && inputFields[i].name !== '_token'  && inputFields[i].name !== 'harga_beli'  && inputFields[i].name !== 'harga_jual'  ) {
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