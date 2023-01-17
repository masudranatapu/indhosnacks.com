@extends('user.subindex')
@section('content')
<div class="shop_section mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @foreach($items as $it)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                        <div class="shop_product">
                            <div class="card_product">
                                <a href="{{url('detailitem/'.$it->id)}}">
                                    <img src="{{asset('public/upload/images/menu_item_icon/'.$it->menu_image)}}"
                                        class="card-img-top" alt="{{$it->menu_name}}">
                                </a>
                                <div class="card_body">
                                    <h1><a href="{{url('detailitem/'.$it->id)}}">{{$it->menu_name}}</a></h1>
                                    <p>
                                        {{substr($it->description,0,75)}}
                                    </p>
                                    <div class="shop_price">
                                        <p>
                                            {{Session::get("usercurrency")}} {{$it->price}}
                                            <a href="{{url('detailitem/'.$it->id)}}">{{__('messages.addcart')}}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="pagination mt-5 text-center" style="margin:0 auto;">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@stop
