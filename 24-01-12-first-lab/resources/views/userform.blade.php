<h1>User Form</h1>

@if ($errors->any())
    <div>
        <ul>
        @foreach ($errors->all() as $e)
            <li style="color: red;">{{ $e }}</li>
        @endforeach
        </ul>
    </div>
@endif


<form method="POST" action="/userform" style="display: flex; flex-direction: column; max-width: 12rem;">
    @csrf <!-- For secure form actions -->
    <label for="email">Email</label>
    <input type="text" id="email" name="email" />

    <label for="username">Username</label>
    <input type="text" id="username" name="username" />

    <label for="password">Password</label>
    <input type="password" id="password" name="password" />

    <label for="password_confirm">Retype your Password</label>
    <input type="password" id="password_confirm" name="password_confirm" />
    
    <label for="color">Favorite Color</label>
    <select name="color" id="color">
        @foreach (['red', 'blue', 'green'] as $color)
        <option value="{{ $color }}">{{ $color }}</option>
        @endforeach
    </select>

    <input type="submit" value="Send it!" />
</form>