@extends('layouts.admininvoice.app')

@section('content')

<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Purchase Order</button>

                                <button id="printButton" style="float: right;" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Purchase Order</button>

</div>
<br>
<br>
<!-- Begin Page Content -->
<div class="container-fluid" id="container-fluid">

    <!-- Page Heading -->
    <h2 class="h3 mb-2 text-center" style="color:black; font-weight:bold; font-family: Arial, sans-serif;">Purchase Order</h2>



    <hr style=" border: 1px solid black;">

    <!-- Split the content into two columns -->
    <div class ="informasi" style="display: flex;">

        <!-- Left column -->
        <div style="flex: 1; margin-right: 10px;">
        <h6 style="color:black; font-family: Arial, sans-serif;">No Purchase Order : {{$po->no_po}}</h6>
        <h6 style="color:black; font-family: Arial, sans-serif;">Tanggal : <?php echo date('d - m - Y', strtotime($po->po_date)); ?></h6>
    <h6 style="color:black; font-family: Arial, sans-serif;"> Nama Customer :  PT Exa Mitra Solusi</h6>
    <h6 style="color:black; font-family: Arial, sans-serif;"> Alamat :  Graha Arteri Mas Kav 62 - 63, Kel. Kedoya Selatan, Kec. Kebon Jeruk, Jakbar 11520</h6>

        </div>

        <!-- Right column -->
        <div style="flex: 1; margin-left: 10px;">
        <h6 style="color:black; font-family: Arial, sans-serif;">Nomor Handphone : {{$po->no_hp}}</h6>
        <h6 style="color:black; font-family: Arial, sans-serif;">Email : {{$po->email}}</h6>



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
                @foreach ($detailpo as $detail)
                <tr>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{ $counter++ }}</td> 
                <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail -> kode_produk}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail -> nama_produk}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;">{{$detail->qty}}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($detail->po_price, 0, ',', '.') }}</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 15px;"> {{ 'Rp ' . number_format($detail->total_price, 0, ',', '.') }}</td>
                </tr>
               @endforeach 
                <!-- End of data produk -->
            </tbody>
            <tfoot>
    <tr>
        <td colspan="3"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold;">{{$totalqty}}</td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold;"></td>
        <td style="color:black; font-family: Arial, sans-serif; font-size: 15px; font-weight: bold; ">
    {{ 'Rp ' . number_format($subtotal, 0, ',', '.') }}
</td>
    </tr>
    
    
</tfoot>
         

        </table>

<div class="ttd mt-5">
<h6 style="color:black; font-family: Arial, sans-serif;">Admin Purchasing, </h6>
<br>
<br>
<br>
<br>

<h6 style="color:black; font-family: Arial, sans-serif;">Nama : {{$po -> nama_user}} </h6>
<h6 style="color:black; font-family: Arial, sans-serif;">Tanggal : <?php echo date('d - m - Y', strtotime($po->po_date)); ?></h6>

        </div>

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
       
        var noPO = '<?php echo $po->no_po; ?>';
      

        // Set options for html2pdf
        var options = {
            margin: [5, 5, 5, 5], // Adjust margins as needed (top, left, bottom, right)     
            filename: 'PO - ' + noPO +  '.pdf',
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
