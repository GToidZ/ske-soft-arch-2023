<h1>Laravel Captcha</h1>
@if (session()->get('captcha_result'))
    <h2>{{ session()->get('captcha_result') }}</h2>
@endif
<form action="/captcha" method="POST">
    @csrf
    <label for="captcha">Type these letters:</label>
    <br>
    <img src="<?php echo $capt ?>" />
    <br>
    <input type="text" name="captcha" id="captcha" />
    <br>
    <input type="submit" value="Verify" />
</form>