<h3>Dear {{$birthday->first_name}},</h3><br>
<p>Wishing you a magical birthday filled with wonderful surprises.</p>
<div class="row">
    <div class="col-md-6">
        <img src="{{ $message->embed(public_path() . '/images/happy_birthday.jpg') }}" alt="Birthday Image"/>
    </div>
</div>
