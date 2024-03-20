@extends('layouts.superadmin.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center" style="color:black;">Pengajuan Cancel {{$datapo->no_po}}</h5>
                </div>
                <div class="card-body">
                <form action="{{route('superadminapprovecancel')}}" method="post">
@csrf
                <input type="hidden" name="po_id" id="" value="{{$datapo -> id}}">
                   
                    <div class="form-group">
                   
                        <p style="color:black;"> Alasan Cancel: {{$datacancel->alasan}}</p>
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
