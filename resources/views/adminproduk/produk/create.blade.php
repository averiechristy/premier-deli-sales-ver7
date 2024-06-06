@extends('layouts.adminproduk.app')
@section('content')

<div class="container">
    <div class="card mt-3">
        <div class="card-header" style="color:black;">
            Tambahkan Produk
        </div>
        <div class="card-body">
            <form name="saveform" action="{{route('adminproduk.produk.simpan')}}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
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
                    <input name="kode_produk" type="text" class="form-control" style="border-color: #01004C;" value="" />
                </div>
                <div class="form-group mb-4">
                    <label for="" class="form-label" style="color:black;">Nama Produk</label>
                    <input name="nama_produk" type="text" class="form-control" style="border-color: #01004C;" value="" />
                </div>
                <div class="form-group mb-4">
                    <label for="" class="form-label" style="color:black;">Harga Beli</label>
                    <input name="harga_beli" type="number" class="form-control" style="border-color: #01004C;" value="0" oninput="validasiNumber(this)"/>
                </div>
                <div class="form-group mb-4">
                    <label for="" class="form-label" style="color:black;">Harga Jual</label>
                    <input name="harga_jual" type="number" class="form-control" style="border-color: #01004C;" value="0" oninput="validasiNumber(this)"/>
                </div>
                <div class="form-group mb-4">
                    <label for="" class="form-label" style="color:black;">Gambar Produk</label>
                    <input name="gambar_produk" type="file" id="gambar_produk" style="border-color: #01004C;" accept=".jpg, .jpeg, .png" onchange="validateImage(this)" />
                    <input type="hidden" name="resized_image" id="resized_image" />
                    <div id="imagePreview" style="margin-top: 10px;">
                        <img id="previewImg" src="" alt="Preview Image" style="max-width: 100px; max-height: 100px; display: none;"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-pd" style="">Simpan</button>
            </form>
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
    let gambarProduk = document.forms["saveform"]["gambar_produk"].files[0];

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
            
            // Set the dimensions to 5 cm x 5 cm (assuming 96 dpi)
            const width = 5 * 37.7953; // 5 cm to pixels
            const height = 5 * 37.7953; // 5 cm to pixels
            
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
    };
}

window.onload = function () {
    var inputFields = document.getElementsByTagName('input');
    for (var i = 0; i < inputFields.length; i++) {
        if (inputFields[i].type !== 'date' && inputFields[i].name !== '_token' && inputFields[i].name !== 'harga_beli' && inputFields[i].name !== 'harga_jual') {
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
