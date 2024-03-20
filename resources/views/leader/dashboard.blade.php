@extends('layouts.leader.app')
@section('content')

<div class="container-fluid">
    <div class="row justify-content-center align-items-center" >
        <!-- Logo and Title -->
        <div class="col-md-8 mb-3 text-center">
        <img src="{{asset('img/logopremier.png')}}"  alt="Sales Sistem Premier Deli Logo" style="height: 200px; width: auto;">
            <h2 style="color: #9B5718;">Sales Sistem Premier Deli</h2>
        </div>
        </div>
        <div class="row justify-content-center align-items-center" style="margin-top: 50px;">
        <!-- Request Card -->

        <div class="col-md-4">
            <div class="card request-card p-4" style="height: 200px;">
            <a href="{{route('leader.rfo.index')}}">
                <div class="card-body">
                <i class="fa fa-th-list" style="font-size: 40px; color: #9B5718; "aria-hidden="true"></i>
                    <h4 class="card-title mt-3" style="color: black;">Request Form Order</h4>
                </div>
                </a>
            </div>
        </div>
        <!-- Quotation Card -->
        <div class="col-md-4">
            <div class="card quotation-card p-4" style="height: 200px;">
            <a href="{{route('leader.quotation.index')}}">
                <div class="card-body">
                <i class="fa fa-list-alt" style="font-size: 40px; color: #9B5718; "aria-hidden="true"></i>
                <h4 class="card-title mt-3" style="color: black;">Quotation</h4>
                </div>
                </a>
            </div>
        </div>

  <div class="col-md-4">
            <div class="card quotation-card p-4" style="height: 200px;">
                <a href="{{route('leader.customer.index')}}">
                    <div class="card-body">
                        <i class="fa fa-building" style="font-size: 40px; color: #9B5718; "aria-hidden="true"></i>
                        <h4 class="card-title mt-3" style="color: black;">Customer</h4>
                    </div>
                </a>
            </div>
        </div>
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
