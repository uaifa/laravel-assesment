<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\Quote;
use GuzzleHttp\Client;




class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit=5)
    {
        if(isset(request()->limit) && !empty(request()->limit)){
            $limit = request()->limit;
        }
        $quotes = Quote::orderBy('id', 'DESC')->get();
        $quotes_list = $this->getQuotes($limit);
        return Inertia::render('Quotes/Index', compact('quotes_list', 'quotes', 'limit'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $limit = 5;

        $quote = new Quote();
        $quote->quote = $request->quote;
        $quote->created_by = auth()->user()->id;
        $quote->save();
        $quote->users()->attach(auth()->user()->id);

        if(isset(request()->limit) && !empty(request()->limit)){
            $limit = request()->limit;
        }

        return redirect()->route('quotes.index', $limit);

    }

    public function getQuotes($limit=5){

         // Create a new Guzzle client
        $client = new Client();
        $url ='https://api.kanye.rest';
        // Create an array to store the responses
        $responses = [];
        // Use Guzzle's promise to send multiple requests concurrently
        $promises = [];
        for ($i=0; $i < $limit; $i++) { 
            $promises[] = $client->getAsync($url);
        }
        // Wait for all promises to complete
        $results = \GuzzleHttp\Promise\unwrap($promises);
        // Get the responses
        foreach ($results as $response) {
            $response = $response->getBody()->getContents();
            $responses[] = json_decode($response);
        }
        return $responses;
    } 
}
