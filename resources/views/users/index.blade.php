@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 8 CRUD </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}" title="Create a user"> <i class="fas fa-plus-circle"></i>
                    </a>
            </div>
            <div class="pull-right">
                
                <a class="btn btn-danger" href="{{ URL::route('export.exportToCSV') }}" title="Export to CSV"> <i class="fas fa-download"></i>
                    </a>
            </div>
            <div class="pull-right">
                
                <a class="btn btn-warning" href="{{ URL::route('export2.exportToXML') }}" title="Export to XML"> <i class="fas fa-download"></i>
                    </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>No</th>
            <th>
                <a href="{{ route('users.index')}}?field=name">Name</a>
                <a href="{{ route('users.index')}}?direction=asc&field=name"><i class="fas fa-arrow-down"></i></a>
                <a href="{{ route('users.index')}}?direction=desc&field=name"><i class="fas fa-arrow-up"></i></a>
            </th>
            <th>
                <a href="{{ route('users.index')}}?field=surname">Surname</a>
                <a href="{{ route('users.index')}}?direction=asc&field=surname"><i class="fas fa-arrow-down"></i></a>
                <a href="{{ route('users.index')}}?direction=desc&field=surname"><i class="fas fa-arrow-up"></i></a>
            </th>
            <th>
                <a href="{{ route('users.index')}}?field=email">Email</a>
                <a href="{{ route('users.index')}}?direction=asc&field=email"><i class="fas fa-arrow-down"></i></a>
                <a href="{{ route('users.index')}}?direction=desc&field=email"><i class="fas fa-arrow-up"></i></a>
            </th>
            <th>
                <a href="{{ route('users.index')}}?field=username">Username</a>
                <a href="{{ route('users.index')}}?direction=asc&field=username"><i class="fas fa-arrow-down"></i></a>
                <a href="{{ route('users.index')}}?direction=desc&field=username"><i class="fas fa-arrow-up"></i></a>
            </th>
            <th>Password</th>
            <th>Phone Number</th>
            <th>Photo</th>
            <th>Category</th>
            <th>Tag</th>
            <th>Birthday</th>
            <th>Date Created</th>
            <th>Action</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->surname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->password }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>
                    @if ($user->photo != '')
                    
                        <img src="{{ asset('images/'.$user->photo)}}" width="50" height="50">
                    
                    @else
                        {{ '' }}
                    @endif
                </td>
                <td>{{ $user->category['name'] }}</td>
                <td>
                    @foreach ($user->tags as $tag)
                      {{  $tag['name'] }} <br> 
                    @endforeach 
                
                </td>
                <td>
                    {{ substr($user->birthday, 0, strrpos($user->birthday, ' ')) }}

                </td>
                <td>{{ date_format($user->created_at, 'jS M Y') }}</td>
                <td>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">

                        <a href="{{ route('users.show', $user->id) }}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>

                        <a href="{{ route('users.edit', $user->id) }}">
                            <i class="fas fa-edit fa-lg"></i>
                        </a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" title="delete" style="border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>

                        </button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>

 {!! $users->links() !!}
    
@endsection 

