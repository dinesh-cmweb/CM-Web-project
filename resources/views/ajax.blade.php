<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Laravel-ajax</title>
</head>

<body>
    {{-- add movie form --}}
    @if (Auth::check())
        <div class="container my-3 d-flex justify-content-end">
            <button type="button" class="m-1 btn btn-primary" id="logout">Logout</button>
        </div>
        {{-- Add movie Form --}}
        <div class="container my-3">
            <div class="mb-2 container alert-danger w-25" role='alert' id="error"></div>
            <form class="container w-50 shadow p-3 mb-5 bg-body rounded" method="POST">
                <div class="mb-3">
                    <input type="hidden" name="id" id="id" value="">
                    <label for="name" class="">Movie Name: </label>
                    <input type="text" class="form-control" id="name" aria-describedby="Name" name="name"
                        value="" required>
                </div>
                <div class="mb-3">
                    <label for="director" class="form-label">Director:</label>
                    <select class="form-select" aria-label="Default select example" name="director" id="director"
                        required>
                        <option value="">Directors</option>
                        <option value="Director 1">Director 1 </option>
                        <option value="Director 2">Director 2 </option>
                        <option value="Director 3">Director 3 </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="producer" class="form-label">Producer:</label>
                    <select class="form-select" aria-label="Default select example" name="producer" id="producer"
                        required>
                        <option value="">Producers</option>
                        <option value="Producer 1">Producer 1 </option>
                        <option value="Producer 2">Producer 2 </option>
                        <option value="Producer 3">Producer 3 </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="release_date" class="form-label">Release Date:</label>
                    <input type="date" class="form-control" id="release_date" aria-describedby="emailHelp"
                        name="release_date" value="" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="hit">Hit or Flop:</label>
                    <input type="radio" id="hit" name="verdict" value="hit">
                    <label for="hit">Hit</label>
                    <input type="radio" id="flop" name="verdict" value="flop">
                    <label for="flop">Flop</label>
                </div>
                <div class="mb-3 d-flex">
                    <div class="d-flex">
                        Movie Genre:
                    </div>
                    <div id="movies-genre" class="mx-2">
                        {{-- append the movies_genre checkbox using ajax --}}
                    </div>
                </div>
                <div class="container d-flex  justify-content-center">
                    <button type="submit" id="submit" class="btn btn-success mx-1">Submit</button>
                    <button type="reset" class="btn btn-success mx-1">reset</button>
                </div>
            </form>
        </div>
    @else
        <div class="conatiner m-3 d-flex justify-content-end">
            <!-- Button trigger Login modal -->
            <button type="button" class="m-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                Login </button>
            <!-- Button trigger register modal -->
            <button type="button" class="m-1 btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                Register </button>
        </div>
    @endif

    <!-- User Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2 container alert-danger" role='alert' id="error"></div>
                    <form method="POST" class="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="login" class="btn btn-primary">Login</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- User Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2 container alert-danger" role='alert' id="registerError"></div>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="registerName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="registerName"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="registerEmail"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" autocomplete="off">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="register" class="btn btn-primary">Register</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                @if (Auth::check())
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody id="tbody">
            {{-- add append from ajax.blade.php usign jquery --}}
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
