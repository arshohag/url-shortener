<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Services\ScannerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UrlshortenerController extends Controller
{
    private $scannerApi;

    public function __construct(ScannerApi $scannerApi)
    {
        $this->scannerApi = $scannerApi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = Url::all()->toArray();

        return array_reverse($urls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url|unique:urls,old_url',
        ]);

        $hash = Str::random(6);
        $new_url = config('app.url') . "/$hash";

        $url = new Url([
            'hash' => $hash,
            'old_url' => $request->input('url'),
            'new_url' => $new_url,
        ]);

        $response = $this->scannerApi->postScanUrl($new_url);

        if ($response['FoundViruses']) {
            throw ValidationException::withMessages(['scan' => 'Malicious URL Detected!']);
        }

        $url->save();

        return response()->json('URL Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url = Url::find($id);

        $url->delete();

        return response()->json('URL Deleted Successfully.');
    }

    /**
     * Handle the URL shortener link.
     *
     * @param Request $request
     * @return redirect
     */
    public function handle(Request $request)
    {
        $uri = substr($_SERVER["REQUEST_URI"], 1);

        $url = Url::Where('hash', $uri)->get('old_url');

        if ($uri == '' || $url == '' || count($url) == 0) {
            return abort(403);
        } else {
            return redirect($url[0]['old_url']);
        }
    }
}
