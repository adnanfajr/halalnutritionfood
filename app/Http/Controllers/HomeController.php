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
            $select = array(
                'query'         => Input::get('q'),
                'handler'       => 'bm25f',
                'start'         => 0,
                'rows'          => 10,
            );

            $query = $this->client->createSelect($select);

            // Query based on input user
            $query->setQuery(Input::get('q'));

            // add debug settings
            $debug = $query->getDebug();
            $debug->setExplainOther('id:MA*');

            // Execute the query and return the result
            $resultset = $this->client->select($query);

            // Debug result
            $debugResult = $resultset->getDebug();

            // Get query time in seconds
            $ms = $debugResult->getTiming()->getTime();
            $s = $ms/1000;

            // Pass the resultset to the view and return.
            return view('pages.v2.home', array(
                'q' => Input::get('q'),
                'resultset' => $resultset,
                'debugResult' => $debugResult,
                's' => $s,
            ));
        }

        // No query to execute, just return the search form.
        return view('pages.v2.home');
    }

    public function json()
    {
        if (Input::has('q')) {
            $select = array(
                'query'         => Input::get('q'),
                'handler'       => 'bm25f',
            );

            $query = $this->client->createSelect($select);

            // Query based on input user
            $query->setQuery(Input::get('q'));

            // add debug settings
            $debug = $query->getDebug();
            $debug->setExplainOther('id:MA*');

            // Execute the query and return the result
            $resultset = $this->client->select($query);

            // Debug result
            $debugResult = $resultset->getDebug();

            // Get query time in seconds
            $ms = $debugResult->getTiming()->getTime();
            $s = $ms/1000;

            // Result
            $resultnum = $resultset->getNumFound();
            $getquery = $debugResult->getQueryString();

            $results = array();
            foreach ($resultset as $document) {
                $item = array();
                foreach($document as $field => $value) {
                    $item[$field] = $value;
                }
                $results[] = $item;
            }

            // Pass the result to json
            return response()->json($data=['query'=>$getquery,'query_result'=>$resultnum,'query_time'=>$s,'response'=>$results], $status=200, $headers=[], $options=JSON_PRETTY_PRINT);
        }

        // No query to execute, 404.
        return response()->json('ERROR', 404);
    }
}
