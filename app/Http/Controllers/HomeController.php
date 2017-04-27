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
            // Check on food_code
            $qcode = array('query' => Input::get('q'),'querydefaultfield' => 'food_code');
            $q1 = $this->client->createSelect($qcode);
            $res1 = $this->client->select($q1);
            $numCode = $res1->getNumFound();
            // Check on food_name
            $qname = array('query' => Input::get('q'),'querydefaultfield' => 'food_name');
            $q2 = $this->client->createSelect($qname);
            $res2 = $this->client->select($q2);
            $numName = $res2->getNumFound();
            // Check on food_man
            $qman = array('query' => Input::get('q'),'querydefaultfield' => 'food_man');
            $q3 = $this->client->createSelect($qman);
            $res3 = $this->client->select($q3);
            $numMan = $res3->getNumFound();
            // Check on food_ing
            $qing = array('query' => Input::get('q'),'querydefaultfield' => 'food_ing');
            $q4 = $this->client->createSelect($qing);
            $res4 = $this->client->select($q4);
            $numIng = $res4->getNumFound();

            $maxFound = array("code" => $numCode, "name" => $numName, "man" => $numMan, 'ing' => $numIng);
            
            $higherFound = array_search(max($maxFound),$maxFound); // return 1 max
            //$higherFound = array_keys($maxFound,max($maxFound)); // return more than 1

            //echo $higherFound;

            // Find highest query on
            if ($higherFound == 'code'){
                $handler = 'bm25fc';
            }
            elseif ($higherFound == 'name'){
                $handler = 'bm25fn';
            }
            elseif ($higherFound == 'man'){
                $handler = 'bm25fm';
            }
            elseif ($higherFound == 'ing'){
                $handler = 'bm25fi';
            }

            // Execute main search
            $select = array(
                'query'         => Input::get('q'),
                'handler'       => $handler,
                'start'         => 0,
                'rows'          => 10,
            );
            $query = $this->client->createSelect($select);

            // Query based on input user
            $query->setQuery(Input::get('q'));

            // add debug settings
            $debug = $query->getDebug();
            $debug->setExplainOther('id:MA*');

            // get highlighting component and apply settings
            $hl = $query->getHighlighting();
            $hl->setFields('food_code, food_name, food_man, food_ing');
            $hl->setSimplePrefix('<b>');
            $hl->setSimplePostfix('</b>');

             // Execute the query and return the result
            $resultset = $this->client->select($query);

            // Debug result
            $debugResult = $resultset->getDebug();

            // this executes the query and returns the result
            $highlighting = $resultset->getHighlighting();

            // Get query time in seconds
            $ms = $debugResult->getTiming()->getTime();
            $s = $ms/1000;

            // Pass the resultset to the view and return.
            return view('pages.v2.home', array(
                'q' => Input::get('q'),
                'resultset' => $resultset,
                'debugResult' => $debugResult,
                's' => $s,
                'handler' => $handler,
            ));
        }

        // No query to execute, just return the search form.
        return view('pages.v2.home');
    }

    public function json()
    {
        if (Input::has('q')) {
            $hand = index()->$handler;
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
