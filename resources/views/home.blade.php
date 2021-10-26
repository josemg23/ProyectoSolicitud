@extends('layouts.nav')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($paginacion as $item)
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- {{ $body['data']['next_page_url'] }} --}}
            {{ $paginacion->links() }}
        </div>
    </div>
@endsection
