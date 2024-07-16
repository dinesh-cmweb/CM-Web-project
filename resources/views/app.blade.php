<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container my-5">
        {{-- {{ $edit }} --}}
        @if (!empty($edit))
            @php
                // $genres = $edit->MoviesGenre;
                $genres = [];
                for ($i = 0; $i < count($edit->MoviesGenre); $i++) {
                    $genres[$i] = $edit->MoviesGenre[$i]['genre'];
                }
                // print_r($genres);
            @endphp
        @endif
        <form class="container w-50 shadow p-3 mb-5 bg-body rounded"
            action="{{ !empty($edit) ? route('movie.update', $edit->id) : route('movie.store') }}" method="POST">
            @csrf
            {{-- @method('PUT') --}}
            <div class="mb-3">
                <label for="movie_name" class="">Movie Name: </label>
                <input type="text" class="form-control" id="name" aria-describedby="Name" name="name"
                    value="{{ !empty($edit->name) ? $edit->name : null }}" required>
            </div>
            <div class="mb-3">
                <label for="directors" class="form-label">Director:</label>
                <select class="form-select" aria-label="Default select example" name="director" required>
                    <option>Director</option>
                    <option value="Director 1"
                        {{ !empty($edit->director) && $edit->director == 'Director 1' ? 'selected' : null }}>Director 1
                    </option>
                    <option value="Director 2"
                        {{ !empty($edit->director) && $edit->director == 'Director 2' ? 'selected' : null }}>Director 2
                    </option>
                    <option value="Director 3"
                        {{ !empty($edit->director) && $edit->director == 'Director 3' ? 'selected' : null }}>Director 3
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="producers" class="form-label">Producer:</label>
                <select class="form-select" aria-label="Default select example" name="producer" required>
                    <option>Producers</option>
                    <option value="Producer 1"
                        {{ !empty($edit->producer) && $edit->producer == 'Producer 1' ? 'selected' : null }}>Producer 1
                    </option>
                    <option value="Producer 2"
                        {{ !empty($edit->producer) && $edit->producer == 'Producer 2' ? 'selected' : null }}>Producer 2
                    </option>
                    <option value="Producer 3"
                        {{ !empty($edit->producer) && $edit->producer == 'Producer 3' ? 'selected' : null }}>Producer 3
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="release_dates" class="form-label">Release Date:</label>
                <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    name="release_date" value="{{ !empty($edit->release_date) ? $edit->release_date : null }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Hit or Flop:</label>
                <input type="radio" id="hit" name="verdict" value="hit"
                    {{ !empty($edit->verdict) && $edit->verdict == 'hit' ? 'checked' : null }} required>
                <label for="hit">Hit</label>
                <input type="radio" id="flop" name="verdict" value="flop"
                    {{ !empty($edit->verdict) && $edit->verdict == 'flop' ? 'checked' : null }} required>
                <label for="flop">Flop</label>
            </div>
            <div class="mb-3 d-flex">
                <div class="d-flex">
                    Movie Genre:
                </div>
                <div class="mx-2">
                    <div class="form-check d-block">
                        <input class="form-check-input" type="checkbox" value="Action" id="Action"
                            name="movie_genre[]"
                            {{ !empty($edit->MoviesGenre) && in_array('Action', $genres) ? 'checked' : null }}>
                        <label class="form-check-label" for="Action">
                            Action
                        </label>
                    </div>
                    <div class="form-check d-block">
                        <input class="form-check-input" type="checkbox" value="Romantic" id="Romantic"
                            name="movie_genre[]"
                            {{ !empty($edit->MoviesGenre) && in_array('Romantic', $genres) ? 'checked' : null }}>
                        <label class="form-check-label" for="Romantic">
                            Romantic
                        </label>
                    </div>
                    <div class="form-check d-block">
                        <input class="form-check-input" type="checkbox" value="Horror" id="Horror"
                            name="movie_genre[]"
                            {{ !empty($edit->MoviesGenre) && in_array('Horror', $genres) ? 'checked' : null }}>
                        <label class="form-check-label" for="Horror">
                            Horror
                        </label>
                    </div>
                </div>
            </div>
            <div class="container d-flex  justify-content-center">
                <button type="submit" class="btn btn-success mx-1">Submit</button>
                <button type="reset" class="btn btn-success mx-1">reset</button>
            </div>
        </form>
    </div>
    <table class="table table-bordered text-center">
        <thead class="table-dark text-white">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Director</th>
                <th>Producer</th>
                <th>Release Date</th>
                <th>Movie Genre</th>
                <th>Verdict</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbody">
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie['id'] }}</td>
                    <td>{{ $movie['name'] }}</td>
                    <td>{{ $movie['director'] }}</td>
                    <td>{{ $movie['producer'] }}</td>
                    <td>{{ $movie['release_date'] }}</td>
                    <td>
                        @foreach ($movie['moviesGenre'] as $genre)
                            {{ $genre->genre }},
                        @endforeach
                    </td>
                    <td>{{ $movie['verdict'] }}</td>
                    <td>
                        <a class="btn btn-success btn-sm mb-1" href="{{ route('movie.edit', $movie->id) }}">edit</a>
                        <form action="{{ route('movie.destroy', $movie->id) }}" class="mt-1" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-success btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    @extends('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

</html>
