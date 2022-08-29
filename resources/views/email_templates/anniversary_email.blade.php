<h3>Dear {{$anniversary->first_name}},</h3><br>
<p>Thank you for being a valuable part of the ConvexTech family.</p>
<div class="row">
    <div class="col-md-6">
        <img src="{{ $message->embed(public_path() . '/images/happy_anniversary.png') }}" alt="Birthday Image"/>
    </div>
</div>
