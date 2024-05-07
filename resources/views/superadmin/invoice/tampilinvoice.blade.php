@extends('layouts.superadmin.app')

@section('content')

<style>
    .container-fluid {
        position: relative; /* Add position relative to contain absolutely positioned watermark */
    }

    .watermark {
        position: absolute;
        top: 50%; 
        left: 60%; 
        transform: translate(-50%, -50%) rotate(-45deg); /* Rotate the watermark */
        width: 60%;
        height: 60%;
        background-image: url('{{ asset("img/lunas.png") }}'); /* Path to your watermark image */
        background-repeat: no-repeat; /* Change background-repeat to no-repeat */
        background-size: contain; /* Optionally adjust background-size */
        opacity: 0.1; /* Adjust opacity as needed */
    }
</style>

<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Invoice</button>

                                <button id="printButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Invoice</button>

</div>
<br>

<!-- Begin Page Content -->
<div class="container-fluid" id="container-fluid">
<div class="watermark"></div>
    <div class="row invoice-container">
        <!-- Logo -->
       
        <img src="{{asset('img/logopremier.png')}}"style="max-width: 250px; margin-top:-50px;">
        
        <!-- Text -->
      
            <div class="tulisan" style="margin-top:40px;">
                <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold;font-size:12px; ">Premier Deli Indonesia</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;font-size:12px;">Graha Arteri Mas Kav 31, Kedoya Selatan</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;font-size:12px;">Jakarta Barat,11520</h6>
            </div>
      
    </div>

    

    <h2 style="color:black; font-family: Arial, sans-serif; font-weight:bold;text-align:center;font-size:22px;margin-top:-45px;">Invoice</h2>
    <hr style=" border: 1px solid black;">


    <div class ="informasi" style="display: flex;">

<!-- Left column -->
<div style="flex: 1.7; margin-right: 10px;">
    <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;"><span style="font-weight:bold;">Nama Customer</span> <span style="margin-left:10px;">:</span> {{$invoice -> customer -> nama_customer}} </h6>
    <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px; word-wrap: break-word;">
    <span style="font-weight:bold;">Alamat</span>
    <span style="margin-left:63px;">:</span> 
    <?php 
    if(strlen($invoice->alamat) > 50) {
        $alamat_wrapped = wordwrap($invoice->alamat, 50, "<br>\n", true);
        $alamat_with_spaces = str_replace("<br>", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $alamat_wrapped);
        echo $alamat_with_spaces;
    } else {
        echo $invoice->alamat;
    }
    ?> 
</h6>    <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Phone </span><span style="margin-left:67px;">:</span> {{$invoice -> customer -> no_hp}} </h6>
</div>

<!-- Right column -->
<div style="flex: 1;">
    <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">No. Invoice </span><span style="margin-left:10px;">:</span> {{$invoice -> invoice_no}}</h6>
    <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">No. Order </span> <span style="margin-left:19px;">:</span> {{$invoice -> no_so}} {{$invoice -> no_quote}}</h6>
    <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Tanggal </span> <span style="margin-left:29px;">:</span> <?php echo date('d - m - Y', strtotime($invoice->invoice_date)); ?></h6>
    
</div>




</div>


<div class="produk" style="margin-top:50px;">
        <!-- <h4 class="mb-4 mt-4 text-center" style="color:black;">Informasi Produk</h4> -->
        <div class="table-responsive">
        <table class="table table-bordered" >
        <thead style="text-align: center;">
                <tr>
                    <th  scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">No</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Kode Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Nama Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Jumlah Produk</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Harga Jual</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
            @php
        $counter = 1; // Inisialisasi nomor urutan
        @endphp
                @foreach ($detailinvoice as $detail)
                <tr>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px;width:1px;">{{ $counter++ }}</td>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px;width:10px;">{{$detail -> kode_produk}}</td>
 
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 350px;">
    <?php
    $nama_produk = $detail->nama_produk;
    if (strlen($nama_produk) > 100) {
        $nama_produk = wordwrap($nama_produk, 100, "<br>", true);
    }
    echo $nama_produk;
    ?>
</td>                                      <td style="color:black; font-family: Arial, sans-serif; font-size: 10px;width:10px;">{{$detail->qty}}</td>
<td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($detail->invoice_price, 0, ',', '.') }}
</td>                   

<td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($detail->total_price, 0, ',', '.') }}
</td>                </tr>
               @endforeach 
                <!-- End of data produk -->
            </tbody>

            <tfoot>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Sub Total</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($subtotal, 0, ',', '.') }}
</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Discount</td>
       
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($discount, 0, ',', '.') }}
</td>       
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">PPN</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($ppn, 0, ',', '.') }}
</td>         </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; ">Total</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($total, 0, ',', '.') }}
</td>         </tr>
  
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
