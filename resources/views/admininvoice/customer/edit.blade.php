@extends('layouts.admininvoice.app')
@section('content')


<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Edit Customer 
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="/updatecustomer/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Customer</label>
    <input name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_customer}}" />
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Kategori</label>
    <select name="kategori" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Kategori --</option>
     
                <option value="Hotel"{{ old('role_id', $data->kategori) == 'Hotel' ? 'selected' : '' }}> Hotel</option>
                <option value="Restaurant"{{ old('role_id', $data->kategori) == 'Restaurant' ? 'selected' : '' }}> Restaurant</option>
                <option value="Cafe"{{ old('role_id', $data->kategori) == 'Cafe' ? 'selected' : '' }}> Cafe</option>
    </select>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Sumber</label>
    <input name="sumber" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->sumber}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama PIC</label>
    <input name="nama_pic" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data ->nama_pic}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Jabatan PIC</label>
    <input name="jabatan_pic" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data -> jabatan_pic}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nomor Handphone</label>
    <input name="no_hp" type="number"  class="form-control " style="border-color: #01004C;" value="{{$data -> no_hp}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Email</label>
    <input name="email" type="email"  class="form-control " style="border-color: #01004C;" value="{{$data->email}}" />
</div>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="lokasi" type="text"  class="form-control " style="border-color: #01004C;" value="" >
{{$data -> lokasi}}
</textarea>
</div>


                                                <button type="submit" class="btn btn-pd " style="">Simpan</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
      
           

@endsection