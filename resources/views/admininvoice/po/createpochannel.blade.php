@extends('layouts.admininvoice.app')

@section('content')

<div class="container">

                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">

                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('admininvoice.po.simpanpochannel')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

                     
                       
                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Pilih Supplier</label>
    <select name="supplier_id" id="supplier_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Supplier --</option>
      @foreach ($datasupplier as $data)
                <option value="{{$data->id}}"> {{$data->kode_supplier}} - {{$data -> nama_supplier}}</option>
      @endforeach
    </select>
</div>         



<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Pilih Channel</label>
    <select name="channel_id" id="channel_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Channel --</option>
      @foreach ($datachannel as $data)
                <option value="{{$data->id}}"> {{$data -> nama_channel}}</option>
      @endforeach
    </select>
</div>         

                        

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal PO</label>
    <input name="po_date" id="po_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>



<script>
    // Mendapatkan elemen input tanggal
    var orderDateInput = document.getElementById('po_date');

    // Mendapatkan tanggal hari ini
    var today = new Date();

    // Format tanggal hari ini menjadi YYYY-MM-DD untuk input tanggal
    var formattedDate = today.toISOString().substr(0, 10);

    // Mengatur nilai input tanggal ke tanggal hari ini
    orderDateInput.value = formattedDate;
</script>




<div id="product-fields">


    <div class="row product-field">
        <div class="col-md-4">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Produk</label>
                <!-- Berikan id yang unik untuk setiap elemen select -->
                <select name="product[]" class="form-control product-select" id="productselect" style="border-color: #01004C;max-width: 100%;" aria-label=".form-select-lg example" >
                    <option value="" selected disabled>-- Pilih Produk --</option>
                  
                </select>
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Harga</label>
                <input name="price[]" type="number" class="form-control" style="border-color: #01004C;" value=""  />
            </div>
        </div>


        <div class="col-md-2">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Quantity</label>
                <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value="" />
            </div>
        </div>
        <div class="col-md-1">
        <div class="form-group mb-4">
            <label for="" class="form-label" style="color:black;">Action</label>
            <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Remove</button>
            </div>
        </div>
    </div>
    

<script>
    $(document).ready(function() {
        // Panggil fungsi select2() untuk setiap elemen product-select di dalam perulangan
        $(".product-select").each(function(index) {
            // Gunakan id yang unik untuk setiap elemen select
            var selectId = "productselect" + index;
            $("#" + selectId).select2();
        });
    });
</script>



</div>

<button type="button" class="btn btn-success mt-3" id="add-product-field">Tambah Produk</button>

<script>
    $(document).ready(function() {

        
        // Add Product Field
        $("#add-product-field").click(function() {
            var productField = `
                <div id="product-fields">
    <div class="row product-field">
        <div class="col-md-4">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Produk</label>
                <select name="product[]" class="form-control product-select" style="border-color: #01004C;max-width: 100%;" aria-label=".form-select-lg example">
                    <option value="" selected disabled>-- Pilih Produk --</option>
                    
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Harga</label>
                <input name="price[]" type="number" class="form-control" style="border-color: #01004C;" value="" />
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Quantity</label>
                <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value="" />
            </div>
        </div>
        <div class="col-md-1">
            <label for="" class="form-label" style="color:black;">Action</label>
            <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Remove</button>
        </div>
    </div>
</div>`;
            $("#product-fields").append(productField);
            $(".product-select").select2();

            var supplierId = $('#supplier_id').val();
    fetchProductsBySupplier(supplierId, $('#product-fields').find('.product-field').last());

var productInfo = {};
@foreach ($produk as $item)
    productInfo[{{$item->id}}] = {{$item->harga_beli}};
@endforeach

$(document).on('change', '.product-select', function() {
    var productId = $(this).val();
    var hargaProduk = productInfo[productId];

    // Isikan nilai ke input harga
    var $productField = $(this).closest('.product-field');
    $productField.find('input[name="price[]"]').val(hargaProduk);
});


            
        });


        function fetchProductsBySupplier(supplierId, productField) {
    $.ajax({
        url: '/get-products-by-supplier', // Adjust URL according to your route
        type: 'GET',
        data: {
            supplier_id: supplierId
        },
        success: function(response) {
            productField.find('.product-select').empty();
            productField.find('.product-select').append('<option value="" disabled selected>-- Pilih Produk --</option>');
            $.each(response.products, function(index, product) {
                productField.find('.product-select').append('<option value="' + product.id + '">' + product.kode_produk + ' - ' + product.nama_produk + '</option>');
            });
        },
       
    });
}


        // Remove Product Field
        $(document).on("click", ".remove-product-field", function() {
            $(this).closest(".product-field").remove();
        });

        // Initialize Select2 for Product Select
        $("#productselect").select2();

        var productInfo = {};

@foreach ($produk as $item)
    productInfo[{{$item->id}}] = {{$item->harga_beli}};
@endforeach


    $('#productselect').change(function() {
        var productId = $(this).val();
        var hargaProduk = productInfo[productId];
       
        // Isikan nilai ke input harga
        var $productField = $(this).closest('.product-field');
    
    // Isikan nilai ke input harga
    $productField.find('input[name="price[]"]').val(hargaProduk);
    });

    
    });
