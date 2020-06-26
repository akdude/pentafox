<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client; // PHP HTTP client that sends HTTP requests

class GitController extends Controller
{
	/*
        Get the list of all git users
    */
    public function showUsers (Request $request) {
		$users = [];
        $url = 'https://api.github.com/users?per_page=5';

        $client = new Client([
            'base_uri' => $url
        ]);
 
        $response = $client->request('GET');
        $result = $response->getBody();
        $userdata = json_decode($result,true);
        foreach ($userdata as $gituser) {
        	$gituser['total_repos'] = self::getRepoCount($gituser['repos_url']);
            $gituser['name'] = self::getNameofUser($gituser['url']);
        	array_push($users, $gituser);
        }
        return view('gitdata',['users'=> $users]);
	}

	/*
        Get the count of repositories of an user
    */
    public static function getRepoCount ($url) {
		$client = new Client([
            'base_uri' => $url
        ]);
        $response = $client->request('GET');
    	$result = $response->getBody();
    	$userdata = json_decode($result,true);
    	return count($userdata);
	}

    /*
        Get the name of an user
    */

    public static function getNameofUser ($url) {
        $client = new Client([
            'base_uri' => $url
        ]);
        $response = $client->request('GET');
        $result = $response->getBody();
        $userdata = json_decode($result,true);
        return $userdata['name'];
    }

    /*
        Search users by username
    */

    public function searchUsers (Request  $request) {
        $search = $request->search;
        $users = [];
        
        $url = 'https://api.github.com/search/users?q='.$search;

        $client = new Client([
            'base_uri' => $url
        ]);
 
        $response = $client->request('GET');
        $result = $response->getBody();
        $userdata = json_decode($result,true);
        
        $validUser = $userdata['total_count'];
        if ($validUser) {
            $users[0]['avatar_url'] = $userdata['items'][0]['avatar_url'];
            $users[0]['name'] = self::getNameofUser($userdata['items'][0]['url']);
            $users[0]['total_repos'] = self::getRepoCount($userdata['items'][0]['repos_url']);
            return view('gitdata',['users'=> $users]);
        } else {
            return '<b class="red">Invalid Username, Please check your input</b>';
        }
    }
}


