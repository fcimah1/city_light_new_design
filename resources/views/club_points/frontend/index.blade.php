@extends('front.layout')

@section('content')
    @php
        $club_point_convert_rate = \App\Models\BusinessSetting::where('type', 'club_point_convert_rate')->first()->value;
    @endphp
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('front.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
{{--                                <h1 class="h3">{{ __('front.My Points') }}</h1>--}}
                                <h1 class="h3">My Points</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                                <div class="px-3 pt-3 pb-3">
{{--                                    <div class="h3 fw-700 text-center">{{ $club_point_convert_rate }} {{ __('front.Points') }} = {{ single_price(1) }} {{ __('front.Wallet Money') }}</div>--}}
                                    <div class="h3 fw-700 text-center">
                                        {{ $club_point_convert_rate }} Points = {{ single_price(1) }} Wallet Money </div>
{{--                                    <div class="opacity-50 text-center">{{ __('front.Exchange Rate') }}</div>--}}
                                    <div class="opacity-50 text-center">Exchange Rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="card">
                        <div class="card-header">
{{--                            <h5 class="mb-0 h6">{{ __('front.Point Earning history')}}</h5>--}}
                            <h5 class="mb-0 h6">Point Earning history </h5>
                        </div>
                          <div class="card-body">
                              <table class="table aiz-table mb-0">
{{--                                <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th>#</th>--}}
{{--                                        <th>{{__('front.Order Code')}}</th>--}}
{{--                                        <th data-breakpoints="lg">{{__('front.Points')}}</th>--}}
{{--                                        <th data-breakpoints="lg">{{__('front.Converted')}}</th>--}}
{{--                                        <th data-breakpoints="lg">{{__('front.Date') }}</th>--}}
{{--                                        <th class="text-right">{{__('front.Action')}}</th>--}}
{{--                                    </tr>--}}
{{--                                </thead>      --}}
                                  <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Code</th>
                                        <th data-breakpoints="lg">Points</th>
                                        <th data-breakpoints="lg">Converted</th>
                                        <th data-breakpoints="lg">Date</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($club_points as $key => $club_point)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                            @if ($club_point->order != null)
                                                    {{ $club_point->order->code }}
                                                @else
{{--                                                    {{ __('front.Order not found') }}--}}
                                                    Order not found
                                                @endif
                                            </td>
{{--                                            <td>{{ $club_point->points }} {{ __('front.Points') }}</td>--}}
                                            <td>{{ $club_point->points }}Points</td>
                                            <td>
                                                @if ($club_point->convert_status == 1)
{{--                                                    <span class="badge badge-inline badge-success">{{ __('front.Yes') }}</strong></span>--}}
                                                    <span class="badge badge-inline badge-success">Yes</strong></span>
                                                @else
{{--                                                    <span class="badge badge-inline badge-info">{{ __('front.No') }}</strong></span>--}}
                                                    <span class="badge badge-inline badge-info">No</strong></span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($club_point->created_at)) }}</td>

                                            <td class="text-right">
                                                @if ($club_point->convert_status == 0)
{{--                                                    <button onclick="convert_point({{ $club_point->id }})" class="btn btn-sm btn-styled btn-primary">{{__('front.Convert Now')}}</button>--}}
                                                    <button onclick="convert_point({{ $club_point->id }})" class="btn btn-sm btn-styled btn-primary">Convert Now</button>
                                                @else
{{--                                                  <span class="badge badge-inline badge-success">{{ __('front.Done') }}</span>--}}
                                                  <span class="badge badge-inline badge-success">Done</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              <div class="aiz-pagination">
                                  {{ $club_points->links() }}
                              </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function convert_point(el)
        {
            $.post('{{ route('convert_point_into_wallet') }}',{_token:'{{ csrf_token() }}', el:el}, function(data){
                if (data == 1) {
                    location.reload();
                    {{--AIZ.plugins.notify('success', '{{ __('front.Convert has been done successfully Check your Wallets') }}');--}}
                    AIZ.plugins.notify('success', 'Convert has been done successfully Check your Wallets');
                }
                else {
                    {{--AIZ.plugins.notify('danger', '{{ __('front.Something went wrong') }}');--}}
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
    		});
        }
    </script>
@endsection
