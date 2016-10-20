@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Shrinkr</div>

            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/url/create') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <input type="text" id="url" class="form-control" name="url" value="{{ old('url') }}" placeholder="URL Address" required autofocus>

                            @if ($errors->has('url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    @if (!Auth::guest())
                        <div class="form-group{{ $errors->has('hash') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <input type="text" id="hash" class="form-control" name="hash" value="{{ old('hash') }}" placeholder="Custom identifier">

                                @if ($errors->has('hash'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hash') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                Shrink URL
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
