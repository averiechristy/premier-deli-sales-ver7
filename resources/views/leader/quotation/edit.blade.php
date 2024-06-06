@extends('layouts.leader.app')

@section('content')

<div class="container">                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                       Edit Quotation
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="/leaderupdatequote/{{$quotation->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf           
                        
                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">No Quote</label>
    <input name="no_quote" type="text" class="form-control" style="border-color: #01004C; width:50%;" value="{{$quotation -> no_quote}}" readonly/>
</div>                              
                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Order</label>
    <input name="quote_date" id="quote_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="{{$quotation -> quote_date}}" />
</div>
<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Valid</label>
    <input name="valid_date" id="valid_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="{{$quotation -> valid_date}}" />
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('quote_date');
            dateInput.addEventListener('click', function() {
                this.showPicker();
            });
        });
    </script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('valid_date');
            dateInput.addEventListener('click', function() {
                this.showPicker();
            });
        });
    </script>
<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Customer</label>
    <select name="customer_id" id="customerSelect" class="form-control customer-select" style="border-color: #01004C; max-width: 100%;" aria-label=".form-select-lg example">
        <option value="" selected disabled>-- Pilih Customer --</option>
        @foreach ($customer as $item)
        <option value="{{$item->id}}" data-nama="{{$item->nama_customer}}" data-alamat="{{$item->lokasi}}" data-pic="{{$item->nama_pic}}" {{ old('cust_id', $quotation->cust_id) == $item->id ? 'selected' : '' }}>{{$item->nama_customer}}</option>
        @endforeach
    </select>
</div>      




<div class="form-group mb-4">
    <label hidden for="" class="form-label" style="color:black;" >Nama Customer</label>
    <input  hidden name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="{{$quotation->nama_customer}}" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="alamat" class="form-control" style="border-color: #01004C;" rows="4" >{{$quotation -> alamat}}</textarea>
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;" >Nama PIC</label>
    <input  name="nama_penerima" type="text"  class="form-control " style="border-color: #01004C;" value="{{$quotation -> nama_pic}}" />
</div>

<script>
    $(document).ready(function() {
        $('#customerSelect').select2();
    });

    $(document).ready(function() {
    $('#customerSelect').change(function() {
        var selectedOption = $(this).find('option:selected');
        var namaCustomer = selectedOption.data('nama');
        var alamatCustomer = selectedOption.data('alamat');
        var namaPIC = selectedOption.data('pic');

        $('input[name="nama_customer"]').val(namaCustomer);
        $('textarea[name="alamat"]').val(alamatCustomer);
        $('input[name="nama_penerima"]').val(namaPIC);
    });
});


</script>
<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Pengiriman</label>
    <input name="shipping_date" id="shipping_date"  type="date" class="form-control" style="border-color: #01004C; width:50%;" value="{{$quotation->shipping_date}}" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Pembayaran</label>
    <input name="payment_date" id="payment_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="{{$quotation->payment_date}}" />
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('shipping_date');
            dateInput.addEventListener('click', function() {
                this.showPicker();
            });
        });
    </script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('payment_date');
            dateInput.addEventListener('click', function() {
                this.showPicker();
            });
        });
    </script>

<div id="product-fields">
    @foreach ($detailquote as $detail)
    <div class="row product-field">
        <div class="col-md-6">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Produk</label>
                <select name="product[]" class="form-control product-select" style="border-color: #01004C;max-width: 100%;" aria-label=".form-select-lg example">
                    <option value="" selected disabled>-- Pilih Produk --</option>
                    @foreach ($produk as $item)
            <option value="{{$item->id}}" {{ old('product_id', $detail->product_id) == $item->id ? 'selected' : '' }}>{{$item->kode_produk}} - {{$item->nama_produk}}</option>
        @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group mb-4">
                <label for="" class="form-label" style="color:black;">Quantity</label>
                <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value="{{$detail -> qty}}"  oninput="validasiNumber(this)"/>
            </div>
        </div>
        <div class="col-md-1">
        <label for="" class="form-label" style="color:black;">Action</label>
            <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Hapus</button>
        </div>
    </div>
    @endforeach
</div>

<button type="button" class="btn btn-success mt-3" id="add-product-field">Tambah Produk</button>

