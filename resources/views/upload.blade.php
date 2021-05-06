<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<div class="jumbotron">
    <h1 class="display-4">Serwis do wymiany plików klient-serwer</h1>
    <hr class="my-4">
    <p>Dodawaj oraz pobieraj pliki</p>
</div>

<form class="flex-column" action="{{ url('/api/prepare') }}" method="post" enctype="multipart/form-data">
    <div class="form-group justify-content-center"">
        <label for="file">Dodaj plik</label>
        <input name="file[]" type="file">
    </div>

    <div class="form-group">
        <label>
            Nazwa pliku
            <input type="text" name="name">
        </label>
        <input type="submit" name="submit" value="Wyślij na serwer" class="button">
    </div>


    @if(isset($message))
        <div class="alert alert-success">{{$message}}</div>
    @elseif(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif
</form>

<div>
    <ul class="list-group">
        <p>Pliki dostępne do pobrania:</p>
        @foreach($data as $elem)
            <li class="list-group-item">
                <a href="api/download?name={{$elem->name}}&ext={{$elem->extension}}">
                    {{ $elem->name }}
                </a>
            </li>
        @endforeach
    </ul>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</body>
</html>
