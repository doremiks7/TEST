@extends('layouts.app')

@section('content')
@section('pixel', '720px')
<div class="container">
    <div class="row">
        <div class="col-md-7" style="height: 500px;"> @include('templade/standard') </div>
        <div class="col-md-5">
            <div class="panel panel-info" style="height: 500px; background: #C6F4D2;">
                <div class="panel-heading" style="background: #5cb85c; color: white;">Login</div>
                <div class="panel-body" style="margin-top: 100px;">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        @if(Session::has('flash-message') == 'You have just logged so many, please wait 300s to login again.')
                          <div class="alert alert-{!! Session::get('flash-level') !!}">       
                              {!! Session::get('flash-message') !!}
                          </div>

                          <div class="panel panel-danger" id="stupid">
                                <div class="panel-heading"><span id="time">03:00</span> minutes!</div>
                          </div>

                         @elseif(Session::has('flash-message'))
                          <div class="alert alert-{!! Session::get('flash-level') !!}">       
                              {!! Session::get('flash-message') !!}
                          </div>
                       
                        @endif
                        @include('error')

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"> 
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }

        if(timer === 0)
        {
            $('#stupid').slideUp();
        }

    }, 1000);

    

}

    window.onload = function () {
        var fiveMinutes = 60,
            display = document.querySelector('#time');
        startTimer(fiveMinutes, display);
    };
</script>
@endsection
