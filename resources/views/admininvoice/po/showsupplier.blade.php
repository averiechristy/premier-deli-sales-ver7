@extends('layouts.admininvoice.app')

@section('content')
<div class="container-fluid">
<h4 class="card-title mt-3" style="color: black;">Pilih Supplier</h4>
    <div class="row">
       
        @foreach ($supplier as $data)
        <div class="col-md-4 mt-2">
            <div class="card request-card p-4" style="height: 200px;">
            <a href="{{ route('admininvoice.po.createpochannel', $data->id) }}">

            <div class="card-body">
                        
                        <h4 class="card-title mt-3" style="color: black;">{{$data -> nama_supplier}}</h4>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>


<style>
    .request-card,
    .quotation-card {
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .request-card:hover,
    .quotation-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
</style>

@endsection
