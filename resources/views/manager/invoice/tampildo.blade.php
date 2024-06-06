@extends('layouts.manager.app')

@section('content')
<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Delivery Order</button>

                                <button id="printButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3" ><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Sales Order</button>

</div>

<br>
<br>
<br>

<!-- Begin Page Content -->
<div class="container-fluid" id="container-fluid">
    
<div class ="informasi" style="display: flex;">

<!-- Left column -->
<div style="flex: 1; margin-right: 10px;">
<div class="row" style="margin-top">
        <!-- Logo -->
       
        <img src="{{asset('img/logopremier.png')}}"style="max-width: 250px; margin-top:-50px;">
        
        <!-- Text -->
      
            <div class="tulisan">
                <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold;font-size:12px;">Premier Deli Indonesia</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;font-size:12px;">Graha Arteri Mas Kav 31, Kedoya Selatan</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold;font-size:12px;">Jakarta Barat,11520</h6>
            </div>
      
    </div>
</div>

<!-- Right column -->
<div style="flex: 1; margin-left: 10px;">
<h2 style="color:black; font-family: Arial, sans-serif; font-weight:bold;text-align:center; font-size:22px;">Delivery Order</h2>

    
</div>




</div>

<hr style=" border: 1px solid black;">


    <div class ="informasi" style="display: flex;">

<!-- Left column -->
<div style="flex: 1.8; ">
<h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;">Nama Customer <span style="margin-left:15px;">: {{$invoice -> customer -> nama_customer}} </span></h6>
<h6 style="color:black; font-family: Arial, sans-serif; font-size:12px; word-wrap: break-word;">
    <span >Alamat</span>
    <span style="margin-left:65px;">:</span> 
    <?php 
    if(strlen($invoice->alamat) > 50) {
        $alamat_wrapped = wordwrap($invoice->alamat, 50, "<br>\n", true);
        $alamat_with_spaces = str_replace("<br>", "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $alamat_wrapped);
        echo $alamat_with_spaces;
    } else {
        echo $invoice->alamat;
    }
    ?> 
</h6>    <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;">Phone <span style="margin-left:65px;">: {{$invoice -> customer -> no_hp}} </span></h6></div>

<!-- Right column -->
<div style="flex: 1; margin-left: 10px;">

<h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;">No. Invoice <span style="margin-left:55px;">: {{$invoice -> invoice_no}}</span></h6>
<h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;">Tanggal <span style="margin-left:73px;">: <?php echo date('d - m - Y', strtotime($invoice->invoice_date)); ?> </span></h6>

</div>
</div>
<div class="produk" >
        <!-- <h4 class="mb-4 mt-4 text-center" style="color:black;">Informasi Produk</h4> -->
        <div class="table-responsive">
        <table class="table table-bordered" >
        <thead style="text-align: center;">
                <tr>
                    <th  scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">No</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Kode Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Nama Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Jumlah Produk</th>
               
                </tr>
            </thead>
            <tbody>
            @php
        $counter = 1; // Inisialisasi nomor urutan
        @endphp
                @foreach ($detailinvoice as $detail)
                <tr>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width:1px;text-align:center;">{{ $counter++ }}</td>
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width:10px;">{{$detail -> kode_produk}}</td>
 
                <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 450px;">
                {{$detail->nama_produk}}
</td>                                     <td style="color:black; font-family: Arial, sans-serif; font-size: 10px;width:10px;text-align:center;">{{$detail->qty}}</td>
                </tr>
               @endforeach 
                <!-- End of data produk -->
            </tbody>
            <tfoot>
    <tr>
    <td colspan="4" style="color:black; font-family: Arial, sans-serif; font-size: 10px; height: 100px;">
                <!-- Isi kolom catatan dengan panjang yang cukup panjang -->
            Catatan: 
        </td>
    </tr>
</tfoot>

        </table>
        <p style="color:black; font-size:10px;">Barang diterima dalam kondisi baik oleh :</p>

        <div class="ttd-container" style="display: flex; justify-content: space-between; margin-top: 20px;">
    <!-- Tanda tangan Pembeli -->
    <div class="ttd-pembeli" style="flex: 1;">
        <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold;font-size:10px;"> Pembeli  / Penerima </h6>
        <br>
        <br>
        <br>
        <br>

        <p style="color:black;">----------------------------</p>
    </div>
    
    <!-- Tanda tangan Pengirim -->
    <div class="ttd-pengirim" style="flex: 1;">
        <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold;font-size:10px;">Pengirim</h6>
        <!-- Tempat untuk tanda tangan -->
        <br>
        <br>
        <br>
        <br>

        <p  style="color:black;">----------------------------</p>
    </div>
</div>


</div>
    </div>

</div>

<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>






<script>
   document.getElementById('exportPdfButton').addEventListener('click', function() {
    var salesOrderId = '<?php echo $invoice->id; ?>'; // Ganti ini dengan cara yang sesuai untuk mendapatkan ID sales order
    var url = '{{ route("do.download", ":id") }}'; // Ganti 'sales-order.download' dengan nama rute yang sesuai jika perlu

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
                filename: 'DO - ' + '<?php echo $invoice->invoice_no; ?>' + ' - ' + '<?php echo $invoice->nama_customer; ?>' + '.pdf',
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
