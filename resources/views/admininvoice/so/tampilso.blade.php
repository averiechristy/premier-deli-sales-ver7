@extends('layouts.admininvoice.app')

@section('content')

<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Sales Order</button>

                                <button id="printButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Sales Order</button>

</div>
<br>
<br>
<!-- Begin Page Content -->
<div class="container-fluid" id="container-fluid">

    <!-- Page Heading -->
    <h2 class="h3 mb-2 text-center mt-2" style="color:black; font-weight:bold; font-family: Arial, sans-serif; font-size:22px;">Sales Order</h2>

    <div class="row">
        <!-- Logo -->
       
        <img src="{{asset('img/logopremier.png')}}"style="max-width: 250px; margin-top:-50px;">
        
        <!-- Text -->
      
            <div class="tulisan" style="margin-top:47px;">
                <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold;font-size:12px;">Premier Deli Indonesia</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;font-size:12px;">Graha Arteri Mas Kav 31, Kedoya Selatan</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;font-size:12px;">Jakarta Barat,11520</h6>
            </div>
      
    </div>

    <hr style=" border: 1px solid black;margin-top:-35px; ">

    <!-- Split the content into two columns -->
    <div class ="informasi" style="display: flex;">

<!-- Left column -->
<div style="flex: 1.7; margin-right: 10px;">
    <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;"> <span style="font-weight:bold;">Nama Customer</span>
    <span style="margin-left:10px;">:</span>   {{$so  -> nama_customer}} </h6>
    <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px; word-wrap: break-word;">
    <span style="font-weight:bold;">Alamat</span>
    <span style="margin-left:63px;">:</span> 
    <?php 
    if(strlen($so->alamat) > 50) {
        $alamat_wrapped = wordwrap($so->alamat, 50, "<br>\n", true);
        $alamat_with_spaces = str_replace("<br>", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $alamat_wrapped);
        echo $alamat_with_spaces;
    } else {
        echo $so->alamat;
    }
    ?> 
</h6>  
  <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;"> <span style="font-weight:bold;">No. HP</span>
    <span style="margin-left:65px;">:</span>  {{$so -> customer -> no_hp}} </h6>


</div>

<!-- Right column -->
<div style="flex: 1; ">
    <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;"><span style="font-weight:bold;">No Order<span style="margin-left:72px;"> :</span></span> {{$so -> no_so}}</h6>
    <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;"><span style="font-weight:bold;">Tanggal <span style="margin-left:79px;">:</span></span> <?php echo date('d - m - Y', strtotime($so->so_date)); ?></h6>
    <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;"><span style="font-weight:bold;">Tanggal Pengiriman <span style="margin-left:10px;">:</span></span> <?php echo date('d - m - Y', strtotime($so->rfo->shipping_date)); ?></h6>
</div>

</div>


    <!-- Tabel Produk -->

    <div class="produk" style="margin-top:20px;">
        <!-- <h4 class="mb-4 mt-4 text-center" style="color:black;">Informasi Produk</h4> -->
        <div class="table-responsive">
        <table class="table table-bordered" >
        <thead style="text-align: center;">
                <tr>
                    <th  scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">No</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Kode Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top; width: 200px;">Nama Produk</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Jumlah Produk</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Harga Jual</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
            @php
        $counter = 1; // Inisialisasi nomor urutan
        @endphp
                @foreach ($detailso as $detail)
                <tr>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 1px;text-align: center;">{{ $counter++ }}</td> 
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 10px;">{{$detail -> kode_produk}}</td>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 350px;">
 {{$detail->nama_produk}}
</td>                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 10px;text-align: center;">{{$detail->qty}}</td>
<td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($detail->so_price, 0, ',', '.') }}
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
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; ">Discount</td>
      
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
</td>    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; ">Total</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($total, 0, ',', '.') }}
</td>    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px;font-weight: bold; ">Down Payment</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($pembayaran, 0, ',', '.') }}
</td>    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px;font-weight: bold;">Sisa Tagihan</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($sisatagihan, 0, ',', '.') }}
</td>    </tr>
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
    var salesOrderId = '<?php echo $so->id; ?>'; // Ganti ini dengan cara yang sesuai untuk mendapatkan ID sales order
    var url = '{{ route("sales-order.download", ":id") }}'; // Ganti 'sales-order.download' dengan nama rute yang sesuai jika perlu

    // Mengirim permintaan AJAX untuk menandai sales order telah diunduh
    fetch(url.replace(':id', salesOrderId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            noSO: '<?php echo $so->no_so; ?>',
            customerName: '<?php echo $so->customer->nama_customer; ?>'
        })
    })
    .then(response => {
        if (response.ok) {
            // Jika permintaan berhasil, lanjutkan dengan membuat dan mengunduh PDF
            var chartContainer = document.getElementById('container-fluid').cloneNode(true);
            var options = {
                filename: 'SO - <?php echo $so->no_so; ?> - <?php echo $so->customer->nama_customer; ?>.pdf',
              
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
    
    // Event listener to refresh the page after printing or canceling
    window.onafterprint = function() {
        document.body.innerHTML = originalContents;
        window.location.reload();
    };

    // Print the cloned chart container
    document.body.innerHTML = chartContainer.innerHTML;
    window.print();
});

</script>
@endsection
