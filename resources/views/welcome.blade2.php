@extends('master.main')

@section('title','Home Page')

@section('content')

    {{--@include('includes.search')--}}

    <div class="row">
        <div class="col-md-3 col-sm-12" style="margin-top:2.3em">
            @include('includes.categories')
            <div class="row mt-3">
                <div class="col">
                    <div class="card ">
                        <div class="card-header">
                            Official Link Mirrors
                        </div>
                        <div class="card-body text-center">
                            @foreach(config('marketplace.mirrors') as $mirror)
                                <a href="http://{{$mirror}}" style="text-decoration:none;">{{$mirror}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12 mt-3 ">

            <div class="row">
                <div class="col">
                    <h1 class="col-10">{{config('app.name')}}</h1>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <hr>
                </div>
            </div>
            @isModuleEnabled('FeaturedProducts')
                @include('featuredproducts::frontpagedisplay')
            @endisModuleEnabled

            <div class="row mt-4">

                <div class="col-md-4">
                    <h4>
                        Top Vendors
                    </h4>
                    <hr>
                    @foreach(\App\Vendor::topVendors() as $vendor)
                        <table class="table table-borderless table-hover">
                            <tr>
                                <td>
                                    <a href="{{route('vendor.show',$vendor)}}"
                                       style="text-decoration: none; color:#ddc">{{$vendor->user->username}}</a>
                                </td>
                                <td class="text-right">
                                    <span class="btn btn-sm @if($vendor->vendor->experience >= 0) btn-primary @else btn-danger @endif active"
                                          style="cursor:default">Level {{$vendor->getLevel()}}</span>

                                </td>
                            </tr>
                        </table>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <h4>
                        Latest orders
                    </h4>
                    <hr>
                    @foreach(\App\Purchase::latestOrders() as $order)
                        <table class="table table-borderless table-hover">
                            <tr>
                                <td>
                                    <img class="img-fluid" height="23px" width="23px"
                                         src="{{ asset('storage/'  . $order->offer->product->frontImage()->image) }}"
                                         alt="{{ $order->offer->product->name }}">
                                </td>
                                <td>
                                    {{str_limit($order->offer->product->name,50,'...')}}
                                </td>
                                <td class="text-right">
                                    {{$order->getSumLocalCurrency()}} {{$order->getLocalSymbol()}}
                                </td>
                            </tr>
                        </table>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <h4>
                        Rising vendors
                    </h4>
                    <hr>
                    @foreach(\App\Vendor::risingVendors() as $vendor)
                        <table class="table table-borderless table-hover">
                            <tr>
                                <td>
                                    <a href="{{route('vendor.show',$vendor)}}"
                                       style="text-decoration: none; color:#ddc">{{$vendor->user->username}}</a>
                                </td>
                                <td class="text-right">
                                    <span class="btn btn-sm @if($vendor->vendor->experience >= 0) btn-primary @else btn-danger @endif active"
                                          style="cursor:default">Level {{$vendor->getLevel()}}</span>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                </div>


            </div>


        </div>

    </div>

@stop