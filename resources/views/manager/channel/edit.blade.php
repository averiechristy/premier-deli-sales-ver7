@extends('layouts.manager.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Edit Channel
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="/managerupdatechannel/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                      
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kode Channel</label>
    <input name="kode_channel" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->kode_channel}}" />
</div>

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Nama Channel</label>
    <input name="nama_channel" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->nama_channel}}" />
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
    alert("Kode channel harus diisi.");
return false;
}

else if (kodechannel.length != 2) {
            alert("Kode channel harus 2 karakter.");
            return false;
        }

else if(namachannel == ""){
    alert("Nama channel harus diisi.");
return false;
} else if (kodechannel === namachannel){
    alert("Kode dan nama channel harus berbeda.");
return false;
}


}

</script>

@endsection