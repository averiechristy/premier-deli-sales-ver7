@extends('layouts.manager.app')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid" id="container-fluid">

<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" >
<i class="fas fa-download fa-sm text-white-50"></i> Download Quotation</button>

                                <button id="printButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Quotation</button>

</div>
<br>
<br>
    <!-- Page Heading -->

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

    <hr style=" border: 1px solid black;">
    <h2 class="h3 mb-2 " style="color:black; font-weight:bold; font-family: Arial, sans-serif;">Quotation</h2>

    <!-- Split the content into two columns -->
    <div class ="informasi" style="display: flex;">

        <!-- Left column -->
        <div style="flex: 1; margin-right: 10px;">
            <h6 style="color:black; font-family: Arial, sans-serif;">Nama Customer : {{$quote -> customer -> nama_customer}} </h6>
            <h6 style="color:black; font-family: Arial, sans-serif;">Alamat : {{$quote -> alamat}} </h6>
            <h6 style="color:black; font-family: Arial, sans-serif;">Nama PIC : {{$quote -> nama_pic}} </h6>
            <h6 style="color:black; font-family: Arial, sans-serif;">Email : {{$quote -> email}} </h6>
            <h6 style="color:black; font-family: Arial, sans-serif;">Phone : {{$quote -> customer -> no_hp}} </h6>
        </div>

        <!-- Right column -->
        <div style="flex: 1; margin-left: 10px;">
            <h6 style="color:black; font-family: Arial, sans-serif;">No Order : {{$quote -> no_quote}}</h6>
            <h6 style="color:black; font-family: Arial, sans-serif;">Tanggal : <?php echo date('d - m - Y', strtotime($quote->quote_date)); ?></h6>
            <h6 style="color:black; font-family: Arial, sans-serif;">Tanggal Valid: <?php echo date('d - m - Y', strtotime($quote->valid_date)); ?></h6>


        </div>

    </div>

    <!-- Tabel Produk -->

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
                @foreach ($detailquote as $detail)
                <tr>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{ $counter++ }}</td> 
                <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail -> kode_produk}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail -> nama_produk}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail->qty}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($detail->quote_price, 0, ',', '.') }}</td>
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
    {{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}
</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold;">Discount</td>
        @if ($tipe == 'persen')
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$discountasli}} %</td>
        @elseif ($tipe == 'amount')
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($discountasli, 0, ',', '.') }} </td>
        @endif
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold;">PPN</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{ $ppnpersen }} %</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold; ">Total</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($total, 0, ',', '.') }}</td>
    </tr>
   
 
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
        // Select the chart container element
        var chartContainer = document.getElementById('container-fluid').cloneNode(true); // Clone the container
        
        // Remove any buttons from the cloned container (optional)
        var buttons = chartContainer.querySelectorAll('button');
        buttons.forEach(function(button) {
            button.remove();
        });
       
        var noSO = '<?php echo $quote->no_quote; ?>';
        var namacust = '<?php echo $quote->customer->nama_customer; ?>';

        // Set options for html2pdf
        var options = {
            margin: [5, 5, 5, 5], // Adjust margins as needed (top, left, bottom, right)     
            filename: 'Quote - ' + noSO + ' - ' + namacust + '.pdf',
            image: { type: 'jpeg', quality: 0.98 }, // Set image quality
            html2canvas: { scale: 3 }, // Adjust scale as needed
            jsPDF: { unit: 'mm', format: 'A4', orientation: 'portrait' } // Adjust format and orientation as needed
        };

        // Use html2pdf to export the cloned chart container as PDF with specified options
        html2pdf(chartContainer, options);
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
