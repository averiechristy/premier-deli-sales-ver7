@extends('layouts.manager.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Catatan Quotation
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('manager.catatan.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                      
<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Judul Catatan</label>
    <input name="judul_catatan" type="text"  class="form-control " style="border-color: #01004C;" value="" />
</div>

<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Isi Catatan</label>
  <textarea class="form-control" name="isi_catatan" id="exampleFormControlTextarea1" rows="5"></textarea>
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


<script>
window.onload = function () {
    var inputFields = document.getElementsByTagName('input');
    for (var i = 0; i < inputFields.length; i++) {
        if (inputFields[i].type !== 'date' && inputFields[i].name !== '_token'  ) {
            inputFields[i].value = '';
        }
    }

    var textareaFields = document.getElementsByTagName('textarea');
    for (var j = 0; j < textareaFields.length; j++) {
        textareaFields[j].value = '';
    }

    var selectFields = document.getElementsByTagName('select');
    for (var k = 0; k < selectFields.length; k++) {
        selectFields[k].selectedIndex = 0; // Mengatur indeks pilihan ke 0
    }
    
    if (window.history && window.history.pushState) {
        window.addEventListener('popstate', function () {
            window.location.reload();
        });
    }
};

</script>
@endsection