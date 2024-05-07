@extends('layouts.manager.app')

@section('content')

<!-- Begin Page Content -->

<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" >
<i class="fas fa-download fa-sm text-white-50"></i> Download Quotation</button>

                                <button id="printButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Quotation</button>

</div>
<div class="container-fluid" id="container-fluid">


    <!-- Page Heading -->

    <div class="row" >
        <!-- Logo -->
       
        <img src="{{asset('img/logopremier.png')}}"style="max-width: 250px; margin-top:-60px;">
        
        <!-- Text -->
      
            <div class="tulisan" style="margin-top:35px;">
                <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold; font-size:12px;">Premier Deli Indonesia</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold; font-size:12px;">JL. Pulau Bira D . I No. 12 A
Kembangan Utara, Kembangan
</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold; font-size:12px;">Jakarta Barat - DKI Jakarta 11610</h6>
            </div>
      
    </div>

    <hr style=" border: 1px solid black; margin-top:-51px;">
    <h2 class="h3 mb-2 " style="color:black; font-weight:bold; font-family: Arial, sans-serif; font-size:20px;">Quotation</h2>

    <!-- Split the content into two columns -->
    <div class ="informasi" style="display: flex;">

        <!-- Left column -->
        <div style="flex: 2; margin-right: 5px;">
            <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Nama Customer</span> <span style="margin-left:10px;">:</span> {{$quote -> customer -> nama_customer}} </h6>
            <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px; word-wrap: break-word;">
    <span style="font-weight:bold;">Alamat</span>
    <span style="margin-left:63px;">:</span> 
    <?php 
    if(strlen($quote->alamat) > 55) {
        $alamat_wrapped = wordwrap($quote->alamat, 55, "<br>\n", true);
        $alamat_with_spaces = str_replace("<br>", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $alamat_wrapped);
        echo $alamat_with_spaces;
    } else {
        echo $quote->alamat;
    }
    ?> 
</h6>


            <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Nama PIC</span> <span style="margin-left:48px;">:</span> {{$quote -> nama_pic}} </h6>
            <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Email</span> <span style="margin-left:72px;">:</span> {{$quote -> email}} </h6>
            <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Phone</span> <span style="margin-left: 68px;">:</span> {{$quote -> customer -> no_hp}} </h6>
        </div>

        <!-- Right column -->
        <div style="flex: 1; ">
            <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">No</span> <span style="margin-left:65px;">:</span> {{$quote -> no_quote}}</h6>
            <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Tanggal</span> <span style="margin-left:36px;">:</span> <?php echo date('d - m - Y', strtotime($quote->quote_date)); ?></h6>
            <h6 style="color:black; font-family: Arial, sans-serif;  font-size:12px;"><span style="font-weight:bold;">Tanggal Valid</span> <span style="margin-left:5px;">:</span> <?php echo date('d - m - Y', strtotime($quote->valid_date)); ?></h6>


        </div>

    </div>
<style>
    /* Tambahkan kode CSS ini di bagian head atau dalam file CSS Anda */
.informasi h6 {
    min-width: 200px; /* Sesuaikan lebar sesuai kebutuhan */
}

</style>
    <!-- Tabel Produk -->

    <div class="produk">
        <!-- <h4 class="mb-4 mt-4 text-center" style="color:black;">Informasi Produk</h4> -->
        <div class="table-responsive">
        <table class="table table-bordered" >
  
    <thead style="text-align: center;">
    <tr>
        <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;width: 1px; vertical-align: top;">No</th>
        <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;width: 10px; vertical-align: top;">Kode Produk</th>
        <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; vertical-align: top;">Nama Produk</th>
        <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 5px;vertical-align: top;">Jumlah Produk</th>
        <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; vertical-align: top;">Harga Jual</th>
        <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; vertical-align: top;">Total Harga</th>
    </tr>
    </thead>
<style>
    thead {
    display: table-header-group;
}
</style>

            <tbody>
            @php
        $counter = 1; // Inisialisasi nomor urutan
        @endphp
                @foreach ($detailquote as $detail)
                <tr>
                <td style="color:black; font-family: Arial, sans-serif; text-align: center; font-size: 10px;width: 1px;">{{ $counter++ }}</td> 
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px;width: 10px;">{{$detail -> kode_produk}}</td>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 350px;">
  {{$detail->nama_produk}}
</td>
<td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 5px; text-align: center;">{{$detail->qty}}</td>
<td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($detail->quote_price, 0, ',', '.') }}
</td>
<td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($detail->total_price, 0, ',', '.') }}
</td>
                </tr>
               @endforeach 
              
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
</td>    

</tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; ">Total</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
    <span style="float: left;">Rp</span>
    {{ number_format($total, 0, ',', '.') }}
</td>    </tr>
   
 
    <tr> <!-- Baris baru untuk menambahkan tulisan -->
    <td colspan="6" style="text-align: center; color:black; font-family: Arial, sans-serif; font-weight: bold; font-size: 13px;">
     </td>
    </tr>
  
</tfoot>

        </table>
</div>
    </div>

   

    
</div>

<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>



<script>
     document.getElementById('exportPdfButton').addEventListener('click', function() {
    var salesOrderId = '<?php echo $quote->id; ?>'; // Ganti ini dengan cara yang sesuai untuk mendapatkan ID sales order
    var url = '{{ route("managerquotation.download", ":id") }}'; // Ganti 'sales-order.download' dengan nama rute yang sesuai jika perlu

    // Mengirim permintaan AJAX untuk menandai sales order telah diunduh
    fetch(url.replace(':id', salesOrderId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            noSO: '<?php echo $quote->no_quote; ?>',
            customerName: '<?php echo $quote->customer->nama_customer; ?>'
        })
    })
    .then(response => {
        if (response.ok) {
            // Jika permintaan berhasil, lanjutkan dengan membuat dan mengunduh PDF
            var chartContainer = document.getElementById('container-fluid').cloneNode(true);
            var options = {
                filename: 'Quote - <?php echo $quote->no_quote; ?> - <?php echo $quote->customer->nama_customer; ?>.pdf',
              
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
