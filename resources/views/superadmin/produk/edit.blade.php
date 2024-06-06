@extends('layouts.superadmin.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Edit Produk 
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="/superadminupdateproduk/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Pilih Supplier</label>
    <select name="supplier_id" id="supplier_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Supplier --</option>
        @foreach ($supplier as $supplier)
                <option value="{{$supplier->id}}"{{ old('supplier_id', $data->supplier_id) == $supplier->id ? 'selected' : '' }}> {{$supplier -> kode_supplier}} - {{$supplier -> nama_supplier}}</option>
      @endforeach
    </select>
</div>

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
                    <label for="" class="form-label" style="color:black;">Gambar Produk</label>
                    <input name="gambar_produk" type="file" id="gambar_produk"  style="border-color: #01004C;" accept=".jpg, .jpeg, .png" onchange="validateImage(this)" />
                    <input type="hidden" name="resized_image" id="resized_image" />

                    <div id="currentImagePreview" style="margin-top: 10px;">
                        <p>Gambar Lama:</p>
                        <img src="{{asset('images/produk/'.$data->gambar_produk)}}" alt="Current Image" style="max-width: 100px; max-height: 100px;" />
                    </div>
                    
            <div id="newImagePreview" style="margin-top: 10px; display: none;">
             <p>Gambar Baru:</p>
             <img id="previewImg" src="" alt="New Image" style="max-width: 100px; max-height: 100px;" />
            </div>

</div>

<!-- <div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kode Supplier</label>
    <input name="kode_supplier" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->kode_supplier}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Supplier</label>
    <input name="nama_supplier" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_supplier}}" />
</div> -->


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

function validateForm() {
    let supplier = document.forms["saveform"]["supplier_id"].value;
    let kodeproduk = document.forms["saveform"]["kode_produk"].value;
    let namaproduk = document.forms["saveform"]["nama_produk"].value;
    let hargabeli = document.forms["saveform"]["harga_beli"].value;
    let hargajual = document.forms["saveform"]["harga_jual"].value;

    if (supplier == "") {
        alert("Supplier harus diisi.");
        return false;
    } else if (kodeproduk == "") {
        alert("Kode produk harus diisi.");
        return false;
    } else if (namaproduk == "") {
        alert("Nama produk harus diisi.");
        return false;
    } else if (hargabeli == "") {
        alert("Harga beli harus diisi.");
        return false;
    } else if (parseFloat(hargabeli) === 0) {
        alert("Harga beli tidak boleh 0.");
        return false;
    } else if (hargajual == "") {
        alert("Harga jual harus diisi.");
        return false;
    } else if (parseFloat(hargajual) === 0) {
        alert("Harga jual tidak boleh 0.");
        return false;
    }
}

function validateImage(input) {
    if (input.files && input.files[0]) {
        let file = input.files[0];
        if (file.size > 1048576) {
            alert("Ukuran gambar produk tidak boleh lebih dari 1 MB.");
            input.value = '';
        } else if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            alert("Tipe file gambar produk harus JPG, JPEG, atau PNG.");
            input.value = '';
        } else {
            resizeImage(file);
            previewImage(file);
        }
    }
}

function resizeImage(file) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (event) {
        const img = new Image();
        img.src = event.target.result;
        img.onload = function () {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            
            
            const width = 5 * 37.7953; 
            const height = 5 * 37.7953; 
            
            canvas.width = width;
            canvas.height = height;
            context.drawImage(img, 0, 0, width, height);
            const resizedDataUrl = canvas.toDataURL('image/jpeg');

            document.getElementById('resized_image').value = resizedDataUrl;
        };
    };
}

function previewImage(file) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (event) {
        const previewImg = document.getElementById('previewImg');
        previewImg.src = event.target.result;
        previewImg.style.display = 'block';
        document.getElementById('newImagePreview').style.display = 'block';
    };
}


</script>
@endsection