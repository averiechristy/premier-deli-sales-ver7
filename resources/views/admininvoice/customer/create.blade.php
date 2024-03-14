@extends('layouts.admininvoice.app')
@section('content')






<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Customer Baru
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="{{route('admininvoice.customer.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Customer</label>
    <input name="nama_customer" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>


<div class="form-group mb-4">
    <label for="" class="form-label" style="color:black;">Kategori</label>
    <select name="kategori" class="form-control" style="border-color: #01004C;" aria-label=".form-select-lg example" >
        <option value="" selected disabled>-- Pilih Kategori --</option>
     
                <option value="Hotel"> Hotel</option>
                <option value="Restaurant"> Restaurant</option>
                <option value="Cafe"> Cafe</option>
    </select>
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Sumber</label>
    <input name="sumber" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama PIC</label>
    <input name="nama_pic" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Jabatan PIC</label>
    <input name="jabatan_pic" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nomor Handphone</label>
    <input name="no_hp" type="number"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Email</label>
    <input name="email" type="email"  class="form-control " style="border-color: #01004C;" value="" />
</div>


<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Alamat</label>
    <textarea name="lokasi" type="text"  class="form-control " style="border-color: #01004C;" value="" >

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