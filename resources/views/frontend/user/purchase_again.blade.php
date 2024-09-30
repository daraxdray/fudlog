@extends('frontend.layouts.app')

@section('content')

<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Buy Again') }}</h5>
                    </div>
                    @if (count($orders) > 0)
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ translate('Date')}}</th>
                                        <th>{{ translate('Amount')}}</th>
                                        <th>{{ translate('Delivery Status')}}</th>
                                        <th>{{ translate('Payment Status')}}</th>
                                        <th class="text-right">{{ translate('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        @if (count($order->orderDetails) > 0)
                                            <tr>
                                                <td>{{ date('d-m-Y', $order->date) }}</td>
                                                <td>
                                                    {{ single_price($order->grand_total) }}
                                                </td>
                                                <td>
                                                    {{ translate(ucfirst(str_replace('_', ' ', $order->orderDetails->first()->delivery_status))) }}
                                                    @if($order->delivery_viewed == 0)
                                                        <span class="ml-2" style="color:green"><strong>*</strong></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($order->payment_status == 'paid')
                                                        <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                                                    @else
                                                        <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                                                    @endif
                                                    @if($order->payment_status_viewed == 0)
                                                        <span class="ml-2" style="color:green"><strong>*</strong></span>
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    <a class="btn btn-soft-danger  btn-sm" href="{{ route('productId', $order->orderDetails[0]['product_id']) }}" title="{{ translate('Buy Again') }}">
                                                        Buy Again
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                	{{ $orders->links() }}
                          	</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('modal')
    @include('modals.delete_modal')

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="payment_modal_body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('#order_details').on('hidden.bs.modal', function () {
            location.reload();
        })
    </script>

@endsection
