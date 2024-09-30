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
                          <h1 class="h3">{{ translate('My Subscription') }}</h1>
                      </div>
                    </div>
                  </div>
                  <div class="row gutters-10">
                      <div class="col-md-8 mx-auto mb-3" >
                          <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                            <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                                <i class="las la-dollar-sign la-2x text-white"></i>
                            </span>
                            <div class="px-3 pt-3 pb-3">
                                <div class="h5 fw-700 text-center">{{ '0 Days' }}</div>
                                <div class="opacity-50 text-center">{{ translate('Expired | Remaining') }}</div>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-4 mx-auto mb-3" >
                        <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition" onclick="show_wallet_modal()">
                            <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                                <i class="las la-plus la-3x text-white"></i>
                            </span>
                            <div class="fs-12 text-primary">{{ translate('Subscribe Now') }}</div>
                        </div>
                      </div>
                  </div>

              </div>
          </div>
      </div>
  </section>
@endsection

@section('modal')

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
