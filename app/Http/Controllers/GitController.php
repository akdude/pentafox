<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client; // PHP HTTP client that sends HTTP requests
use File;


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
        
        $validUser = $userdata['total_count']; //returns 1 incase of a valid username
        if ($validUser) {
            $users[0]['avatar_url'] = $userdata['items'][0]['avatar_url'];
            $users[0]['name'] = self::getNameofUser($userdata['items'][0]['url']);
            $users[0]['total_repos'] = self::getRepoCount($userdata['items'][0]['repos_url']);
            return view('gitdata',['users'=> $users]);
        }
    }

    public function showCalc(Request $request)
    {
        $action = $request->action;
        $v1Path = public_path().'/v1';
        $v2Path = public_path().'/v2';

        $v1 = File::isDirectory($v1Path);
        $v2 = File::isDirectory($v2Path);

        if($v1){
            $v1_files = getDirContents($v1Path);
        }

        if($v2){
            $v2_files = getDirContents($v2Path);
        }

        if($action == 'v1vsv2'){
            return view('diffdata',['files' => array_diff($v1_files, $v2_files)]);
        }

        if($action == 'v2vsv1'){
            return view('diffdata',['files' => array_diff($v2_files, $v1_files)]);
        }

        $common_files =  array_intersect($v1_files, $v2_files);
        $diff_in_files = [];
        
        foreach ($common_files as $key => $value) {
            $v1_file_path =  $v1Path. DIRECTORY_SEPARATOR .$value;
            $v2_file_path =  $v2Path. DIRECTORY_SEPARATOR . $value;
            
            if( md5_file($v1_file_path) === md5_file($v2_file_path) ) {
                continue;
            } else {
                array_push($diff_in_files, $value);
            }
        }

        if($action == 'difference'){
            return view('diffdata',['files' => $diff_in_files]);
        }

        if($action == 'differenceinfiles' && $request->file_name == null){
            $string_old = file_get_contents($v1Path. DIRECTORY_SEPARATOR. $diff_in_files[0]);
            $string_new = file_get_contents($v2Path. DIRECTORY_SEPARATOR. $diff_in_files[0]);
            $diff = get_decorated_diff($string_old, $string_new, $diff_in_files[0]);
            $diff['all_files'] = $diff_in_files;
            
        }

        if($action == 'differenceinfiles' && $request->file_name !== null){
            $string_old = file_get_contents($v1Path. DIRECTORY_SEPARATOR. $request->file_name);
            $string_new = file_get_contents($v2Path. DIRECTORY_SEPARATOR. $request->file_name);
            $diff = get_decorated_diff($string_old, $string_new);
            
        }

        return $diff;
    }
}


