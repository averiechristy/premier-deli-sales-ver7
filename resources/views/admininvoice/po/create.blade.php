@extends('layouts.admininvoice.app')

@section('content')

<div class="container">

                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">

                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('admininvoice.po.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       


                                        <input type="hidden" name="selected_so" value="{{ json_encode($selectedSOs) }}">

                                        <input type="hidden" name="selected_quote" value="{{ json_encode($selectedQuotes) }}">

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
@foreach($mergedDetail as $key => $value)
    <div class="card mt-3">
        <div class="card-header" style="color:black;">
            <input type="text" value={{$key}} name="kode_supplier[{{$key}}][]" hidden>
            {{ $key }}
        </div>
        <div class="card-body" style="color:black;">
            <div class="form-group mb-4">
                <label for="po_number">PO Number</label>
                <input type="text" class="form-control" id="po_number" name="po_number[{{$key}}][]" value="{{ $value['po_number'] }}" readonly>
            </div>
            @foreach($value['items'] as $subValue)
                <div class="row product-field">
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Produk</label>
                            <select name="produk[{{$key}}][]" class="form-control product-select" readonly>
                                <option value="{{ $subValue['produk_id'] }}">{{ $subValue['kode_produk'] }} - {{ $subValue['nama_produk'] }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Harga</label>
                            <input type="number" name="price[{{$key}}][]" class="form-control" value="{{ $subValue['harga_beli'] }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Quantity</label>
                            <input type="number" name="qty[{{$key}}][]" class="form-control" value="{{ $subValue['quantity'] }}" readonly>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<script>
        // Menonaktifkan interaksi pengguna dengan elemen select produk
        document.getElementById('productselect{{$key}}').addEventListener('mousedown', function(e) {
            e.preventDefault();
            this.blur();
            return false;
        });
        document.getElementById('productselect{{$key}}').addEventListener('keydown', function(e) {
            e.preventDefault();
            return false;
        });
    </script>
</div>

<!-- <button type="button" class="btn btn-success mt-3" id="add-product-field">Add Product</button> -->

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
                    @foreach ($produk as $item)
                        <option value="{{$item->id}}">{{$item->kode_produk}} - {{$item->nama_produk}}</option>
                    @endforeach
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

var productInfo = {};
@foreach ($produk as $item)
    productInfo[{{$item->id}}] = {{$item->harga_jual}};
@endforeach

$(document).on('change', '.product-select', function() {
    var productId = $(this).val();
    var hargaProduk = productInfo[productId];

    // Isikan nilai ke input harga
    var $productField = $(this).closest('.product-field');
    $productField.find('input[name="price[]"]').val(hargaProduk);
});


            
        });

        // Remove Product Field
        $(document).on("click", ".remove-product-field", function() {
            $(this).closest(".product-field").remove();
        });

        // Initialize Select2 for Product Select
        $("#productselect").select2();

        var productInfo = {};

@foreach ($produk as $item)
    productInfo[{{$item->id}}] = {{$item->harga_jual}};
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
        $('#confirmModal').modal('show'); // Tampilkan modal
        return false; // Mengembalikan false untuk mencegah pengiriman form secara langsung
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
        // Menghitung jumlah field produk
        var productFields = document.querySelectorAll('.product-field');
        var numProducts = productFields.length;
        var nopo = document.forms["saveform"]["po_number"].value;
        if (nopo == "") {
            alert("No Purchase Order harus diisi");
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
window.addEventListener('load', function () {
    if (performance.navigation.type === 2) { // Detects if page is loaded from back/forward cache
        resetFields();
    }
});

window.addEventListener('popstate', function () {
    resetFields();
    window.location.reload(); // Ensure the page is refreshed
});

function resetFields() {
    var inputFields = document.getElementsByTagName('input');
    for (var i = 0; i < inputFields.length; i++) {
        if (inputFields[i].name !== '_token' && inputFields[i].name !== 'valid_date') {
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
}
</script>

@endsection