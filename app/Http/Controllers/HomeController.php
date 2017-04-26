<?php

/**
* Created by Adnan Mauludin Fajriyadi
* "Peningkatan Relevansi Pencarian Produk Halal Dalam Aplikasi Halal Nutrition Food Menggunakan Algoritma OKAPI BM25F"
*
* April 2017
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * @var The SOLR client.
     */
    protected $client;

    /**
     * Constructor
     **/
    public function __construct(\Solarium\Client $client)
    {
        $this->client = $client;
    }

    public function ping()
    {
        // create a ping query
        $ping = $this->client->createPing();

        // execute the ping query
        try {
            $this->client->ping($ping);
            return response()->json('OK');
        } catch (\Solarium\Exception $e) {
            return response()->json('ERROR', 500);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Input::has('q')) {
            $query = $client->createSelect();
            $query->setQuery(Input::get('q'));

            // manually create a request for the query
            $request = $client->createRequest($query);
            $request->setHandler('bm25f');

            // Execute the query and return the result
            $resultset = $this->client->select($query);

            // Pass the resultset to the view and return.
            return view('pages.home', array(
                'q' => Input::get('q'),
                'resultset' => $resultset,
            ));
        }

        // No query to execute, just return the search form.
        return view('pages.home');
    }

    public function search()
    {
        if (Input::has('q')) {
            $query = $client->createSelect();
            $query->setQuery(Input::get('q'));

            // manually create a request for the query
            $request = $client->createRequest($query);
            $request->setHandler('bm25f');

            // Execute the query and return the result
            $resultset = $this->client->select($query);

            // Pass the resultset to the view and return.
            return view('pages.home', array(
                'q' => Input::get('q'),
                'resultset' => $resultset,
            ));
            }

        // No query to execute, just return the search form.
        return View::make('pages.home');
    }
}
