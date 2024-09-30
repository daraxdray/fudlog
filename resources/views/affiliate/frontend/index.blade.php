@extends('frontend.layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Networking Associates') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row gutters-10">
                        <div class="col-md-4 mx-auto mb-3">
                            <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                            <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                                <i class="las la-dollar-sign la-2x text-white"></i>
                            </span>
                                <div class="px-3 pt-3 pb-3">
                                    <div class="h4 fw-700 text-center">{{ single_price(Auth::user()->affiliate_user->balance) }}</div>
                                    <div class="opacity-50 text-center">{{ translate('My Balance') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mx-auto mb-3">
                            <a href="{{ route('affiliate.payment_settings') }}">
                                <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                                    <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                        <i class="las la-dharmachakra la-3x text-white"></i>
                                    </span>
                                    <div class="fs-18 text-primary">{{ translate('Configure Payout') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mx-auto mb-3">
                            <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition"
                                 onclick="show_affiliate_withdraw_modal()">
                              <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                  <i class="las la-plus la-3x text-white"></i>
                              </span>
                                <div class="fs-18 text-primary">{{  translate('Withdraw Request') }}</div>
                            </div>
                        </div>
                    </div>

                    @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && \App\AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status)
                        <div class="row">
                            @php
                                if(Auth::user()->referral_code == null){
                                    Auth::user()->referral_code = substr(Auth::user()->id.Str::random(), 0, 10);
                                    Auth::user()->save();
                                }
                                $referral_code = Auth::user()->referral_code;
                                $referral_code_url = URL::to('/users/registration')."?referral_code=$referral_code";
                            @endphp
                            <div class="col-6">
                                <div class="card">
                                    <div class="form-box-content p-3">
                                        <div class="form-group">
                                            <textarea id="referral_code_url" class="form-control" readonly type="text" style="height: 100px">{{$referral_code_url}}</textarea>
                                        </div>
                                        <button type=button id="ref-cpurl-btn" class="btn btn-primary"
                                                data-attrcpy="{{translate('Copied')}}"
                                                onclick="copyToClipboard('url')">{{translate('Copy Url')}}</button>
                                        <a target="_blank" href="<?php echo $referral_code_url; ?>" type=button
                                           class="btn btn-primary text-white float-right">{{translate('Add New Customer')}}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0 fs-14">{{ translate('Payment History') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="pie-1" class="w-100" height="100"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{ translate('Payment history')}}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table aiz-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{translate('Amount')}}</th>
                                            <th>{{translate('Payment Method')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($affiliate_payments as $key => $affiliate_payment)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ date('d-m-Y', strtotime($affiliate_payment->created_at)) }}</td>
                                                <td>{{ single_price($affiliate_payment->amount) }}</td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $affiliate_payment ->payment_method)) }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination">
                                        {{ $affiliate_payments->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{ translate('Withdraw request history')}}</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table aiz-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ translate('Date') }}</th>
                                            <th>{{ translate('Amount')}}</th>
                                            <th>{{ translate('Status')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($affiliate_withdraw_requests as $key => $affiliate_withdraw_request)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ date('d-m-Y', strtotime($affiliate_withdraw_request->created_at)) }}</td>
                                                <td>{{ single_price($affiliate_withdraw_request->amount) }}</td>
                                                <td>
                                                    @if($affiliate_withdraw_request->status == 1)
                                                        <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                                                    @elseif($affiliate_withdraw_request->status == 2)
                                                        <span class="badge badge-inline badge-danger">{{translate('Rejected')}}</span>
                                                    @else
                                                        <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination">
                                        {{ $affiliate_withdraw_requests->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')

    <div class="modal fade" id="affiliate_withdraw_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Withdraw Request') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="" action="{{ route('affiliate.withdraw_request.store') }}" method="post">
                    @csrf
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{ translate('Amount')}} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control mb-3" name="amount" min="1"
                                       max="{{ Auth::user()->affiliate_user->balance }}"
                                       placeholder="{{ translate('Amount')}}" required>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit"
                                    class="btn btn-sm btn-primary transition-3d-hover mr-1">{{translate('Confirm')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        function copyToClipboard(btn) {
            // var el_code = document.getElementById('referral_code');
            var el_url = document.getElementById('referral_code_url');
            // var c_b = document.getElementById('ref-cp-btn');
            var c_u_b = document.getElementById('ref-cpurl-btn');

            // if(btn == 'code'){
            //     if(el_code != null && c_b != null){
            //         el_code.select();
            //         document.execCommand('copy');
            //         c_b .innerHTML  = c_b.dataset.attrcpy;
            //     }
            // }

            if (btn == 'url') {
                if (el_url != null && c_u_b != null) {
                    el_url.select();
                    document.execCommand('copy');
                    c_u_b.innerHTML = c_u_b.dataset.attrcpy;
                }
            }
        }

        function show_affiliate_withdraw_modal() {
            $('#affiliate_withdraw_modal').modal('show');
        }
        //graph
        AIZ.plugins.chart('#pie-1',{
            type: 'doughnut',
            data: {
                labels: [
                    '{{translate('Total referrer')}}',
                    '{{translate('Total history')}}',
                    '{{translate('Total earning')}}'
                ],
                datasets: [
                    {
                        data: [
                            {{ \App\Product::where('published', 1)->get()->count() }},
                            {{ \App\Product::where('published', 1)->where('added_by', 'seller')->get()->count() }},
                            {{ \App\Product::where('published', 1)->where('added_by', 'admin')->get()->count() }}
                        ],
                        backgroundColor: [
                            "#fd3995",
                            "#34bfa3",
                            "#5d78ff",
                            '#fdcb6e',
                            '#d35400',
                            '#8e44ad',
                            '#006442',
                            '#4D8FAC',
                            '#CA6924',
                            '#C91F37'
                        ]
                    }
                ]
            },
            options: {
                cutoutPercentage: 70,
                legend: {
                    labels: {
                        fontFamily: 'Poppins',
                        boxWidth: 10,
                        usePointStyle: true
                    },
                    onClick: function () {
                        return '';
                    },
                    position: 'bottom'
                }
            }
        });
    </script>
@endsection
