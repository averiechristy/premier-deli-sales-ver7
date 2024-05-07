@extends('layouts.manager.app')
@section('content')

<div class="container">
                    
                                <div class="card mt-3">
                                    <div class="card-header" style="color:black;">
                                        Tambahkan Kategori
                                    </div>
                                    <div class="card-body">
                                       <form name="saveform" action="{{route('manager.kategori.simpan')}}" method="post" onsubmit="return validateForm()">
                                        @csrf                       
                                      

<div class="form-group mb-4">
        <label for="" class="form-label" style="color:black;">Kategori</label>
    <input name="kategori" type="text"  class="form-control " style="border-color: #01004C;" value="" />
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