@extends('layouts.manager.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center align-items-center" >
        <!-- Logo and Title -->
        <div class="col-md-8 mb-3 text-center">
        <img src="{{asset('img/logopremier.png')}}"  alt="Sales Sistem Premier Deli Logo" style="height: 200px; width: auto;">
            <h2 style="color: #9B5718;">Sales Sistem Premier Deli</h2>
        </div>
        </div>







    <!-- NEW TAMPILAN -->

    <div class="card request-card p-4">
        <h4 style="color: black; font-weight: bold;">Pesanan dan Penawaran</h4>

<div class="row">
    <div class="col-md-4 mt-2">
        <div class="card request-card p-4" >
            <a href="{{route('manager.rfo.index')}}">
                <div class="card-body">
                    <i class="fa fa-th-list" style="font-size: 30px; color: #9B5718;" aria-hidden="true"></i>
                    <p class="card-title mt-3" style="color: black;">Request Form Order</p>
                </div>
            </a>
        </div>
    </div>
    <!-- Quotation Card -->
    <div class="col-md-4 mt-2">
        <div class="card quotation-card p-4" >
            <a href="{{route('manager.quotation.index')}}">
                <div class="card-body">
                    <i class="fa fa-list-alt" style="font-size: 30px; color: #9B5718;" aria-hidden="true"></i>
                    <p class="card-title mt-3" style="color: black;">Quotation</p>
                </div>
            </a>
        </div>
    </div>
</div>

        </div>


        <div class="card request-card p-4 mt-5">
        <h5 style="color: black; font-weight: bold;">Master Data</h5>
        <div class="row">
     

        <div class="col-md-4 mt-2">
        <div class="card quotation-card p-4" >
            <a href="{{route('manager.customer.index')}}">
                <div class="card-body">
                    <i class="fa fa-building" style="font-size: 30px; color: #9B5718;" aria-hidden="true"></i>
                    <p class="card-title mt-3" style="color: black;">Customer</p>
                </div>
            </a>
        </div>
    </div>

        <div class="col-md-4 mt-2">
            <div class="card quotation-card p-4" >
            <a href="{{route('manager.channel.index')}}">
                <div class="card-body">
                <i class="fa fa-shopping-cart"  style="font-size: 30px; color: #9B5718;" aria-hidden="true"></i>
                <p class="card-title mt-3" style="color: black;">Channel</p>
                </div>
                </a>
            </div>
        </div>



        <div class="col-md-4 mt-2">
            <div class="card quotation-card p-4" >
            <a href="{{route('manager.kategori.index')}}">
                <div class="card-body">
                <i class="fas fa-table" style="font-size: 30px; color: #9B5718; "aria-hidden="true"></i>
                <p class="card-title mt-3" style="color: black;">Kategori</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col-md-4 mt-2">
            <div class="card quotation-card p-4" >
            <a href="{{route('manager.sumber.index')}}">
                <div class="card-body">
                <i class="fa fa-newspaper-o" style="font-size: 30px; color: #9B5718; "aria-hidden="true"></i>
                <p class="card-title mt-3" style="color: black;">Sumber Data Customer</p>
                </div>
                </a>
            </div>
        </div>


        <div class="col-md-4 mt-2">
            <div class="card quotation-card p-4" >
            <a href="{{route('manager.catatan.index')}}">
                <div class="card-body">
                <i class="fa fa-clipboard"  style="font-size: 30px; color: #9B5718; "aria-hidden="true"></i>
                <p class="card-title mt-3" style="color: black;">Catatan Quotation</p>
                </div>
                </a>
            </div>
        </div>


        </div>
        </div>

        <div class="card request-card p-4 mt-5 mb-5">
        <h5 style="color: black; font-weight: bold;">Sistem Penjualan dan Pembelian</h5>
        <div class="row">

        <div class="col-md-4 mt-2">
            <div class="card quotation-card p-4" >
            <a href="{{route('manager.so.index')}}">
                <div class="card-body">
                <i class="fa fa-shopping-basket" style="font-size: 30px; color: #9B5718; "aria-hidden="true"></i>
                <p class="card-title mt-3" style="color: black;">Sales Order</p>
                </div>
                </a>
            </div>
        </div>

        <div class="col-md-4 mt-2">
            <div class="card quotation-card p-4" >
            <a href="{{route('manager.po.index')}}">
                <div class="card-body">
                <i class="fa fa-shopping-cart" style="font-size: 30px; color: #9B5718; "aria-hidden="true"></i>
                <p class="card-title mt-3" style="color: black;">Purchase Order</p>
                </div>
                </a>
            </div>
        </div>
        
        <div class="col-md-4 mt-2">
            <div class="card quotation-card p-4" >
            <a href="{{route('manager.invoice.index')}}">
                <div class="card-body">
                <i class="fa fa-file-text" style="font-size: 30px; color: #9B5718; "aria-hidden="true"></i>
                <p class="card-title mt-3" style="color: black;">Invoice</p>
                </div>
                </a>
            </div>
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
