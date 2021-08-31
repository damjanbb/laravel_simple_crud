<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;



class ExportController extends Controller
{
	/**
     * @return \Illuminate\Http\Response
     */
    public function exportToCSV()
    {	
    	$users = User::all('id','name', 'surname', 'email','username', 'password', 'phone_number','category_id', 'photo','birthday');

    	$csvArray = array();
    	$rb = 1;
        $csvArray[] = array('counter','name','surname','email','username','password','phone_number','category','tags','photo','birthday');

    	foreach ($users as $user) {
            $tagsArray = array();
            foreach ($user->tags as $tag) {
                 $tagsArray[] = $tag['name'];
            }

                $csvArray[] = array(
                $rb++,
                $user['name'],
                $user['surname'],
                $user['email'],
                $user['username'],
                $user['password'],
                $user['phone_number'],
                $user->category['name'],
                implode("\n\r", $tagsArray),
                User::PHOTO_PATH.'/'.$user['photo'],
                $user['birthday']
            );
    	}
        
        $fp = fopen('file.csv', 'w');
        foreach ($csvArray as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="download.csv"',
        ];

        $contents = file_get_contents('file.csv');

        return \Response::make($contents, 200, $headers);
    }
    public function exportToXML()
    {
        $users = User::all('id','name', 'surname', 'email','username', 'password', 'phone_number','category_id','photo','birthday');
        
        $usersTag = new \SimpleXMLElement("<users></users>");
        foreach ($users as $user) {
            $userTag = $usersTag->addChild("user");
            $tagsArray = array();
            foreach ($user->tags as $tag) {
                $tagsArray[] = $tag['name'];
            }

            $userTag->addChild("id", $user['id']);
            $userTag->addChild("name", $user['name']);
            $userTag->addChild("surname", $user['surname']);
            $userTag->addChild("email", $user['email']);
            $userTag->addChild("username", $user['username']);
            $userTag->addChild("password", $user['password']);
            $userTag->addChild("phone_number", $user['phone_number']);
            $userTag->addChild("category", $user->category['name']);
            $userTag->addChild("tags", implode(" ,", $tagsArray));
            $userTag->addChild("photo", $user['photo']);
            $userTag->addChild("birthday", $user['birthday']);
        }
        $headers = [
            'Content-type'        => 'text/xml',           
        ];
        //$a = file_put_contents('data.xml',$usersTag->saveXML());
        $usersTag->asXML('data.xml');
        $a = $usersTag->saveXML();
        return \Response::make($a, 200, $headers); 
    }
}
