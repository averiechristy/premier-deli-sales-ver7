@extends('layouts.admininvoice.app')

@section('content')

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


<div class="produk" style="margin-top:5px;">
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
                $breakPoint = count($detailinvoice) > 14 ? 14 : 10;
                @endphp
                @foreach ($detailinvoice as $detail)

                @if($loop->iteration % $breakPoint == 0)
                            </tbody>
                            </table>
                            <div style="page-break-before: always;"></div>
                            <table class="table table-bordered mt-5">
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
                        @endif

                <tr style="height:50px;">
                <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px;">{{ $counter++ }}</td>
                <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px;">{{$detail -> kode_produk}}</td>
 
                <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; width:350px;">
                <?php
                            $nama_produk = $detail->nama_produk;
                            if (strlen($nama_produk) > 100) {
                                $nama_produk = substr($nama_produk, 0, 100) . '...';
                            }
                            echo htmlspecialchars($nama_produk, ENT_QUOTES, 'UTF-8');
                        ?>
</td>                                                  

<td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px;width:5px;">{{$detail->qty}}</td>
<td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($detail->invoice_price, 0, ',', '.') }}
</td>                   

<td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($detail->total_price, 0, ',', '.') }}
</td>                </tr>
               @endforeach 
                <!-- End of data produk -->
            </tbody>

            <tfoot>
    <tr>
        <td colspan="4"></td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Sub Total</td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($subtotal, 0, ',', '.') }}
</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Diskon</td>
       
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($discount, 0, ',', '.') }}
</td>       
    </tr>

    <tr>
        <td colspan="4"></td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Biaya Pengiriman</td>
       
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($biayakirim, 0, ',', '.') }}
    </td>      
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">PPN</td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($ppn, 0, ',', '.') }}
</td>         </tr>
    <tr>
        <td colspan="4"></td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; ">Total</td>
        <td style=" height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
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
              
                margin: [5, 0, 0, 0]

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

    // Set up the original contents
    var originalContents = document.body.innerHTML;
    
    // Print the cloned chart container
    document.body.innerHTML = chartContainer.innerHTML;

    // Event listener to refresh the page after printing or canceling
    window.onafterprint = function() {
        setTimeout(function() {
            document.body.innerHTML = originalContents;
            window.location.reload();
        }, 10);
    };

    window.print();
});


</script>
@endsection
