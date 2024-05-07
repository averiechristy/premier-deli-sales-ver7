@extends('layouts.superadmin.app')

@section('content')



<div class="container">
       
        <div class="right-column">
            <!-- Tempatkan form input di sini -->
            <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Buat Sales Order
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="{{route('superadmin.so.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       



    <input hidden name="rfo_id" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->id}}" />



   



                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal SO</label>
    <input name="so_date" id="so_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>



<script>
    // Mendapatkan elemen input tanggal
    var orderDateInput = document.getElementById('so_date');

    // Mendapatkan tanggal hari ini
    var today = new Date();

    // Format tanggal hari ini menjadi YYYY-MM-DD untuk input tanggal
    var formattedDate = today.toISOString().substr(0, 10);

    // Mengatur nilai input tanggal ke tanggal hari ini
    orderDateInput.value = formattedDate;
</script>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Customer</label>
    <select name="cust_id" id="customerSelect" class="form-control" style="border-color: #01004C; max-width: 100%;" aria-label=".form-select-lg example" readonly>
        <option value="" selected disabled>-- Pilih Customer --</option>
        @foreach ($customer as $item)
            <option value="{{$item->id}}" {{ old('cust_id', $data->cust_id) == $item->id ? 'selected' : '' }} data-nama="{{$item->nama_customer}}" data-alamat="{{$item->alamat}}">{{$item->nama_customer}}</option>
        @endforeach
    </select>
</div>


<script>
    // Menonaktifkan interaksi pengguna dengan elemen select
    document.getElementById('customerSelect').addEventListener('mousedown', function(e) {
        e.preventDefault();
        this.blur();
        return false;
    });
    document.getElementById('customerSelect').addEventListener('keydown', function(e) {
        e.preventDefault();
        return false;
    });
</script>



<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;" hidden>Nama Customer</label>
    <input hidden name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_customer}}" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="alamat" class="form-control" style="border-color: #01004C;" rows="4" >{{$data->alamat}}</textarea>
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Pengiriman</label>
    <input name="shipping_date" id="shipping_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="{{$data->shipping_date}}" />
</div>

<div id="product-fields">
@foreach ($rfoGrouped as $kodeSupplier => $detailRFOs)
   
       
            <h5 style="display:none;">Supplier: {{ $kodeSupplier }}</h5>
            <input type="text" value="{{ $orderNumbers[$kodeSupplier] }}" name="order_number[{{$kodeSupplier}}][]" hidden>
            <input type="text" value={{$kodeSupplier}} name="kode_supplier[{{$kodeSupplier}}][]" hidden>
           
        
        @foreach ($detailRFOs as $index => $detaildata)
            <div class="row product-field">
                <div class="col-md-4">
                <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Produk</label>
                            <select name="product[{{$kodeSupplier}}][]" class="form-control product-select" readonly>
                                <option value="" selected disabled>-- Pilih Produk --</option>
                                @foreach ($produk as $item)
                                    <option value="{{$item->id}}" {{ old('product[]', $detaildata->product_id) == $item->id ? 'selected' : '' }} >{{$item->kode_produk}} - {{$item->nama_produk}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
        
                <div class="col-md-3">
                <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Harga</label>
                            <input name="price[{{$kodeSupplier}}][]" type="number" class="form-control" style="border-color: #01004C;" value="{{$detaildata->harga_jual}}" readonly/>
                        </div>
                </div>
                
                <div class="col-md-2">
                <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Quantity</label>
                            <input name="quantity[{{$kodeSupplier}}][]" type="number" class="form-control" style="border-color: #01004C;" value="{{$detaildata->qty}}" readonly />
                        </div>
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label" style="color:black; display:none;">Action</label>
                    <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1" style="display:none;" >Remove</button>
                </div>
            </div>
            <script>
    // Menonaktifkan interaksi pengguna dengan elemen select
    $(document).ready(function() {
    // Gunakan event delegation untuk menangkap event mousedown pada elemen parent dengan class '.product-field'
    $(document).on('mousedown', '.product-field .product-select', function(e) {
        e.preventDefault();
        $(this).blur();
        return false;
    });

    $(document).on('keydown', '.product-field .product-select', function(e) {
        e.preventDefault();
        return false;
    });
});

</script>
        @endforeach
    @endforeach


<!-- <script>
    $(document).ready(function() {
        // Panggil fungsi select2() untuk setiap elemen product-select di dalam perulangan
        $(".product-select").each(function(index) {
            // Gunakan id yang unik untuk setiap elemen select
            var selectId = "productselect" + index;
            $("#" + selectId).select2();
        });
    });
</script> -->




</div>



<button type="button" class="btn btn-success mt-3" id="add-product-field" style="display:none;">Add Product</button>

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
                <input name="price[]" type="number" class="form-control" style="border-color: #01004C;" value="" readonly/>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Quantity</label>
                <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value="" />
            </div>
        </div>
        <div class="col-md-2">
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

<div class="form-group mb-4 mt-4">
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="discpersen" value="persen">
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio1">Discount dalam %</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="discrp" value="amount">
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio2">Discount dalam Rp</label>
                            </div>
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Discount</label>
    <input name="discount" type="number"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">PPN (dalam %)</label>
    <input name="ppn" type="number"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Down Payment</label>
    <input name="pembayaran" type="number"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4 mt-3">
<button type="button" class="btn btn-pd" onclick="confirmSubmit()" >Proses Sales Order</button>
</div>
                                            </div>
                                            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Sales Order</h5>
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


    <script>
    function validateForm() {
        var alamat = document.forms["saveform"]["alamat"].value;
        if (alamat == "") {
            alert("Alamat harus diisi");
            closeModal();
            return false;
        }
        var products = document.getElementsByName('product[]');
        var quantities = document.getElementsByName('quantity[]');
        var isValidProduct = false;
        for (var i = 0; i < products.length; i++) {
            if (products[i].value != "") {
                isValidProduct = true;
                // Validasi jumlah produk
                if (quantities[i].value == "") {
                    alert("Harap isi jumlah untuk setiap produk yang dipilih");
                    closeModal();
                    return false;
                }
            }
        }
        
        // Validasi radiobutton
        var radioValue = document.querySelector('input[name="inlineRadioOptions"]:checked');
        if (!radioValue) {
            alert("Harap pilih salah satu opsi diskon");
            closeModal();
            return false;
        }

        // Validasi discount
        var discount = document.forms["saveform"]["discount"].value;
        if (discount == "") {
            alert("Discount harus diisi");
            closeModal();
            return false;
        }

        // Validasi PPN
        var ppn = document.forms["saveform"]["ppn"].value;
        if (ppn == "") {
            alert("PPN harus diisi");
            closeModal();
            return false;
        }



        return true;
    }

    function closeModal() {
        // Tutup modal secara manual
        $('#confirmModal').modal('hide');
    }
</script>

@endsection