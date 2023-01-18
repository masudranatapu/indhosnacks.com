@extends('user.subindex')
@section('content')
    <div class="container a-con">
        <div class="pizzaro-about-features">
            <div class="feature-head">
                <h2 class="section-title">{{ __('messages.termsandcon') }}</h2>
                <p> {{ __('messages.aboutush') }}</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="terms-head">
            {!! $termofuse->page_desc !!}
        </div>
    </div>
@stop
