@if($event)
<div style="width: 900px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #dcdcdc;">
    <div style="float: left; width: 431px; padding-right: 20px; text-align: right;">
        <div style="float: right; width: 280px; height: 170px; overflow: hidden;">
            @if($event->filename && file_exists('upload/events/m/' . $event->filename))
            <img style="border-radius: 5px;" src="{{ url('upload/events/m/' . $event->filename) }}" alt="">
            @else
            <img style="border-radius: 5px;" src="{{ url('assets/page/images/event_newsletter.jpg') }}" alt="">
            @endif
        </div>
    </div>
    <div style="float: left; width: 433px;">
            <h3 style="margin-top: 0px;">
                <img style="border-radius: 5px;" src="{{ url('assets/page/images/icon_event.png') }}" alt="">
                {{ $event->name }}
            </h3>

            <p>
                {{ Str::limit(strip_tags($event->description), 200) }}
            </p>

        <div style="height: 40px;">
            <a href="{{ \Page::link(['type' => 'events'], [], $event->id) }}" style="display: inline-block; float: left; padding: 5px 8px; border-radius: 4px; background: #2980b9; color: #fff; text-decoration: none;">{{ trans('email.newsletter_event_more') }}</a>
            
            <a href="{{ \Page::link(['type' => 'events']) }}" style="float: right; font-size: 10px; padding-top: 8px; font-weight: bold;">
                {{ trans('email.newsletter_event_all') }}
            </a>
        </div>
    </div>
    <br style="clear: both;">
</div>
@endif
