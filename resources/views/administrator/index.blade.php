@extends('administrator.layouts.default')

@section('content')

    @if($displayStatistics)
    <script>
        var jsonLastDay = {!! $jsonLastDay !!};
        var jsonLastMonth = {!! $jsonLastMonth !!};
    </script>

<div class="main-container">

    <div class="main-content">
        <section>
            <div class="page-header">
                <h1>{{ trans('admin.index_dashboard') }}</h1>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="no-margin grey-text w600">{{ trans('admin.index_stat_visitors_last_day') }}</h4>
                        <div class="f11" style="opacity:0.8"> <i class="md md-star-outline"></i>
                            {{ Date::parse('-1 day')->format('d F Y, H:i:s') }} - {{ Date::now()->format('d F Y H:i:s') }}
                        </div>

                        @if(json_decode($jsonLastDay))
                            <div id="chart-last-day" style="width: 100%; height: 265px;"></div>
                        @else
                            <div class="alert alert-info" style="margin-top: 30px;">Stats for selected period of time are empty.</div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card p-3">
                        <h4 class="no-margin grey-text w600">{{ trans('admin.index_stat_visitors_last_month') }}</h4>
                    <div class="f11" style="opacity:0.8"> <i class="md md-star-outline"></i>
                        {{ Date::parse('-1 month')->format('d F Y') }} - {{ Date::now()->format('d F Y') }}
                    </div>

                    @if(json_decode($jsonLastMonth))
                        <div id="chart-last-month" style="width: 100%; height: 265px;"></div>
                    @else
                        <div class="alert alert-info" style="margin-top: 30px;">Stats for selected period of time are empty.</div>
                    @endif
                </div>
                </div>



                <div class="col-md-6">
                    <div class="card small white no-margin">
                        <div class="card-content p-10">
                            <div class="row">
                                <div class="col-md-6 text-center" style="border-right: 1px #F0F0F0 solid;">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsToday)? $visitorsAndPageViewsToday->visitors : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_visitors_today') }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsToday)? $visitorsAndPageViewsToday->pageViews : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_page_views_today') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card small white">
                        <div class="card-content p-10">
                            <div class="row">
                                <div class="col-md-6 text-center" style="border-right: 1px #F0F0F0 solid;">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsYesterday) ? $visitorsAndPageViewsYesterday->visitors : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_visitors_yesterday') }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsYesterday) ? $visitorsAndPageViewsYesterday->pageViews : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_page_views_yesterday') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card small white no-margin">
                        <div class="card-content p-10">
                            <div class="row">
                                <div class="col-md-6 text-center" style="border-right: 1px #F0F0F0 solid;">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsThisMonth) ? $visitorsAndPageViewsThisMonth->visitors : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_visitors_this_month') }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsThisMonth) ? $visitorsAndPageViewsThisMonth->pageViews : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_page_views_this_month') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card small white">
                        <div class="card-content p-10">
                            <div class="row">
                                <div class="col-md-6 text-center" style="border-right: 1px #F0F0F0 solid;">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsLastMonth) ? $visitorsAndPageViewsLastMonth->visitors : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_visitors_last_month') }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <h3 class="no-margin w300">{{ is_object($visitorsAndPageViewsLastMonth) ? $visitorsAndPageViewsLastMonth->pageViews : 0 }}</h3>
                                    <p class="grey-text w600">{{ trans('admin.index_stat_page_views_last_month') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

    @else
    <div class="main-container">

        <div class="main-content">
            <section>
                <div class="page-header">
                    <h1>{{ trans('admin.index_dashboard') }}</h1>
                </div>
            </section>

            <div class="alert alert-info">@lang('admin.index_empty', ['url' => url('administrator/settings/statistics')])</div>
        </div>
    </div>
    @endif
@endsection
