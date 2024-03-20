@extends('layouts.admininvoice.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0-800" style="color:black;">Dashboard Admin Invoice</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Filter</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('filter') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="bulan" class="form-control">
                                    <option value="">Pilih Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ (isset($bulan) && $bulan == $i) ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Sales Order / Quotation</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                    <th>Sales Order / Quotation</th>
                                    <th>Tanggal SO</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($so as $item)
                                    <tr>
                                        <td>{{ $item->no_so }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->so_date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->status_so }}</td>
                                    </tr>
                                @endforeach

                                @foreach ($quote as $item)
                                    <tr>
                                        <td>{{ $item->no_quote }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->quote_date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->status_quote }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchase Order</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                    <th>Purchase Order</th>
                                    <th>Tanggal PO</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($po as $item)
                                    <tr>
                                        <td>{{ $item->no_po }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->po_date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->status_po }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Invoice</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Tanggal Invoice</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $item)
                                    <tr>
                                        <td>{{ $item->invoice_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->invoice_date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->status_invoice }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
