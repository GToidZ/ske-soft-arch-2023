<h1>File Form</h1>

@if ($errors->any())
    <div>
        <ul>
        @foreach ($errors->all() as $e)
            <li style="color: red;">{{ $e }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form method="POST"
    action="/fileform"
    style="display: flex; flex-direction: column; max-width: 12rem;"
    enctype="multipart/form-data">
    @csrf <!-- For secure form actions -->
    <label for="myfile">My File</label>
    <input type="file" id="myfile" name="myfile" />

    <input type="submit" value="Send it!" />
</form>