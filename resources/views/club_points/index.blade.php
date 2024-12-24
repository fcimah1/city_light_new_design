@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('front.Order Code')}}</th>
                                <th  data-breakpoints="lg">{{__('front.Customer Name')}}</th>
                                <th>{{__('front.Points')}}</th>
                                <th data-breakpoints="lg">{{__('front.Convert Status')}}</th>
                                <th data-breakpoints="lg">{{__('front.Earned At')}}</th>
                                <th class="text-right" width="10%">{{__('front.Options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($club_points as $key => $club_point)
                                <tr>
                                    <td>{{ ($key+1) + ($club_points->currentPage() - 1)*$club_points->perPage() }}</td>
                                    <td>
                                        @if ($club_point->order != null)
                                            {{ $club_point->order->code }}
                                        @else
                                            {{ __('front.Order not found') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($club_point->user != null)
                                            {{ $club_point->user->name }}
                                        @else
                                            {{ __('front.User not found') }}
                                        @endif
                                    </td>
                                    <td>{{ $club_point->points }}</td>
                                    <td>
                                        @if ($club_point->convert_status == 1)
                                          <span class="badge badge-inline badge-success">{{__('front.Converted')}}</span>
                                        @else
                                          <span class="badge badge-inline badge-info">{{__('front.Pending')}}</span>
                                        @endif
                                    </td>
                                    <td>{{ $club_point->created_at }}</td>
                                    <td class="text-right">
        								<a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('club_point.details', encrypt($club_point->id))}}" title="{{ __('front.View') }}">
        									<i class="las la-eye"></i>
        								</a>
  				                   </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $club_points->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
