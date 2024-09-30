@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('Advertisement')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a target="_blank" href="{{ route('home') }}" class="btn btn-circle btn-info">
				<span>{{translate('Visit Home')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Advertisement List')}}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0" >
            <thead>
            <tr>
                <th>{{ translate('#')}}</th>
                <th>{{ translate('Date')}}</th>
                <th>{{ translate('User')}}</th>
                <th>{{ translate('Banner')}}</th>
                <th>{{ translate('Status')}}</th>
                <th>{{ translate('Action')}}</th>
            </tr>
            </thead>
            <tbody>
            @php($_num = 1)
            @foreach($data as $v)
                <?php $user = \App\User::findOrFail($v->user_id) ?>
                <tr>
                    <td>{{$_num++}}</td>
                    <td>{{$v->created_at}}</td>
                    <td>{{$user['name']}} ({{$user['email']}})</td>
                    <td>
                        <a href="{{$v->banner_url}}" target="_blank">
                            <img src="{{uploaded_asset($v->banner)}}" style="width: 50px; border-radius: 5px" class="shadow-sm hov-shadow">
                        </a>
                    </td>
                    <td>{{$v->status===1?'Running':'Pending'}}</td>
                    <td>
                        <a href="{{route('admin.advertisement.check', $v->id)}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Go Live') }}">
                            <i class="las {{$v->status===0?'la-check':'la-times'}}"></i>
                        </a>
                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('seller.user.del', $v->id)}}" title="{{ translate('Delete') }}">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function update_flash_deal_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('flash_deals.update_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    location.reload();
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
