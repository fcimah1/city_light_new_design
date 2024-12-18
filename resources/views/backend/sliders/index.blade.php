@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All Sliders')}}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('sliders.create') }}" class="btn btn-primary">
                <span>{{translate('Add New Slider')}}</span>
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6">{{ translate('Sliders') }}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th data-breakpoints="lg">{{translate('photo')}}</th>
                    <th data-breakpoints="lg">{{ translate('Iink') }}</th>
                    <th data-breakpoints="lg">{{translate('published')}}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sliders as $key => $slider)
                    <tr>
                        <td>{{ ($key+1) + ($sliders->currentPage() - 1)*$sliders->perPage() }}</td>
                        
                        <td>
                            @if($slider->photo != null)
                            <img src="{{ uploaded_asset($slider->photo) }}" alt="{{translate('Photo')}}" class="h-50px">
                            @else
                            —
                            @endif
                        </td>
                        <td>{{ $slider->getTranslation('link') }}</td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="update_published(this)" value="{{ $slider->id }}" <?php if($slider->published == 1) echo "checked";?>>
                                <span></span>
                            </label>
                        </td><td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('sliders.edit', ['id'=>$slider->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('sliders.destroy', $slider->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $sliders->links() }}
        </div>
    </div>
</div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('sliders.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('published slider updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

    </script>
@endsection
