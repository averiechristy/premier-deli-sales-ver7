@extends('layouts.superadmin.app')

@section('content')


<div class="container">
        
    
            <!-- Tempatkan form input di sini -->
            <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Buat Invoice
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="{{route('superadmin.invoice.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       



    <input hidden name="so_id" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->id}}" />



                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">No Sales Order</label>
    <input name="invoice_no" type="text" class="form-control" style="border-color: #01004C; width:50%;" value="{{ $invoicenumber }}" readonly />
</div>




                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Invoice</label>
    <input name="invoice_date" id="invoice_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value=""  />
</div>

<script>
    // Mendapatkan elemen input tanggal
    var orderDateInput = document.getElementById('invoice_date');

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
    <label for="" class="form-label" style="color:black;">Alamat</label>
    <input name="alamat" type="text" class="form-control" style="border-color: #01004C;" value="{{ $data->alamat }}" readonly />
</div>




<div id="product-fields">
    
@foreach ($so as $index => $detaildata)
    <div class="row product-field">
        <div class="col-md-4">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Produk</label>
                <!-- Berikan id yang unik untuk setiap elemen select -->
                <select name="product[]" class="form-control product-select" id="productselect{{$index}}" style="border-color: #01004C;max-width: 100%;" aria-label=".form-select-lg example"readonly >
                    <option value="" selected disabled>-- Pilih Produk --</option>
                    @foreach ($produk as $item)
                        <option value="{{$item->id}}" {{ old('product[]', $detaildata->product_id) == $item->id ? 'selected' : '' }} >{{$item->kode_produk}} - {{$item->nama_produk}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Harga Unit</label>
                <input name="price[]" type="number" class="form-control" style="border-color: #01004C;" value="{{$detaildata->so_price}}" readonly />
            </div>
        </div>


        <div class="col-md-2">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Quantity</label>
                <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value="{{$detaildata->qty}}" readonly />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Total Harga</label>
                <input name="totalprice[]" type="number" class="form-control" style="border-color: #01004C;" value="{{$detaildata->total_price}}" readonly />
            </div>
        </div>
       
    </div>
    <script>
        // Menonaktifkan interaksi pengguna dengan elemen select produk
        document.getElementById('productselect{{$index}}').addEventListener('mousedown', function(e) {
            e.preventDefault();
            this.blur();
            return false;
        });
        document.getElementById('productselect{{$index}}').addEventListener('keydown', function(e) {
            e.preventDefault();
            return false;
        });
    </script>
@endforeach
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Sub Total</label>
    <input name="subtotal" type="number"  class="form-control " style="border-color: #01004C;" value="{{ $subtotal }}" readonly />
</div>

<input hidden name="is_persen" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->is_persen}}" />


@if ($tipe == 'persen')
       
<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Discount (dalam %)</label>
        <input name="discount" type="number" class="form-control" style="border-color: #01004C;" value="{{ $discountasli }}" readonly />
</div>
        @elseif ($tipe == 'amount')

        <div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Discount</label>
        <input name="discount" type="number" class="form-control" style="border-color: #01004C;" value="{{ $discountasli }}" readonly />
</div>
        @endif

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">PPN (dalam %)</label>
    <input name="ppn" type="number"  class="form-control " style="border-color: #01004C;" value="{{ $data->ppn }}" readonly />
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Total</label>
    <input name="total" type="number"  class="form-control " style="border-color: #01004C;" value="{{  $total }}" readonly/>
</div>

<div class="form-group mb-4 mt-3">
<button type="button" class="btn btn-pd" onclick="confirmSubmit()" >Proses Invoice</button>
</div>
                                            </div>

                                            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Invoice</h5>
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

    <script>
    function validateForm() {
        var validdate = document.forms["saveform"]["invoice_date"].value;

        if (validdate == "") {
            alert("Tanggal Invoice harus dipilih");
            closeModal();
            return false;
        }

        var customerId = document.forms["saveform"]["cust_id"].value;

        // Validasi Customer ID
        if (customerId == "") {
            alert("Customer harus dipilih");
            closeModal();
            return false;
        }

        var alamat = document.forms["saveform"]["alamat"].value;
        if (alamat == "") {
            alert("Alamat harus diisi");
            closeModal();
            return false;
        }

        var namapenerima = document.forms["saveform"]["nama_penerima"].value;

        if (namapenerima == "") {
            alert("Nama PIC harus diisi");
            closeModal();
            return false;
        }
        // Mendapatkan nilai dari input Tanggal Order
   // Mendapatkan nilai dari input Tanggal Order
var orderDate = document.forms["saveform"]["quote_date"].value;

// Mendapatkan nilai dari input Tanggal Pengiriman
var shippingDate = document.forms["saveform"]["shipping_date"].value;

// Mendapatkan nilai dari input Tanggal Pembayaran
var paymentDate = document.forms["saveform"]["payment_date"].value;

        // Validasi Tanggal Order
        if (orderDate == "") {
            alert("Tanggal Order harus diisi");
            closeModal();
            return false;
        }

        // Validasi Tanggal Pengiriman
        if (shippingDate == "") {
            alert("Tanggal Pengiriman harus diisi");
            closeModal();
            return false;
        }

        // Validasi Tanggal Pembayaran
        if (paymentDate == "") {
            alert("Tanggal Pembayaran harus diisi");
            closeModal();
            return false;
        }

        if(shippingDate < paymentDate) {
            alert("Tanggal pengiriman tidak boleh kurang dari tanggal pembayaran");
            closeModal();
            return false;
        }

        var products = document.getElementsByName('product[]');
        var quantities = document.getElementsByName('quantity[]');
        var isValidProduct = false;
        var selectedProducts = [];
        for (var i = 0; i < products.length; i++) {
            if (products[i].value != "") {
                isValidProduct = true;
                // Validasi jumlah produk
                if (quantities[i].value == "") {
                    alert("Harap isi jumlah untuk setiap produk yang dipilih");
                    closeModal();
                    return false;
                }

                if (selectedProducts.includes(products[i].value)) {
                alert("Produk yang sama tidak boleh dipilih lebih dari satu kali.");
                closeModal();
                return false;
            } else {
                selectedProducts.push(products[i].value);
            }
            }
        }
        if (!isValidProduct) {
            alert("Minimal satu produk harus dipilih");
            closeModal();
            return false;
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

        // Validasi jumlah produk minimal satu
     

        // Tutup modal secara langsung
        // closeModal();

        // Jika semua validasi berhasil, return true
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