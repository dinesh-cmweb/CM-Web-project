<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieForm;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieGenre;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::with('moviesGenre')->get();
        $genres = Genre::all();

        return response()->json(['movies' => $movies, 'genres' => $genres]);
        //        return view('app', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieForm $request)
    {

        $name = $request->name;
        $director = $request->director;
        $producer = $request->producer;
        $releaseDate = $request->release_date;
        $verdict = $request->verdict;
        $genre = $request->movie_genre;

        // echo $name, $director, $producer, $releadDate;
        // print_r($genre);
        $movie = new Movie;
        $movie->name = $name;
        $movie->director = $director;
        $movie->producer = $producer;
        $movie->release_date = $releaseDate;
        $movie->verdict = $verdict;
        $movie->save();
        $data = [];
        for ($i = 0; $i < count($genre); $i++) {
            $data[$i]['movie_id'] = $movie->id;
            $data[$i]['genre'] = $genre[$i];
        }
        MovieGenre::insert($data);

        return response()->json([
            'status' => 200,
            'message' => 'movie added successfully.',
        ]);
        // return "store";
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        // $movies = Movie::with('MoviesGenre')->get();
        $movie = Movie::with('MoviesGenre')->find($movie->id);

        return response()->json(['movie' => $movie]);
        // return view('app', compact('edit', 'movies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieForm $request, string $id)
    {
        $update = Movie::find($id);

        $update->name = $request->name;
        $update->director = $request->director;
        $update->producer = $request->producer;
        $update->release_date = $request->release_date;
        $update->verdict = $request->verdict;
        $update->save();
        $deleteOld = MovieGenre::where('movie_id', $id);
        $deleteOld->delete();

        $genre = $request->movie_genre;
        $data = [];
        for ($i = 0; $i < count($genre); $i++) {
            $data[$i]['movie_id'] = $id;
            $data[$i]['genre'] = $genre[$i];
        }
        // print_r($data);
        MovieGenre::insert($data);

        return response()->json([
            'status' => 200,
            'message' => 'updated successfully',
        ]);
        // return $genre;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);
        $movie->delete();

        return response()->json([
            'status' => 200,
            'message' => 'movie deleted successfully.',
        ]);
        // return "delete";
    }
}
