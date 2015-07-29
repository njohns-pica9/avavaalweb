@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1>Hi {{ $user->getName() }}</h1>
            <p>Here are the asset's that have been mapped, use the left and right arrows to navigate. enjoy.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="thumbnail">
                <img class="asset img-responsive" src="{{ $asset['file']['path'] }}" alt="You hoverin' over me bro?!" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Container Tags:</h4>
            <table class="table table-bordered table-responsive">
                <tr>
                    <td>Asset File: </td>
                    <td><a href="{{ $asset['file']['path'] }}">{{ $asset['file']['name'] }}</a></td>
                </tr>
                <tr>
                    <td>Usage Rights File: </td>
                    <td><a href="{{ $asset['rights']['path'] }}">{{ $asset['rights']['name'] }}</a></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Container Tags:</h4>
            <table class="table table-bordered table-responsive">
                @foreach($containers as $id => $container)
                    <tr>
                        <td>{{ $id }}</td>
                        <td>{{ $container }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Datapoints:</h4>
            <table class="table table-bordered table-responsive">
                @foreach($datapoints as $name => $datapoint)
                    <tr>
                        <td>{{ $name }}</td>
                        <td>
                            @if(! is_array($datapoint))
                                {{ $datapoint }}
                            @else
                                <ul>
                                    @foreach($datapoint as $thing)
                                        <li>{{ $thing }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h4>Raw: </h4>
            <div class="well">
                <textarea class="form-control" cols="100" rows="100">{{ $raw }}</textarea>
            </div>
        </div>
    </div>
@endsection

@section('appscripts')
    <script type="application/javascript">
        var pageStuff = {
            page: "{{$page['now']}}",
            nextPage: "{{$page['next']}}",
            prevPage: "{{$page['prev']}}"
        };

        Mousetrap.bind('up up down down left right left right b a enter', function() {
            window.location.href = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        });

        Mousetrap.bind('left', function() {
            window.location.href = 'http://avalon.dev:9988/'+pageStuff.prevPage;
        });

        Mousetrap.bind('right', function() {
            window.location.href = 'http://avalon.dev:9988/'+pageStuff.nextPage;
        });
    </script>
@endsection