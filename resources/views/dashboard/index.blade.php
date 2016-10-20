@extends('layouts.app')

@section('content')
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">Shortened URLs</div>
            <div class="panel-body">
                <ul>
                    @foreach ($urls as $url)
                        <li>
                            <a href="{{ url('/dashboard/' . $url->hash) }}">{{ $url->hash }}</a>
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            <a href="{{ url('/' . $url->hash) }}">{{ $url->original_url }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Statistics for <strong>{{ $default_url->hash }}</strong></div>
            <div class="panel-body">
                Shortened URL: <a href="{{ url('/' . $url->hash) }}">{{ url('/' . $url->hash) }}</a>
                <br>
                Directs to: <a href="{{ url('/' . $url->hash) }}">{{ $url->original_url }}</a>
                <hr>
                <a href="http://twitter.com/intent/tweet?status={{ url('/') . '/' . $url->hash }}" class="btn btn-primary">Share on Twitter</a>
                <div href="https://www.facebook.com/sharer/sharer.php?u={{ url('/') . '/' . $url->hash }}" class="fb-share btn btn-primary">Share on Facebook</div>
                <hr>
                Views: {{ $url->views }}
                <br>
                Created at: {{ $url->created_at }}
                <hr>
                <button type="button" class="btn btn-danger" id="delete" href="{{ url('/dashboard/' . $url->hash . '/delete') }}">Delete link</button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="/js/delete.js"></script>
@endsection