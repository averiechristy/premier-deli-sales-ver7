@extends('layouts.leader.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Sumber
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('leader.sumber.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                      

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Sumber</label>
    <input name="sumber" type="text"  class="form-control " style="border-color: #01004C;" value="" />
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