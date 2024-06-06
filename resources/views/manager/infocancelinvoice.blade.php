@extends('layouts.manager.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                  <div class="card-header ">
                    <a href="{{ url()->previous() }}" class="btn btn-link" style="color:black;">
                        <i class="fas fa-arrow-left"></i> 
                    </a>
                    <h5 class="text-center" style="color:black;">Pengajuan Cancel {{$datainv->invoice_no}}</h5>
                </div>
                <div class="card-body">
                <form action="{{route('managerapprovecancelinvoice')}}" method="post">
@csrf
                <input type="hidden" name="invoice_id" id="" value="{{$datainv -> id}}">
                   
                <div class="form-group">
                        <label  style="color:black;" for="diajukan_oleh">Alasan Cancel:</label>
                        <p  style="color:black;">{{$datacancel->alasan}}</p>
                    </div>
  <div class="form-group">
                        <label  style="color:black;" for="diajukan_oleh">Diajukan Oleh:</label>
                        <p  style="color:black;">{{$datacancel->diajukan_oleh}}</p>
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
