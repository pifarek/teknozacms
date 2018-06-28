<div class="row">
    <div class="col-md-5">
        <a class="footer-logo" href="{{ url('/') }}"><img src="{{ url('assets/page/images/footer-logo.png') }}" alt=""></a>
    </div>
    <div class="col-md-3">
        <div class="footer-adress">
            <span>{{ $contact->street }} <br> {{ $contact->postal }} {{ $contact->city }}</span>
            <a href="{{ \Page::link(['type' => 'contact']) }}" target="_blank">{{ trans('page.contacts_map') }}</a>
        </div>
    </div>
    <div class="col-md-4">
        <ul class="footer-contact">
            <li>{{ $contact->phone }}</li>
            <li><a href="contact.html#">{{ $contact->email }}</a></li>
        </ul>
    </div>
</div>