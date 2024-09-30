@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('User advertisement') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('seller.user.add') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Banner Image') }}</label>
                                    <div class="col-md-8">
                                        <div class=" input-group " data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="banner_ads_image" class="selected-files"
                                                   value="">
                                        </div>
                                        <div class="file-preview"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{translate('Banner Url')}}</label>
                                    <div class="col-md-8">
                                        <input type="text" name="banner_ads_url" value="" class="form-control"
                                               placeholder="https://link-the-image-will-take">
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit"
                                            class="btn btn-primary">{{ translate('Add new ads') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('User advertisement list') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                <tr>
                                    <th>{{ translate('#')}}</th>
                                    <th>{{ translate('Date')}}</th>
                                    <th>{{ translate('Banner')}}</th>
                                    <th>{{ translate('Status')}}</th>
                                    <th>{{ translate('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($_num = 1)
                                @foreach($data as $v)
                                    <tr>
                                        <td>{{$_num++}}</td>
                                        <td>{{$v->created_at}}</td>
                                        <td>
                                            <a href="{{$v->banner_url}}" target="_blank">
                                            <img src="{{uploaded_asset($v->banner)}}" style="width: 50px; border-radius: 5px" class="shadow-sm hov-shadow">
                                            </a>
                                        </td>
                                        <td>{{$v->status===1?'Running':'Pending'}}</td>
                                        <td>
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

                </div>
            </div>
        </div>
    </section>

@endsection

@section('modal')
@include('modals.delete_modal')
@endsection

@section('script')

@endsection
