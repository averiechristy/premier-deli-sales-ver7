@extends('layouts.leader.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center" style="color:black;">Pengajuan Cancel {{$datarfo->no_rfo}}</h2>
                </div>
                <div class="card-body">
                <form action="{{route('approvecancel')}}" method="post">
@csrf
                <input type="hidden" name="rfo_id" id="" value="{{$datarfo -> id}}">
                    <div class="form-group">
                        <label for="customer"  style="color:black;">Customer:</label>
                        <p  style="color:black;">{{$datarfo->nama_customer}}</p>
                    </div>
                    <div class="form-group">
                        <label for="alasan"  style="color:black;">Alasan Cancel:</label>
                        <p style="color:black;"> {{$datacancel->alasan}}</p>
                    </div>
                    <div class="form-group">
                        <label  style="color:black;" for="diajukan_oleh">Diajukan Oleh:</label>
                        <p  style="color:black;">{{$datarfo->nama_pembuat}}</p>
                    </div>

                   
                    <div class="text-center">
                        <button class="btn btn-success">Approve</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
