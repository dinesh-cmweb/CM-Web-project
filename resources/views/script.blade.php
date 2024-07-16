<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        fetchdata();

        function fetchdata() {
            $.ajax({
                type: "GET",
                url: "{{route('movie.index')}}",
                dataType: "json",
                success: function(response) {
                    // console.log(response.movies);
                    $('#movies-genre').empty();
                    $.each(response.genres, function(key, genre) {
                        $('#movies-genre').append(
                            '<div class="form-check d-block">\
                        <input class="form-check-input" type="checkbox" value="' + genre.value + '" id="' + genre
                                .value + '" name="movie_genre[]">\
                        <label class="form-check-label" for="' + genre.value + '">' + genre.label_name + '</label>\
                        </div>'
                        )
                    });
                    var tbody = $('#tbody').html("");
                    // var p = $('#p').val() = movies[0].name;
                    $.each(response.movies, function(index, movie) {
                        // console.log(movie)
                        var genre = "";
                        $.each(movie.movies_genre, function(index, value) {
                            genre += value.genre + " ";
                        })

                        $('#tbody').append("<tr>\
                                <td>" + movie.id + "</td>\
                                <td>" + movie.name + "</td>\
                                <td>" + movie.director + "</td>\
                                <td>" + movie.producer + "</td>\
                                <td>" + movie.release_date + "</td>\
                                <td>" + genre + "</td>\
                                <td>" + movie.verdict + "</td>\
                                @if (Auth::check())\
                                <td><button type= 'button' value='" + movie.id +
                            "'class='btn btn-primary editbtn btn-sm'>Edit</button> <button type='button' value=" +
                            movie.id + " class='btn btn-danger deletebtn btn-sm'>Delete</button></td>\
                                @endif\
                                \</tr>");
                    })
                }
            })
        }

        $('#submit').on('click', function(e) {
            e.preventDefault();

            if ($('input[name="id"]').val() !== '') {
                url = "{{route('movie.update' , ':id')}}".replace(':id', $('input[name="id"]').val());
                type = 'PUT'
            } else {
                url = "{{route('movie.store')}}";
                type = 'POST'
            }

            var movieGenre = [];
            $(':checkbox:checked').each(function(i) {
                movieGenre[i] = $(this).val();
            });
            // alert(movie_genre);
            var data = {
                'name': $('#name').val(),
                'director': $('#director').val(),
                'producer': $('#producer').val(),
                'release_date': $('#release_date').val(),
                'verdict': $("input[type='radio']:checked").val(),
                'movie_genre': movieGenre,
            }
            $.ajaxSetup({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                type: type,
                url: url,
                data: data,
                dataType: "json",
                success: function(response) {
                    // console.log(response.status);
                    if (response.status == 200) {
                        $('#id').val('');
                        $('form').trigger('reset');
                        $('#error').empty();
                        fetchdata();
                    }
                },
                error: function(response) {
                    errors = [];
                    var errors = response.responseJSON.errors;
                    $(errors).each(function(key, value) {
                        $('#error').empty();
                        $.each(value, function(key, error) {
                            // console.log(error);
                            $("#error").append("<div>" + error + "</div>");
                        });
                    });
                }
            });
        });

        $(document).on('click', '.deletebtn', function() {
            var result = confirm('Are you sure you want to delete?');
            if (result) {
                var id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "{{route('movie.destroy' , ':id')}}".replace(':id', id),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 200) {
                            // console.log('status code:' + response.status +
                            //     '\n' + response.message);
                            fetchdata();
                        }
                    },
                    error: function(response) {
                        console.log("Error Code: " + response.status + "\nmessage: " +
                            response.statusText);
                    }
                });
            }
        });

        $(document).on('click', '.editbtn', function() {
            var id = $(this).val();
            $.ajax({
                type: 'GET',
                url: "{{route('movie.edit', ':id')}}".replace(':id', id),
                dataType: 'json',
                success: function(movie) {

                    $.each(movie, function(key, editMovie) {

                        var genres = [];
                        $.each(editMovie.movies_genre, function(key, value) {
                            genres.push(value.genre)
                        });

                        $('#id').val(editMovie.id);
                        $('#name').val(editMovie.name);
                        $('#director option').each(function() {
                            if ($(this).val() === editMovie.director) {
                                $(this).prop('selected', true);
                            }
                        });
                        $('#producer option').each(function() {
                            if ($(this).val() === editMovie.producer) {
                                $(this).prop('selected', true);
                            }
                        });
                        $('#release_date').val(editMovie.release_date);
                        $('input[name="verdict"][value="' + editMovie.verdict +
                                '"]')
                            .prop('checked', true);

                        $('input[name="movie_genre[]"]').each(function() {
                            if (genres.includes($(this).val())) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });
                    });
                }
            });
        });

        $('#login').on('click', function(e) {
            e.preventDefault();
            var data = {
                'email': $('#email').val(),
                'password': $('#password').val(),
            }

            $.ajaxSetup({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{route('login')}}",
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        window.location.href = "{{route('movies')}}";
                    } else if (response.status === 401) {
                        console.log("Error Code: " + response.status + "\nmessage: " +
                            response.message);
                        $('#error').empty();
                        $("#error").append("<div>" + response.message +
                            "</div>")
                    }
                },
                error: function(response){
                    console.log(response);
                    let errors = response.responseJSON.errors;
                    $(errors).each(function(key, value) {
                        $('#error').empty();
                        $.each(value, function(key, error) {
                            // console.log(error);
                            $("#error").append("<div>" + error + "</div>");
                        });
                    });
                }
            });
        });

        $('#register').on('click', function(e) {
            e.preventDefault();
            var data = {
                'name': $('#registerName').val(),
                'email': $('#registerEmail').val(),
                'password': $('#registerPassword').val(),
                'password_confirmation': $('#confirmPassword').val(),
            }

            $.ajaxSetup({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{route('register')}}",
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        // console.log('status code:' + response.status +
                        //     '\n' + response.message);
                        window.location.href = "{{route('movies')}}";
                    } else if (response.status === 422) {
                        console.log("Error Code: " + response.status + "\nmessage: " +
                            response.message);
                    }
                },
                error: function(response) {
                    console.log("Error Code: " + response.status + "\nmessage: " + response
                        .responseJSON.message);
                    $('#registerError').empty();
                    $("#registerError").append("<div>" + response.responseJSON.message + "</div>")
                }
            })
        });

        $('#logout').on('click', function() {
            $.ajaxSetup({
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{route('logout')}}",
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        // console.log('status code:' + response.status +
                        //     '\n' + response.message);
                        window.location.href = "{{route('movies')}}";
                    }
                }
            });
        })
    });
</script>
