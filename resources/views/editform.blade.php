@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">Edit Employee Data</div>
            <div class="card-body">
               @if ( Session::has('success') )
               <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  <span class="sr-only">Close</span>
                  </button>
                  <strong>{{ Session::get('success') }}</strong>
               </div>
               @endif
               @if ( Session::has('error') )
               <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  <span class="sr-only">Close</span>
                  </button>
                  <strong>{{ Session::get('error') }}</strong>
               </div>
               @endif
               @if (count($errors) > 0)
               <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                  <div>
                     @foreach ($errors->all() as $error)
                     <p>{{ $error }}</p>
                     @endforeach
                  </div>
               </div>
               @endif
               <form method="POST" action="{{ route('update') }}" enctype="multipart/form-data">
                   {{ csrf_field() }}
                  <input name="id" type="hidden" value={{$id}}>
                  <div class="form-group row">
                     <div class="col-md-6">
                        <label for="full_name">Full Name</label>
                        <input id="full_name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="full_name" value="{{$data->full_name}}">
                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="dob">Dob</label>
                        <input id="dob" type="date" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" value="{{ $data->dob}}">
                        @if ($errors->has('dob'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('dob') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="gender">Gender</label>
                        <input id="gender" type="text" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="{{$data->gender}}">
                        @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="salary">Salary</label>
                        <input id="salary" type="number" class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}" name="salary" value="{{$data->salary}}" step="any">
                        @if ($errors->has('salary'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('salary') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="designation">Designation</label>
                        <input id="designation" type="text" class="form-control{{ $errors->has('designation') ? ' is-invalid' : '' }}" name="designation" value="{{$data->designation}}">
                        @if ($errors->has('designation'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('designation') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <img src="{{ asset('/images/' . $data->image) }}" width="200px"/>
                        <label for="image">Image Upload</label>
                        <table class="table">
                           <tr>
                              <td width="30"><input type="file" name="image"  value="{{$data->image}}"/>jpg, png, gif</td>
                           </tr>
                           <tr>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                        Update
                        </button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
