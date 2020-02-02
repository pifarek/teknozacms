@if($news)
<div style="width: 900px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #dcdcdc;">
    <div style="float: left; width: 431px; padding-right: 20px; text-align: right;">
        <div style="float: right; width: 280px; height: 170px; overflow: hidden;">
            @if($news->filename && file_exists('upload/news/m/' . $news->filename))
            <img style="border-radius: 5px;" src="{{ url('upload/news/m/' . $news->filename) }}" alt="">
            @else
            <img style="border-radius: 5px;" src="{{ url('assets/page/images/news_newsletter.jpg') }}" alt="">
            @endif
        </div>
    </div>
    <div style="float: left; width: 433px;">
        <h3 style="margin-top: 0px;">
            <img style="border-radius: 5px;" src="{{ url('assets/page/images/icon_news.png') }}" alt="">
            {{ $news->title }}
        </h3>

        <p>
            {{ \Illuminate\Support\Str::limit(strip_tags($news->content), 200) }}
        </p>

        <div style="height: 40px;">
            <a href="{{ Page::link(['type' => 'news'], [], $news->slug) }}" style="display: inline-block; float: left; padding: 5px 8px; border-radius: 4px; background: #2980b9; color: #fff; text-decoration: none;">{{ trans('email.newsletter_news_more') }}</a>

            <a href="{{ Page::link(['type' => 'news']) }}" style="float: right; font-size: 10px; padding-top: 8px; font-weight: bold;">
                {{ trans('email.newsletter_news_all') }}
            </a>
        </div>
    </div>
    <br style="clear: both;">
</div>
@endif
