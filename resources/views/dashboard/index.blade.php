@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Blank Page
                <small>it all start here</small>
            </h1>
            <ol class="breadcrumb"></ol>

        </section>
        <section class="content">
            <div class="box box-primery">
                <div class="box-header">
                    <h3 class="box-title">Quick Example</h3>

                </div><!-- </div> end of box header -->
                <div class="box-body">
                    <h1>testing</h1>
                </div>
            </div> <!--end of header-->

            <h1>@lang('site.users')</h1>
            <small>it all start here</small>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>@lang('site.dashboard')</a></li>
                <li class="active">@lang('site.users')</li>
            </ol>

        </section>
    </div>
@endsection
