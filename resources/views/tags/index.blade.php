@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 8 CRUD </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('tags.create') }}" title="Create a tag"> <i class="fas fa-plus-circle"></i>
                    </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{!! $message !!}}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-success">
            <p>{{!! $message !!}}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Date Created</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($tags as $tag)
            <tr>
                
                <td>{{ ++$i }}</td>
                <td>{{ $tag->name }}</td>
                <td>{{date_format($tag->created_at, 'jS M Y')}}</td>
                <td>
                    <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">

                        <a href="{{ route('tags.show', $tag->id) }}" title="show">
                            <i class="fas fa-eye text-success  fa-lg"></i>
                        </a>

                        <a href="{{ route('tags.edit', $tag->id) }}">
                            <i class="fas fa-edit  fa-lg"></i>

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

    {!! $tags->links() !!}

@endsection
