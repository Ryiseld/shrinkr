<?php

namespace App\Http\Controllers;

use Auth;
use App\Url;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class DashboardController extends Controller
{
    public function index() {
    	// Check if the user has shortened links
    	$urlCount = Url::where('user_id', Auth::user()->id)->count();
    	if ($urlCount > 0) {
	    	return $this->showDashboard();
	    } else {
	    	return redirect('/')->with('error', 'You have no shortened links yet.');
	    }
    }

    public function show($hash) {
    	// Check if the url exists
    	$url = Url::where('hash', $hash)->firstOrFail();

    	// Check if the hash url belongs to the current user
    	if ($url->user == Auth::user()) {
    		return $this->showDashboard($url);
    	} else {
    		return redirect('/dashboard');
    	}
    }

    public function delete($hash) {
    	// Check if the url exists
    	$url = Url::where('hash', $hash)->firstOrFail();

    	// Check if the hash url belongs to the current user
    	if ($url->user == Auth::user()) {
    		$url->delete();
    		return redirect('/dashboard')->with('success', 'You have successfully deleted the shortened link');
    	} else {
    		return redirect('/dashboard');
    	}
    }

    protected function showDashboard($defaultUrl = '') {
    	$user = User::find(Auth::user()->id);
    	$urls = $user->urls()->get();

    	if ($defaultUrl == '') {
    		return view('dashboard.index', ['urls' => $urls, 'default_url' => $urls->first()]);
    	} else {
    		return view('dashboard.index', ['urls' => $urls, 'default_url' => $defaultUrl]);
    	}
    }
}
