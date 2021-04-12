@extends('layout.app')

@include('includes.registration.background')

@section('content')

    <section class="section-container">
        <!-- Page content-->
        <div class="content-wrapper">

            <div class="content-heading">
                <div>Foreigner SIM Registration
                    <p class="lead mt-2">KYC Details</p>
                </div>
            </div>

            @include('layout.flash-messages')

            <!-- START cards box-->
                <!-- END cards box-->
                <div class="row">
                    <!-- START dashboard main content-->
                    <div class="col-xl-12">
                        {{-- <div id="error-message" class="align-center"></div> --}}
                        <blockquote id="flash-message" ></blockquote>
                        <div class="card b">
                            <div class="card-body">
                                <form method="post" action="{{ action('KYCController@checkMSISDN_newReg') }}" id="checkMSISDNIcapForm" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-group with-focus mb-2">
                                            <input name="phoneNumber" class="form-control" id="exampleInputEmail1" type="text" placeholder="Enter Mobile Number e.g 0754000000" autocomplete="off" required>
                                            <div class="input-group-append">
                                                <button id="checkMsisdnIcapBtn" class="btn btn-block btn-info" type="submit">
                                                <span class="fa fa-search-plus"></span> Check Number</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- END dashboard main content-->
                </div>
        </div>

    </section>
@endsection

@section('scripts')

@include('register.foreigner.new.foreigner-new-reg-modal')

<script src="{{ asset('js/vtlbio.js') }}"></script>

    <script>
        var x = new VTLBion();
        x.Init("Div_fingerprint");
    </script>

<script src="{{ asset('js/foreigner-new-reg.js') }}"></script>

@endsection

