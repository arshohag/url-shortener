<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Services\ScannerApi;
use App\Services\UrlHash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UrlshortenerController extends Controller
{
    protected $hash;
    protected $scannerApi;

    public function __construct(UrlHash $hash, ScannerApi $scannerApi)
    {
        $this->scannerApi = $scannerApi;
        $this->hash = $hash;
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

        $old_url = $request->input('url');

        $hash = $this->hash->createUrlHash($old_url);

        $url = new Url([
            'hash' => $hash,
            'old_url' => $old_url,
            'new_url' => config('app.url') . "/$hash",
        ]);

        $response = $this->scannerApi->postScanUrl($old_url);

        if ($response['WebsiteHttpResponseCode'] != 200) {
            throw ValidationException::withMessages(['scan' => 'Malicious URL Detected!']);
        }

        $url->save();

        return response()->json('URL Created Successfully.');
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
