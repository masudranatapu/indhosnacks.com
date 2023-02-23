@extends('deliveryboy.index')
@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __('messages.dashboard') }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">{{ __('messages.dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content mt-3">
        <div class="col-sm-4 ">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <label class=" form-control-label">{{ __('messages.setyourpre') }}</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <p class="form-control-static">
                                @if ($presence == 'No' || $presence == 'no')
                                    <a href="{{ url('deliveryboy/changeattendace/Yes') }}"><i
                                            class="fa fa-toggle-off prefenceswitch" aria-hidden="true"></i></a>
                                @endif
                                @if ($presence == 'Yes' || $presence == 'yes')
                                    <a href="{{ url('deliveryboy/changeattendace/No') }}"><i
                                            class="fa fa-toggle-on prefenceswitch" aria-hidden="true"></i></a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
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
                            <div class="table-responsive dtdiv">
                                <table id="currentorderTable" class="table table-striped dttablewidth">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.order_no') }}</th>
                                            <th>{{ __('messages.total_item') }}</th>
                                            <th>{{ __('messages.order_amount') }}</th>
                                            <th>{{ __('messages.date') }}</th>
                                            <th>{{ __('messages.more_detail') }}</th>
                                            <th>{{ __('messages.status') }}</th>
                                            <th>{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="order_no_msg" value="{{ __('messages.order_no') }}">
    <input type="hidden" id="order_pay_type" value="{{ __('messages.pay_type') }}">
    <input type="hidden" id="ordermsgnote" value="{{ __('messages.note') }}">
    <input type="hidden" id="orderpicktime" value="{{ __('messages.pickuptime') }}">
    <input type="hidden" id="orderitem_name" value="{{ __('messages.item_name') }}">
    <input type="hidden" id="ordermsg_item_qty" value="{{ __('messages.item_qty') }}">
    <input type="hidden" id="ordermsg_price" value="{{ __('messages.price') }}">
    <input type="hidden" id="ordermsg_totalprice" value="{{ __('messages.total_price') }}">
    <input type="hidden" id="ordermsg_subtotal" value="{{ __('messages.subtotal') }}">
    <input type="hidden" id="ordermsg_delivery_charges" value="{{ __('messages.delivery_charges') }}">
    <input type="hidden" id="ordermsg_total" value="{{ __('messages.total') }}">
    <input type="hidden" id="ordermsg_confirm" value="{{ __('successerr.order_con_msg') }}">
@stop
