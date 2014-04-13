<?php

class Vine {

function vineAuth($username,$password)
{
        $loginUrl = "https://vine.co/api/users/authenticate";
        $username = urlencode($username);
        $password = urlencode($password);
        $token = sha1($username); // I believe this field is currently optional, but always sent via the app
        
        $postFields = "username=$username&password=$password"; 


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch));

        if (!$result)
        {
                curl_error($ch);
        }
        else
        {
                // Key aLso contains numeric userId as the portion of the string preceding the first dash
                return $result; 
        }

        curl_close($ch);
}
function vineTwitterAuth($twitterOauthToken,$twitterOauthSecret)
{
        $loginUrl = "https://vine.co/api/users/authenticate/twitter";
        $twitterOauthToken = urlencode($twitterOauthToken);
        $twitterOauthSecret = urlencode($twitterOauthSecret);
        //$token = sha1($username); // I believe this field is currently optional, but always sent via the app
        
        $postFields = "twitterOauthToken=$twitterOauthToken&twitterOauthSecret=$twitterOauthSecret"; 


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch));

        if (!$result)
        {
                curl_error($ch);
        }
        else
        {
                // Key aLso contains numeric userId as the portion of the string preceding the first dash
                return $result; 
        }

        curl_close($ch);
}

function vineTimeline($key)
{
        // Additional endpoints available from https://github.com/starlock/vino/wiki/API-Reference
        $url = "https://api.vineapp.com/timelines/graph?size=10";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}

function nextSetofTimelines($key,$page, $timelineID){
    $url = "https://api.vineapp.com/timelines/graph?page=" . $page . "&size=10&anchor=" . $timelineID;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}

function nextSetofComments($key,$postid,$page){
    $url = "https://api.vineapp.com/posts/" . $postid . "/comments?page=" . $page . "&size=5";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}
function getComments($key,$postid){
    $url = "https://api.vineapp.com/posts/" . $postid . "/comments";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}
function postComments($key,$id,$message)
{
        $url = "https://api.vineapp.com/posts/" . $id . "/comments";
        $comment = urlencode($message);
        $postFields = "comment=$comment";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}
function vineLike($key,$id)
{
        // Additional endpoints available from https://github.com/starlock/vino/wiki/API-Reference
        $url = "https://api.vineapp.com/posts/" . $id . "/likes";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 1);

        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}

function deleteVineLike($key,$id)
{
        // Additional endpoints available from https://github.com/starlock/vino/wiki/API-Reference
        $url = "https://api.vineapp.com/posts/" . $id . "/likes";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}

function vineRevine($key,$id)
{
        // Additional endpoints available from https://github.com/starlock/vino/wiki/API-Reference
        $url = "https://api.vineapp.com/posts/" . $id . "/repost";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 1);

        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}

function deleteVineRevine($key,$id,$repostId)
{
        // Additional endpoints available from https://github.com/starlock/vino/wiki/API-Reference
        $url = "https://api.vineapp.com/posts/" . $id . "/repost/" . $repostId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json, text/javascript, */*; q=0.01',
                                            'x-vine-client: vinewww/1.0',
                                          'vine-session-id: '.$key,
                                         'X-Requested-With: XMLHttpRequest'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $result = json_decode(curl_exec($ch), true);

        if (!$result)
        {
                echo curl_error($ch);
        }
        else
        {
                return $result;
        }

        curl_close($ch);
}
}
?>