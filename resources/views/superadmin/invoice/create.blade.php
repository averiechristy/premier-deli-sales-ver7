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
@endsection