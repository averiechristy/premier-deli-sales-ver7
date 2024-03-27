@extends('layouts.leader.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Channel
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('leader.channel.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                      
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kode Channel</label>
    <input name="kode_channel" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Channel</label>
    <input name="nama_channel" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>
                                

        <div class="form-group mb-4">
                                                <button type="submit" class="btn btn-pd " style="">Simpan</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
      
  

<script>


function validateForm() {

    let kodechannel = document.forms["saveform"]["kode_channel"].value;
    let namachannel = document.forms["saveform"]["nama_channel"].value;


    if(kodechannel == "") {
    alert("Kode Channel harus diisi");
return false;
}

else if (kodechannel.length != 2) {
            alert("Kode produk harus terdiri dari 2 karakter");
            return false;
        }

else if(namachannel == ""){
    alert("Nama Channel harus diisi");
return false;
}


}

</script>

@endsection