<!-- JavaScript for Dynamically Adding/Removing Product Fields -->
<script>
    $(document).ready(function() {
        // Add Product Field
        $("#add-product-field").click(function() {
            var productField = `
                <div class="row product-field">
                    <div class="col-md-6">
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
                    <div class="col-md-5">
                        <div class="form-group mb-4">
                            <label for="" class="form-label" style="color:black;">Quantity</label>
                            <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value=""  oninput="validasiNumber(this)"/>
                        </div>
                    </div>
                    <div class="col-md-1">
                    <label for="" class="form-label" style="color:black;">Action</label>
                        <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Hapus</button>
                    </div>
                </div>`;
            $("#product-fields").append(productField);
            $(".product-select").select2(); // Initialize Select2 for new Product Select
        });

        // Remove Product Field
        $(document).on("click", ".remove-product-field", function() {
            $(this).closest(".product-field").remove();
        });

        // Initialize Select2 for Product Select
        $(".product-select").select2();
    });
</script>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Biaya Pengiriman</label>
    <input name="biaya_pengiriman" type="number"  class="form-control " style="border-color: #01004C;" value="{{$quotation->biaya_pengiriman}}" oninput="validasiNumber(this)" />
</div>

<div class="form-group mb-4 mt-4">
<label for="" class="form-label" style="color:black;">Opsi Discount</label>
<br>
                           <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="discpersen" value="persen"  {{ $quotation->is_persen == 'persen' ? 'checked' : '' }}>
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio1">Discount dalam %</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="discrp" value="amount"{{ $quotation->is_persen == 'amount' ? 'checked' : '' }}>
                              <label class="form-check-label"  style="margin-left: 5px;" for="inlineRadio2">Discount dalam Rp</label>
                            </div>
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">Discount</label>
    <input name="discount" type="number"  class="form-control " style="border-color: #01004C;" value="{{$quotation->discount}}"  oninput="validasiNumber(this)"/>
</div>

<div class="form-group mb-4 mt-3">
        <label for="" class="form-label" style="color:black;">PPN (dalam %)</label>
    <input name="ppn" type="number"  class="form-control " style="border-color: #01004C;" value="{{$quotation->ppn}}" oninput="validasiNumber(this)" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Catatan</label>
    <select name="catatan_id" id="catatan_id" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Catatan --</option>
        @foreach ($catatan as $data)
            <option value="{{$data->id}}" data-isi_catatan="{{$data->isi_catatan}}" {{ old('catatan_id', $quotation->catatan_id) == $data->id ? 'selected' : '' }}> {{$data->judul_catatan}}</option>
        @endforeach
    </select>
</div>       

<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Isi Catatan</label>
  <textarea class="form-control" name="isi_catatan" id="isi_catatan" rows="5">{{$quotation->catatan}}</textarea>
</div>

<script>
$(document).ready(function() {
    $('#catatan_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        var isi = selectedOption.data('isi_catatan');
        $('textarea[name="isi_catatan"]').val(isi);
        $('textarea[name="isi_catatan"]').prop('disabled', false);
    });
});
</script>


<div class="form-group mb-4 mt-3">
<button type="button" class="btn btn-pd" onclick="confirmSubmit()" >Proses Quotation</button>
</div>
                                            </div>

                                              <!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Quotation</h5>
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
function validasiNumber(input) {
    // Hapus karakter titik (.) dari nilai input
    input.value = input.value.replace(/\./g, '');

    // Pastikan hanya karakter angka yang diterima
    input.value = input.value.replace(/\D/g, '');
}
</script>

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
        var validdate = document.forms["saveform"]["valid_date"].value;

        if (validdate == "") {
            alert("Tanggal valid harus dipilih");
            closeModal();
            return false;
        }

        var customerId = document.forms["saveform"]["customer_id"].value;

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
            alert("Nama Penerima harus diisi");
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
        if (!isValidProduct) {
            alert("Minimal satu produk harus dipilih");
            closeModal();
            return false;
        }

        var biayakirim = document.forms["saveform"]["biaya_pengiriman"].value;
        if (biayakirim == "") {
            alert("Biaya pengiriman harus diisi");
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


@endsection