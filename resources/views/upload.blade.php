<html>
<body>
<form class="form-group d-flex justify-content-center" action="{{ url('/api/prepare') }}" method="post" enctype="multipart/form-data">
    <div class="form-field">
        <label for="file">Dodaj plik</label>
        <input name="file[]" type="file">
    </div>

    <label>
        Nazwa pliku
        <input type="text" name="name">
    </label>
    <input type="submit" name="submit" value="Wyślij na serwer" class="button">
    @if(isset($message))
        <div class="alert-success">{{$message}}</div>
    @elseif(isset($error))
        <div class="alert-warning">{{ $error }}</div>
    @endif
</form>

<div class="list-group">
        @foreach($data as $elem)
            <li>
                <a href="download?name={{$elem->name}}&ext={{$elem->extension}}">
                    {{ $elem->name }}
                </a>
            </li>
        @endforeach
    </ul>

</div>

</body>
</html>
