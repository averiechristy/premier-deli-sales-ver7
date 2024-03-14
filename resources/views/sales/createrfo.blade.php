@extends('layouts.sales.app')

@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                       Request Order
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('sales.simpanrfo')}}" method="post" onsubmit="return validateForm()">
                                        @csrf           

                                       
                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">No RFO</label>
    <input name="no_rfo" type="text" class="form-control" style="border-color: #01004C; width:50%;" value="{{$orderNumber}}" />
</div>                              
                                        <div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Order</label>
    <input name="order_date" id="order_date" type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>

<script>
    // Mendapatkan elemen input tanggal
    var orderDateInput = document.getElementById('order_date');

    // Mendapatkan tanggal hari ini
    var today = new Date();

    // Format tanggal hari ini menjadi YYYY-MM-DD untuk input tanggal
    var formattedDate = today.toISOString().substr(0, 10);

    // Mengatur nilai input tanggal ke tanggal hari ini
    orderDateInput.value = formattedDate;
</script>



<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Customer</label>
    <select name="customer_id" id="customerSelect" class="form-control" style="border-color: #01004C; max-width: 100%;" aria-label=".form-select-lg example">
        <option value="" selected disabled>-- Pilih Customer --</option>
        @foreach ($customer as $item)
            <option value="{{$item->id}}" data-nama="{{$item->nama_customer}}" data-alamat="{{$item->alamat}}">{{$item->nama_customer}}</option>
        @endforeach
    </select>
</div>


<script>
    $(document).ready(function() {
        $('#customerSelect').select2();

        // Simpan informasi nama dan alamat dalam objek
        var customerInfo = {};

        @foreach ($customer as $item)
            customerInfo[{{$item->id}}] = {
                nama: "{{$item->nama_customer}}",
                alamat: "{{$item->lokasi}}"
            };
        @endforeach

        // Ketika pilihan customer diubah
        $('#customerSelect').change(function() {
            var customerId = $(this).val();
            var namaCustomer = customerInfo[customerId].nama;
            var alamatCustomer = customerInfo[customerId].alamat;
            
            // Isikan nilai ke input nama_customer dan alamat
            $('input[name="nama_customer"]').val(namaCustomer);
            $('textarea[name="alamat"]').val(alamatCustomer);
        });
    });
</script>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;" hidden>Nama Customer</label>
    <input hidden name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="alamat" class="form-control" style="border-color: #01004C;" rows="4" ></textarea>
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;" >Nama Penerima</label>
    <input  name="nama_penerima" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Pengiriman</label>
    <input name="shipping_date"  type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>

<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Tanggal Pembayaran</label>
    <input name="payment_date"  type="date" class="form-control" style="border-color: #01004C; width:50%;" value="" />
</div>


<!-- Product and Quantity Fields -->
<div id="product-fields">
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
                <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value="" />
            </div>
        </div>
        <div class="col-md-1">
        <label for="" class="form-label" style="color:black;">Action</label>
            <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Remove</button>
        </div>
    </div>
</div>
<button type="button" class="btn btn-success mt-3" id="add-product-field">Add Product</button>

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
                            <input name="quantity[]" type="number" class="form-control" style="border-color: #01004C;" value="" />
                        </div>
                    </div>
                    <div class="col-md-1">
                    <label for="" class="form-label" style="color:black;">Action</label>
                        <button type="button" class="btn btn-sm btn-danger remove-product-field mt-1">Remove</button>
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
<button type="button" class="btn btn-pd" onclick="confirmSubmit()" >Request Order</button>
</div>
                                            </div>

                                              <!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Request Order</h5>
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
      



@endsection