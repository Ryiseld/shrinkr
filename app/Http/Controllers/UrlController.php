<?php

namespace App\Http\Controllers;

use Auth;
use App\Url;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrlController extends Controller
{
	protected $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

    public function create(Request $request)
    {
    	// Validate URL
    	$this->validate($request, [
    		'url' => 'required|regex:' . $this->regex
    	]);

    	// Validate hash if user is logged in
    	if (!Auth::guest()) {
    		$this->validate($request,[
    			'hash' => 'unique:urls'
    		]);
    	}

    	// Check if the user inserted an hash, if not, generate one
    	if ($request->hash != '' && !Auth::guest())
			$hash = $request->hash;
    	else
    		$hash = $this->generateHash();

    	// Get the url from the database where there is no user id
    	$url = Url::where('original_url', $request->url)->where('user_id', null)->first();

    	// Check if the user is not logged in, and if the url exists set it to the current url
    	if (Auth::guest() && $url) {
    		$hash = $url->hash;
    	} else {
	    	// Create url record
	    	$url = new Url;
			$url->hash = $hash;
			$url->original_url = $request->url;
			if (!Auth::guest()) $url->user_id = Auth::user()->id;
			$url->save();
		}

		// Redirect to home page
		$shortenedUrl = env('APP_URL') . '/' . $hash;

        // (this is probably not the best way to do it, but will suffice for now.)
        $successMessage = 'Your URL has been successfully shortened!<br>
            <a href="' . $shortenedUrl . '">' . $shortenedUrl . '</a><br>
            <a href="http://twitter.com/intent/tweet?status=' . $shortenedUrl . '" class="btn btn-primary">Share on Twitter</a>
            <div href="https://www.facebook.com/sharer/sharer.php?u=' . $shortenedUrl . '" class="fb-share btn btn-primary">Share on Facebook</div>';

		return redirect('/')->with('success', $successMessage);
    }

    public function show($hash)
    {
    	$url = Url::where('hash', $hash)->first();
    	if ($url) {
    		$redirectTo = $this->addHttp($url->original_url);

    		// Increment views
    		$url->views = $url->views + 1;
    		$url->save();
    		
    		return redirect()->to($redirectTo);
    	} else {
    		return \App::abort(404);
    	}
    }

    protected function generateHash()
    {
    	return Str::random(rand(4, 6));
    }

    protected function addHttp($url, $scheme = 'http://') {
    	return parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;
    }
}
