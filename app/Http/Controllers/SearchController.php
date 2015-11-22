<?php

namespace LibrosJB\Http\Controllers;

use LibrosJB\Author;
use LibrosJB\Publisher;
use Illuminate\Http\Request;
use LibrosJB\Http\Requests;
use LibrosJB\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function findByAuthorName()
    {
        $query = e(request()->input('q'));
        $results = Author::where('name', 'LIKE', '%'.$query.'%')
        ->get(['id', 'name']);

        return response()->json($results);
    }

    public function findByPublisherName()
    {
        $query = e(request()->input('q'));
        $results = Publisher::where('name', 'LIKE', '%'.$query.'%')
        ->get(['id', 'name']);

        return response()->json($results);
    }
}
