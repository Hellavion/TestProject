@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <?php var_dump(session('status'));?>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!

                        <form action="{{ url('logout') }}" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-trash"></i> Выйти
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
