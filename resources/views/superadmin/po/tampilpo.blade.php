@extends('layouts.superadmin.app')
@section('content')

<div class="buttons">
<!-- Di bagian bawah tampilan -->
<button id="exportPdfButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3"><i
                                class="fas fa-download fa-sm text-white-50"></i> Download Purchase Order</button>

<button id="printButton" style="float: right;" class=" d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3"><i
                                class="fas fa-print fa-sm text-white-50"></i> Print Purchase Order</button>

</div>
<br>
<br>
<!-- Begin Page Content -->
<div class="container-fluid" id="container-fluid">

    <!-- Page Heading -->
    <h2 class="h3 mb-2 text-center" style="color:black; font-weight:bold; font-family: Arial, sans-serif; font-size:22px;">Purchase Order</h2>

    <hr style=" border: 1px solid black;">

    <!-- Split the content into two columns -->
    <div class="informasi" style="display: flex;">

        <!-- Left column -->
        <div style="flex: 2; margin-right: 10px;">
            <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;"><span style="font-weight:bold;">No Purchase Order <span style="margin-left:10px;">:</span></span>  {{$po->no_po}}</h6>
            <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;"><span style="font-weight:bold;"> Nama Customer <span style="margin-left:28px;">:</span></span> PT BPM SOLUTION</h6>
            <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;"> <span style="font-weight:bold;">Alamat <span style="margin-left:81px;">:</span>  </span>JL. Pulau Bira D . I No. 12 A, Kembangan Utara,
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kembangan Jakarta Barat - DKI Jakarta 11610   
            </h6>
            <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;"><span style="font-weight:bold;">Nomor Handphone <span style="margin-left:13px;">:</span></span> {{$po->no_hp}}</h6>
            <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;"><span style="font-weight:bold;">Email <span style="margin-left:90px;">:</span> </span>ivan@examitrasolusi.co.id</h6>
        </div>

        <!-- Right column -->
        <div style="flex: 1; margin-left: 10px;">
            <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;"><span style="font-weight:bold;">Tanggal <span style="margin-left:50px;">:</span> </span><?php echo date('d - m - Y', strtotime($po->po_date)); ?></h6>
        </div>

    </div>

    <!-- Tabel Produk -->
    <div class="produk" style="margin-top:10px;">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="text-align: center;">
                    <tr>
                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">No</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Kode Produk</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Nama Produk</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Jumlah Produk</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Harga Beli</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Total Harga</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Diskon(%)</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Diskon(Rp)</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Total Harga setelah Diskon</th>
                                </tr>
                </thead>
                <tbody>
                @php
                $counter = 1; // Inisialisasi nomor urutan
                $breakPoint = count($detailpo) > 9 ? 10 : 7;
                @endphp
                    @foreach ($detailpo as $detail)
                    @if($loop->iteration % $breakPoint == 0)
                            </tbody>
                            </table>
                            <div style="page-break-before: always;"></div>
                            <table class="table table-bordered mt-5">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">No</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Kode Produk</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Nama Produk</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Jumlah Produk</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Harga Beli</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Total Harga</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Diskon(%)</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Diskon(Rp)</th>
                                    <th scope="col" style="color:black; font-family: Arial, sans-serif; font-size: 10px;vertical-align: top;">Total Harga setelah Diskon</th>
                                </tr>
                            </thead>
                            <tbody>
                        @endif
                        <tr style="height:50px;">
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px;text-align: center;">{{ $counter++ }}</td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px;">{{$detail -> kode_produk}}</td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; width:350px;">
                            <?php
                            $nama_produk = $detail->nama_produk;
                            if (strlen($nama_produk) > 100) {
                                $nama_produk = substr($nama_produk, 0, 100) . '...';
                            }
                            echo htmlspecialchars($nama_produk, ENT_QUOTES, 'UTF-8');
                        ?>
                        </td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: center; width:5px;" >{{$detail->qty}}</td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;"><span style="float: left;">Rp</span>{{ number_format($detail->po_price, 0, ',', '.') }}</td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;"><span style="float: left;">Rp</span>{{ number_format($detail->total_price, 0, ',', '.') }}</td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: center;">{{$detail->discount}}%</td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;"><span style="float: left;">Rp</span>{{ number_format($detail->amount, 0, ',', '.') }}</td>
                            <td style="height:50px; color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;"><span style="float: left;">Rp</span>{{ number_format($detail->total_price_after_discount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;text-align:center;">{{$totalqty}}</td>
                        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold;"></td>
                        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;"><span style="float: left;">Rp</span>{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td></td>
                        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;"><span style="float: left;">Rp</span>{{ number_format($totaldisk, 0, ',', '.') }}</td>
                        <td style="color:black; font-family: Arial, sans-serif; font-size: 10px; text-align: right;width:100px;"><span style="float: left;">Rp</span>{{ number_format($totalpriceafter, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="ttd mt-2">
                <h6 style="color:black; font-family: Arial, sans-serif; font-size:12px;">Purchasing, </h6>
                <br>
                <br>
                <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;">Nama : Ivan </h6>
                <h6 style="color:black; font-family: Arial, sans-serif;font-size:12px;">Tanggal : <?php echo date('d - m - Y', strtotime($po->po_date)); ?></h6>
            </div>
        </div>
    </div>
</div>

<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

<script>
   document.getElementById('exportPdfButton').addEventListener('click', function() {
    var salesOrderId = '<?php echo $po->id; ?>'; // Ganti ini dengan cara yang sesuai untuk mendapatkan ID sales order
    var url = '{{ route("purchase-order.download", ":id") }}'; // Ganti 'sales-order.download' dengan nama rute yang sesuai jika perlu

    // Mengirim permintaan AJAX untuk menandai sales order telah diunduh
    fetch(url.replace(':id', salesOrderId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            noSO: '<?php echo $po->no_po; ?>',
        })
    })
    .then(response => {
        if (response.ok) {
            // Jika permintaan berhasil, lanjutkan dengan membuat dan mengunduh PDF
            var chartContainer = document.getElementById('container-fluid').cloneNode(true);
            var options = {
                filename: 'PO - <?php echo $po->no_po; ?> .pdf',
                jsPDF: {
                    orientation: 'landscape'
                },
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
