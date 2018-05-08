@extends('bookclub::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">Login using your social networks: &nbsp;&nbsp;
                                <span class="pull-right float-right">
                                    <a href="{{ url('login/facebook') }}" class="btn btn-facebook"><i class="fa fa-facebook"></i></a> 
                                    <a href="{{ url('login/google') }}" class="btn btn-google"><i class="fa fa-google-plus"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
