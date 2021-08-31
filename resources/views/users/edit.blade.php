@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Surname:</strong>
                    <input type="text" name="surname" value="{{ $user->surname }}" class="form-control" placeholder="Surname">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Username:</strong>
                    <input type="text" name="username" value="{{ $user->username }}" class="form-control" placeholder="Username">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    <input type="text" name="password" value="{{ $user->password }}" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Phone Number:</strong>
                    <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="form-control" placeholder="Phone Number">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                        <select id="type" name="category_id">        
                            @foreach ($categories as $category)
                                
                                <option value="{{ $category['id'] }}" {{ $category['id'] == $user->category_id ? 'selected' : '' }}>{{ $category['name'] }}</option>
                            
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Tag:</strong>
                        <select id="type" name="tags[]" multiple>        
                            @foreach ($tags as $tag)
                                
                                <option value="{{ $tag['id'] }}" {{ in_array($tag['id'], $currentTags) ? 'selected' : '' }}>{{ $tag['name'] }}</option>
                                
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Photo:</strong>
                        @if ($user->photo != '')
                            <img src="{{ asset('images/'.$user->photo)}}" width="75" height="75">
                            <input type="checkbox" name="delete_image" value="1">  <label>Delete Image</label>
                        @else
                            {{ '' }}
                        @endif     
                </div>
                <div class="form-group">
                    <input type="file" name="photo">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Birthday:</strong>
                    <input type="text" class="form-control datepicker" id="datepicker" name="birthday" value={{ $user->birthday}}>
                    <div class="result"></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
    <script> var ajaxUrl = "{{ url('ajax') }}"</script> 
    <script type="text/javascript" src="{{ URL::asset('/js/datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/editDate.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/daysCalculator.js') }}"></script>
@endsection