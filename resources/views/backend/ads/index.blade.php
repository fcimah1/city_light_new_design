@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Ads') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('ads.create') }}" class="btn btn-primary">
                    <span>{{ translate('Add New Ad') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-block d-md-flex">
            <h5 class="mb-0 h6">{{ translate('Ads') }}</h5>
            <form class="" id="sort_ads" action="" method="GET">
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 200px;">
                        <input type="text" class="form-control" id="search"
                            name="search"@isset($sort_search)
                        value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type name & Enter') }}">
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th data-breakpoints="lg">#</th>
                        <th>{{ translate('Name') }}</th>
                        <th data-breakpoints="lg">{{ translate('Iink') }}</th>
                        <th data-breakpoints="lg">{{ translate('Banner') }}</th>
                        <th data-breakpoints="lg">{{ translate('Featured') }}</th>
                        <th data-breakpoints="lg">{{ translate('ٍStatus') }}</th>
                        <th data-breakpoints="lg">{{ translate('Start At') }}</th>
                        <th data-breakpoints="lg">{{ translate('End At') }}</th>
                        <th width="10%" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($ads as $key => $ad)
                        <tr>
                            <td>{{ $key + 1 + ($ads->currentPage() - 1) * $ads->perPage() }}</td>
                            <td>{{ $ad->getTranslation('name') }}</td>

                            <td>{{ $ad->getTranslation('link') }}</td>

                            <td>
                                @if ($ad->banner != null)
                                    <img src="{{ uploaded_asset($ad->banner) }}" alt="{{ translate('Banner') }}"
                                        class="h-50px">
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="update_featured(this)" value="{{ $ad->id }}"
                                        <?php if ($ad->featured == 1) {
                                            echo 'checked';
                                        } ?>>
                                    <span></span>
                                </label>
                            </td>

                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="update_status(this)" value="{{ $ad->id }}"
                                        <?php if ($ad->status == 'active') {
                                            echo 'checked';
                                        } ?>>
                                    <span></span>
                                </label>
                            </td>

                            <td>{{ date($ad->start_date) }}</td>
                            <td>{{ date($ad->end_date) }}</td>

                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    href="{{ route('ads.edit', ['id' => $ad->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                    title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('ads.destroy', $ad->id) }}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $ads->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('ads.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                featured: status
            }, function(data) {
                if (data == 1) {
                    console.log('ddd');
                    AIZ.plugins.notify('success', '{{ translate('Featured ads updated successfully') }}');
                } else {
                    console.log('fff');
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_status(el) {
            if (el.checked) {
                var status = 'active';
            } else {
                var status = 'inactive';
            }
            $.post('{{ route('ads.status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Payment Method status updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
