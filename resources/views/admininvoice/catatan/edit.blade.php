@extends('layouts.admininvoice.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Edit Catatan Quotation
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="/admininvoiceupdatecatatan/{{$data->id}}" method="post" onsubmit="return validateForm()">                                        @csrf                       
                                      
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Judul Catatan</label>
    <input name="judul_catatan" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->judul_catatan}}" />
</div>

<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Isi Catatan</label>
  <textarea class="form-control" name="isi_catatan" id="exampleFormControlTextarea1" rows="5">{{$data->isi_catatan}}</textarea>
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

    let judul = document.forms["saveform"]["judul_catatan"].value;
    let isi = document.forms["saveform"]["isi_catatan"].value;


    if(judul == "") {
    alert("Judul Catatan harus diisi");
return false;
}



else if(isi == ""){
    alert("Isi Catatan harus diisi");
return false;
} 


}

</script>


@endsection