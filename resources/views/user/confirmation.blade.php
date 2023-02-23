@extends('user.subindex') @section('content')


    <div class="checkout-h">
        <div class="container">
            <h1>{{ __('messages.confirm_pay') }}</h1>
        </div>
    </div>

    <div class="mb-5">
        <div class="container w-50 container-fluid">
                @if (Session::has('message'))
                    <div class="col-sm-12">
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                             role="alert">{{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
            @if (Session::has('error'))
                    <div class="col-sm-12">
                        <div class="alert  {{ Session::get('alert-class', 'alert-danger') }} alert-dismissible fade show"
                             role="alert">{{ Session::get('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                    <form class="w-50 container-fluid" action="{{ route('payment.confirm.submit') }}" method="post">
                        @csrf
                        <input type="hidden" name="store_id" value="{{$store ?? ''}}">
                        <div class="form-group">
                            <h1><label for="confirm_code">Confirmation code</label></h1>
                            <input type="text" class="form-control" id="confirm_code" name="confirm_code"  placeholder="Confirmation code" style="height: 50px">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
        </div>

    </div>




@stop
