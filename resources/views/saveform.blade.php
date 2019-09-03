@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">Add New Employee</div>
            <div class="card-body">
              <div class="container">
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
               <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
                 {{ csrf_field() }}
                  <div class="orm-group row">
                     <div class="col-md-6">
                        <label for="name">Full Name</label>
                        <input id="full_name" type="text" class="form-control{{ $errors->has('full_name') ? ' is-invalid' : '' }}" name="full_name" value="{{ old('full_name') }}" >
                        @if ($errors->has('full_name'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('full_name') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="dob">Dob</label>
                        <input id="dob" type="date" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" value="{{ old('dob') }}" >
                        @if ($errors->has('dob'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('dob') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="gender">Gender</label>
                        <input id="gender" type="text" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="{{ old('gender') }}" >
                        @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="salary">Salary</label>
                        <input id="salary" type="number" class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}" name="salary" value="{{ old('salary') }}" step="any" >
                        @if ($errors->has('salary'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('salary') }}</strong>
                        </span>
                        @endif
                     </div>
                     <div class="col-md-6">
                        <label for="designation">Designation</label>
                        <input id="designation" type="text" class="form-control{{ $errors->has('designation') ? ' is-invalid' : '' }}" name="designation" value="{{ old('designation') }}" >
                        @if ($errors->has('designation'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('designation') }}</strong>
                        </span>
                        @endif
                     </div>
                       <div class="col-md-6">
                         <label for="designation">Image Upload</label>
                        <table class="table">
                        <tr>
                        <td width="30"><input type="file" name="image" />jpg, png, gif</td>
                        </tr>
                        <tr>
                        </tr>
                        </table>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                        Save
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
