<?php

namespace App\Http\Controllers;

//use App\Aws;
use App;
use Illuminate\Http\Request;


class AgreementsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Create an AWS S3 client using the AWS SDK
        $s3 = App::make('aws')->createClient('s3');
        // $s3 = AWS::createClient('s3');

        // Get all of the items in the specified bucket
        $items = $s3->listObjects([
            'Bucket' => 'metro-tos'
        ]);

        // Initialize an empty array
        $keys = [];

        // Get all of the keys
        foreach ($items['Contents'] as $item){
            array_push($keys, $item['Key']);
        }

        // Load the view passing along necessary variables
        return view('TOS.index', compact('keys'));
    }


    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Create an AWS S3 client using the AWS SDK
        $s3 = App::make('aws')->createClient('s3');
        $key = $request->key;

        // Get an object by key
        $document = $s3->getObject([
            'Bucket' => 'metro-tos',
            'Key' => $key
        ]);

        // Extract the URL to the PDF from the response
        $url = $document['@metadata']['effectiveUri'];

        // Regular expression to pull the name and date out of the key
        $regex = "/TOS_([a-zA-Z|&|\s|\-|\.|']*).*?_(\d{2}[a-zA-Z]+\d{4})/";

        // Execute the regex
        preg_match($regex, $key, $matches);

        // Assign matches to variables
        $name = $matches[1];
        $date = $matches[2];

        // Load the view passing along necessary variables
        return view('TOS.details', compact(['url', 'name', 'date']));
    }


}
