@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Shipping Companies') }}</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-block d-md-flex">
            <h5 class="mb-0 h6">{{ translate('Shipping Companies') }}</h5>
            <form class="" id="sort_companies" action="" method="GET">
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 200px;">
                        <input type="text" class="form-control" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
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
                        <th data-breakpoints="lg">{{ translate('Logo') }}</th>
                        <th data-breakpoints="lg">{{ translate('Status') }}</th>
                        <th data-breakpoints="lg">{{ translate('Featured') }}</th>
                        <th data-breakpoints="lg">{{ translate('Email') }}</th>
                        <th data-breakpoints="lg">{{ translate('Website') }}</th>
                        <th data-breakpoints="lg">{{ translate('Phone') }}</th>
                        <th width="10%" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipmentsCompanies as $key => $company)
                        <tr>
                            <td>{{ $key + 1 + ($shipmentsCompanies->currentPage() - 1) * $shipmentsCompanies->perPage() }}
                            </td>
                            <td>{{ $company->name }}</td>
                            <td>
                                @if ($company->logo != null)
                                    <img src="{{ uploaded_asset($company->logo) }}" alt="{{ translate('Logo') }}"
                                        class="h-50px">
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="update_status(this)" value="{{ $company->id }}"
                                        <?php if ($company->status == 'active') {
                                            echo 'checked';
                                        } ?>>
                                    <span></span>
                                </label>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" onchange="update_featured(this)" value="{{ $company->id }}"
                                        <?php if ($company->featured == 1) {
                                            echo 'checked';
                                        } ?>>
                                    <span></span>
                                </label>
                            </td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->website }}</td>
                            <td>{{ $company->phone }}</td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    href="{{ route('shipping_companies.edit', ['id' => $company->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                    title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <!--<a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"-->
                                <!--    data-href="{{ route('shipping_companies.destroy', $company->id) }}"-->
                                <!--    title="{{ translate('Delete') }}">-->
                                <!--    <i class="las la-trash"></i>-->
                                <!--</a>-->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $shipmentsCompanies->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_status(el) {
            if (el.checked) {
                var status = 'active';
            } else {
                var status = 'inactive';
            }
            $.post('{{ route('shipping_companies.status') }}', {
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

        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('shipping_companies.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                featured: status
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