</script>

<div class="form-group mb-4 mt-3">
<button type="button" class="btn btn-pd" onclick="confirmSubmit()" >Proses Purchase Order</button>
</div>
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Purchase Order</h5>
            </div>
            <div class="modal-body">
                Apakah Anda yakin akan memproses data? Silakan cek kembali sebelum proses data
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="submit" class="btn btn-primary" id="confirmButton">Ya</button>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmSubmit() {
        // Panggil fungsi untuk melakukan validasi form
        if (validateForm()) {
            // Jika validasi berhasil, tampilkan modal
            $('#confirmModal').modal('show');
        }
        // Mengembalikan false untuk mencegah pengiriman form secara langsung
        return false;
    }

    // Fungsi untuk menutup modal
    $('#confirmModal').on('hide.bs.modal', function () {
        // Mengatur nilai modalOpened menjadi false
        modalOpened = false;
    });

    // Fungsi untuk menangani klik tombol "Tidak"
    $('#confirmModal button[data-bs-dismiss="modal"]').on('click', function() {
        // Menutup modal ketika tombol "Tidak" ditekan
        $('#confirmModal').modal('hide');
    });
</script>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
      
  
            <script>
    function validateForm() {
        let supplier = document.forms["saveform"]["supplier_id"].value;
        let channel = document.forms["saveform"]["channel_id"].value;


        if(supplier == "") {
        alert("Supplier harus dipilih");
        closeModal()
    return false;
    }
       else if(channel == "") {
        alert("Channel harus dipilih");
        closeModal()
    return false;
    }
        // Menghitung jumlah field produk
        var productFields = document.querySelectorAll('.product-field');
        var numProducts = productFields.length;
        if (numProducts === 0) {
        alert('Minimal satu produk harus dipilih');
        closeModal();
        return false;
    }
        // Jika hanya ada satu produk
        if (numProducts === 1) {
            var productSelect = document.querySelector('select[name="product[]"]');
            var priceInput = document.querySelector('input[name="price[]"]');
            var quantityInput = document.querySelector('input[name="quantity[]"]');

            // Validasi produk
            if (productSelect.value === null || productSelect.value === '') {
                alert('Produk harus dipilih');
                closeModal()
                return false;
                
            }

            // Validasi harga
            if (priceInput.value === '' || isNaN(priceInput.value) || priceInput.value <= 0) {
                alert('Harga harus diisi ');
                closeModal()
                return false;
            }

            // Validasi quantity
            if (quantityInput.value === '' || isNaN(quantityInput.value) || quantityInput.value <= 0) {
                alert('Quantity harus diisi');
                closeModal()
                return false;
            }
        }

        // Jika produk lebih dari satu atau tidak ada validasi lainnya yang dibutuhkan, kembalikan true
        return true;
    }

    function closeModal() {
        // Tutup modal secara manual
        $('#confirmModal').modal('hide');
    }
</script>

<script>
    $(document).ready(function() {


// Event listener untuk perubahan pada select supplier pada form asli
$('#supplier_id').change(function() {
    var supplierId = $(this).val();
    fetchProductsBySupplier(supplierId, $('#product-fields'));
});

// Event listener untuk perubahan pada select supplier pada form yang muncul setelah menambahkan produk baru
$(document).on('change', '.product-field .supplier-select', function() {
    var supplierId = $(this).val();
    var productField = $(this).closest('.product-field');
    fetchProductsBySupplier(supplierId, productField);
});

// Fungsi untuk mengambil daftar produk berdasarkan supplier_id
function fetchProductsBySupplier(supplierId, productField) {
    $.ajax({
        url: '/get-products-by-supplier', // Ganti dengan URL yang benar sesuai dengan route Anda
        type: 'GET',
        data: {
            supplier_id: supplierId
        },
        success: function(response) {
            // Bersihkan opsi produk sebelum menambahkan yang baru
            productField.find('.product-select').empty();

            // Tambahkan opsi produk yang baru berdasarkan respons dari backend
            productField.find('.product-select').append('<option value="" disabled selected>-- Pilih Produk --</option>');

            $.each(response.products, function(index, product) {
                productField.find('.product-select').append('<option value="' + product.id + '">' + product.kode_produk + ' - ' + product.nama_produk + '</option>');
            });
        },
      
    });
}



    });
</script>

<script>
window.onload = function () {
    var inputFields = document.getElementsByTagName('input');
    for (var i = 0; i < inputFields.length; i++) {
        if (inputFields[i].name !== 'po_date' && inputFields[i].name !== '_token' && inputFields[i].name !== 'valid_date') {
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