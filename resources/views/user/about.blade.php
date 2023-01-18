@extends('user.subindex')
@section('content')
<div class="container">
    <div class="about-heading">
        <h2>{{__('messages.aboutus')}}</h2>
    </div>
    <div class="about-history-1">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="about-content-1">
                    <p>{{__('messages.the')}} <span>{{__('messages.history_ki')}}</span>{{__('messages.aboutdesc1')}}
                    </p>
                </div>
                <div class="about-content-1">
                    <p>{{__('messages.aboutdesc2')}}<span>{{__('messages.boulang')}}</span>{{__('messages.aboutdesc4')}}
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <img src="{{asset('burger/images/burger-1.png')}}">
            </div>
        </div>
    </div>
</div>
@stop
