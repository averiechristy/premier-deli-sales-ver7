@extends('layouts.leader.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Edit Kategori
                                    </div>
                                    <div class="card-body">
                                    <form name="saveform" action="/leaderupdatekategori/{{$data->id}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                      

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kategori</label>
    <input name="kategori" type="text"  class="form-control " style="border-color: #01004C;" value="{{$data->kategori}}" />
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
      
  



@endsection