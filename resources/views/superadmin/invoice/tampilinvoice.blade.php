@extends('layouts.superadmin.app')

@section('content')
<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Invoice</button>

                                <button id="printButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Invoice</button>

</div>
<br>
<br>
<!-- Begin Page Content -->
<div class="container-fluid" id="container-fluid">
    <div class="row">
        <!-- Logo -->
       
        <img src="{{asset('img/logopremier.png')}}"style="max-width: 250px; margin-top:-50px;">
        
        <!-- Text -->
      
            <div class="tulisan" style="margin-top:35px;">
                <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold;">Premier Deli Indonesia</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;">Graha Arteri Mas Kav 31, Kedoya Selatan</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;">Jakarta Barat,11520</h6>
            </div>
      
    </div>

    

    <h2 style="color:black; font-family: Arial, sans-serif; font-weight:bold;text-align:center;">Invoice</h2>
    <hr style=" border: 1px solid black;">


    <div class ="informasi" style="display: flex;">

<!-- Left column -->
<div style="flex: 1; margin-right: 10px;">
    <h6 style="color:black; font-family: Arial, sans-serif;">Nama Customer : {{$invoice -> customer -> nama_customer}} </h6>
    <h6 style="color:black; font-family: Arial, sans-serif;">Alamat : {{$invoice -> alamat}} </h6>
    <h6 style="color:black; font-family: Arial, sans-serif;">Phone : {{$invoice -> customer -> no_hp}} </h6>
</div>

<!-- Right column -->
<div style="flex: 1; margin-left: 10px;">
    <h6 style="color:black; font-family: Arial, sans-serif;">No. Invoice : {{$invoice -> invoice_no}}</h6>
    <h6 style="color:black; font-family: Arial, sans-serif;">No. Order : {{$invoice -> no_so}} {{$invoice -> no_quote}}</h6>
    <h6 style="color:black; font-family: Arial, sans-serif;">Tanggal : <?php echo date('d - m - Y', strtotime($invoice->invoice_date)); ?></h6>
    
</div>




</div>


<div class="produk" style="margin-top:50px;">
        <!-- <h4 class="mb-4 mt-4 text-center" style="color:black;">Informasi Produk</h4> -->
        <div class="table-responsive">
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th  scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 15px;">No</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 15px;">Kode Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 15px;">Nama Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 15px;">Qty</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 15px;">Unit Price</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 15px;">Total Price</th>
                </tr>
            </thead>
            <tbody>
            @php
        $counter = 1; // Inisialisasi nomor urutan
        @endphp
                @foreach ($detailinvoice as $detail)
                <tr>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{ $counter++ }}</td>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail -> kode_produk}}</td>
 
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail -> nama_produk}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail->qty}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($detail->invoice_price, 0, ',', '.') }}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($detail->total_price, 0, ',', '.') }}</td>
                </tr>
               @endforeach 
                <!-- End of data produk -->
            </tbody>

            <tfoot>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold;">Sub Total</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; ">
    {{ 'Rp ' . number_format($invoice->subtotal, 0, ',', '.') }}
</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold;">Discount</td>
        @if ($invoice->is_persen == 'persen')
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$invoice->discount}} %</td>
        @elseif ($invoice->is_persen== 'amount')
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($invoice->discount, 0, ',', '.') }} </td>
        @endif
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold;">PPN</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{ $invoice->ppn }} %</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold; ">Total</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($invoice->total, 0, ',', '.') }}</td>
    </tr>
  
    <tr> <!-- Baris baru untuk menambahkan tulisan -->
    <td colspan="6" style="text-align: center; color:black; font-family: Arial, sans-serif; font-weight: bold; font-size: 13px;">
     </td>
    </tr>
    <tr> <!-- Baris baru untuk menambahkan tulisan -->
        <td colspan="6" style="text-align: center; color:black; font-family: Arial, sans-serif; font-weight: bold; font-size: 13px;">
        Pembayaran dapat dilakukan ke <span> Bank BCA 4900325652 a.n PT BPM Solution </td>
    </tr>
</tfoot>

        </table>
</div>
    </div>

</div>

<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>



<script>
   document.getElementById('exportPdfButton').addEventListener('click', function() {
    var salesOrderId = '<?php echo $invoice->id; ?>'; // Ganti ini dengan cara yang sesuai untuk mendapatkan ID sales order
    var url = '{{ route("invoice.download", ":id") }}'; // Ganti 'sales-order.download' dengan nama rute yang sesuai jika perlu

    // Mengirim permintaan AJAX untuk menandai sales order telah diunduh
    fetch(url.replace(':id', salesOrderId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            noinvoice: '<?php echo $invoice->invoice_no; ?>',
            namacust: '<?php echo $invoice->nama_customer; ?>',
        })
    })
    .then(response => {
        if (response.ok) {
            // Jika permintaan berhasil, lanjutkan dengan membuat dan mengunduh PDF
            var chartContainer = document.getElementById('container-fluid').cloneNode(true);
            var options = {
                filename:  '<?php echo $invoice->invoice_no; ?>' + ' - ' + '<?php echo $invoice->nama_customer; ?>' + '.pdf',
                margin: [5, 5, 5, 5],
                // konfigurasi untuk unduhan PDF
            };
            html2pdf(chartContainer, options);
        } else {
            console.error('Failed to mark sales order as downloaded');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

    document.getElementById('printButton').addEventListener('click', function() {
        // Select the chart container element
        var chartContainer = document.getElementById('container-fluid').cloneNode(true); // Clone the container
        
        // Remove any buttons from the cloned container (optional)
        var buttons = chartContainer.querySelectorAll('button');
        buttons.forEach(function(button) {
            button.remove();
        });

        // Print the cloned chart container
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = chartContainer.innerHTML;
        window.print();
        document.body.innerHTML = originalContents;
    });
</script>
@endsection
