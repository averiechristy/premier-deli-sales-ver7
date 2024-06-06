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
      
            <div class="tulisan" style="margin-top:30px;">
                <h6 style="color:black; font-family: Arial, sans-serif; font-weight:bold; font-size:12px;">Premier Deli Indonesia</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold; font-size:12px;">JL. Pulau Bira D . I No. 12 A
Kembangan Utara, Kembangan
</h6>
                <h6 style="color:black; font-family: Arial, sans-serif;  font-weight:bold; font-size:12px;">Jakarta Barat - DKI Jakarta 11610</h6>
            </div>
      
    </div>

    <hr style=" border: 1px solid black; margin-top:-46px;">
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
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead style="text-align: center;">
                <tr>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;width: 1px; vertical-align: top;">No</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Gambar Produk</th>
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
                $breakPoint = count($detailquote) > 9 ? 10 : 7;
                @endphp
         @foreach ($detailquote as $detail)
                @if($loop->iteration % $breakPoint == 0)
            </tbody>
        </table>
        <div style="page-break-before: always;"></div>
        <table class="table table-bordered mt-5">
            <thead style="text-align: center;">
                <tr>
                <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;width: 1px; vertical-align: top;">No</th>
                <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Gambar Produk</th>

                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;width: 10px; vertical-align: top;">Kode Produk</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; vertical-align: top;">Nama Produk</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; width: 5px;vertical-align: top;">Jumlah Produk</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; vertical-align: top;">Harga Jual</th>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px; vertical-align: top;">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @endif
                <tr style="height: 50px;">
                    <td style="color: black; font-family: Arial, sans-serif; text-align: center; font-size: 10px; width: 1px; height: 50px; overflow: hidden; white-space: nowrap;">{{ $counter++ }}</td>
                    <td style="width:5px; height: 50px; ">
                            @if($detail->produk->gambar_produk)
                                <img src="{{asset('images/produk/'.$detail->produk->gambar_produk)}}" alt="Gambar Produk" style="width: 50px; height: 50px;">
                            @else
                              
                            @endif
                        </td>
                    <td style="color: black; font-family: Arial, sans-serif; font-size: 10px; width: 20px; height: 50px; overflow: hidden; white-space: nowrap;">{{$detail->kode_produk}}</td>
                    <td style="color: black; font-family: Arial, sans-serif; font-size: 10px; height: 50px; width: 250px; height: 50px; overflow: hidden; word-wrap: break-word;">
                        <?php
                            $nama_produk = $detail->nama_produk;
                            if (strlen($nama_produk) > 100) {
                                $nama_produk = substr($nama_produk, 0, 100) . '...';
                            }
                            echo htmlspecialchars($nama_produk, ENT_QUOTES, 'UTF-8');
                        ?>
                    </td>
                    <td style="color: black; font-family: Arial, sans-serif; font-size: 10px; width: 5px; text-align: center; width: 10px; height: 50px; overflow: hidden; white-space: nowrap;">{{$detail->qty}}</td>
                    <td style="color: black; font-family: Arial, sans-serif; font-size: 10px; text-align: right; width: 100px; height: 50px; overflow: hidden; white-space: nowrap;">
                        <span style="float: left;">Rp</span>
                        {{ number_format($detail->quote_price, 0, ',', '.') }}
                    </td>
                    <td style="color: black; font-family: Arial, sans-serif; font-size: 10px; text-align: right; width: 100px; height: 50px; overflow: hidden; white-space: nowrap;">
                        <span style="float: left;">Rp</span>
                        {{ number_format($detail->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: center; color:black; font-family: Arial, sans-serif; font-weight: bold; font-size: 13px;" colspan="5" rowspan="5">
                        <div class="catatan">Catatan: <br> {{$quote->catatan}}</div>
                    </td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Sub Total</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
                        <span style="float: left;">Rp</span>
                        {{ number_format($subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Diskon</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
                        <span style="float: left;">Rp</span>
                        {{ number_format($discount, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Biaya Pengiriman</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
                        <span style="float: left;">Rp</span>
                        {{ number_format($biayakirim, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">PPN</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
                        <span style="float: left;">Rp</span>
                        {{ number_format($ppn, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;">Total</td>
                    <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;">
                        <span style="float: left;">Rp</span>
                        {{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <style>
                        .catatan {
                            white-space: pre-line;
                            text-align: left;
                            font-size: 12px;
                        }
                    </style>
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
    var url = '{{ route("quotation.download", ":id") }}'; // Ganti 'sales-order.download' dengan nama rute yang sesuai jika perlu

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
