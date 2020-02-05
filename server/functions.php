<?php

function writeLog($string){
    $fichier = fopen("./log.txt", "a");
    fwrite($fichier, "\n\n". date("[Y/m/d @ H:i:s] : "). $string."\n\n\n");
    fclose($fichier);
}


function getAuthToken($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);



    $path = "/server/load.php?type=stb&action=handshake&prehash=eGDESVA/0yhol/dGCQOABJBd54U=&token=&JsHttpRequest=1-xml";


    if (!$content = file_get_contents("http://" . $portal . ":" . $port . $path, false, $context)) {

        writeLog("Fail handshake");
        die();
    }

    return $content;

}

function getProfileDetails($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=stb&action=get_profile&hd=1&ver=ImageDescription:%200.2.16-r2;%20ImageDate:%20Fri%20Oct" .
        "%2025%2017:28:41%20EEST%202013;%20PORTAL%20version:%205.3.0;%20API%20Version:%20JS%20API%20version:%20328" .
        ";%20STB%20API%20version:%20134;%20Player%20Engine%20version:%200x566&num_banks=1&sn=012012N01212&stb_type" .
        "=MAG250&client_type=STB&image_version=216&video_out=hdmi&device_id=&device_id2=&signature" .
        "=&auth_second_step=0&hw_version=1.7-BD-00&not_valid_token=0&metrics=%7B%22mac%22%3A%2200%3A1A%3A79%3A00" .
        "%3A00%3A01%22%2C%22sn%22%3A%22012012N01212%22%2C%22model%22%3A%22MAG250%22%2C%22type%22%3A%22STB%22%2C" .
        "%22uid%22%3A%22%22%2C%22random%22%3A%22%22%7D&hw_version_2=DTzRpzLBKn7jCLvRrJNQE3hEOc4=&timestamp" .
        "=1562486315&api_signature=210&prehash=eGDESVA/0yhol/dGCQOABJBd54U=&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get profile fail !");
        die();
    }


    return $content;



}

function getLocalization($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=stb&action=get_localization&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get localization fail!");
        die();
    }


    return $content;

}


// ================= ACCOUNT INFO =================

function getMainInfo($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=account_info&action=get_main_info&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get main info fail!");
        die();
    }


    return $content;

}

// ================= ITV    =======================

function getTvGenres($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=get_genres&type=itv&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get tv genres fail!");
        die();
    }


    return $content;

}


function getAllChannels($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=get_all_channels&type=itv&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get all channels fail!");
        die();
    }


    return $content;

}

function getRealTvLink($portal, $port, $mac, $cmd){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=create_link&type=itv&cmd=$cmd&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get real tv link fail!");
        die();
    }


    return $content;

}

// ================= TV ARCHIVE ===================


function getLinkForChannel($portal, $port, $mac, $ch_id){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=tv_archive&action=get_link_for_channel&ch_id=$ch_id&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get link for channel fail !");
        die();
    }


    return $content;

}

function getRealTvArchiveLink($portal, $port, $mac, $cmd, $series, $forced_storage, $disable_ad){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=create_link&type=tv_archive&cmd=$cmd&series=$series&forced_storage=$forced_storage&disable_ad=$disable_ad&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get link for channel fail !");
        die();
    }


    return $content;

}


// ================= EPG    =======================

function getShortEpg($portal, $port, $mac, $ch_id){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=get_short_epg&ch_id=$ch_id&type=itv&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get short epg fail!");
        die();
    }


    return $content;

}

function getEpgInfo($portal, $port, $mac, $period){


    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=get_epg_info&period=$period&type=itv&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get epg info fail!");
        die();
    }


    return $content;

}


function getWeek($portal, $port, $mac){


    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=epg&action=get_week&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get week fail!");
        die();
    }


    return $content;

}


function getSimpleDataTable($portal, $port, $mac, $ch_id, $date, $page){


    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=get_simple_data_table&type=epg&ch_id=$ch_id&date=$date&p=$page&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get week fail!");
        die();
    }


    return $content;

}




// ================= VOD ==========================

function getVodGetCategories($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=get_categories&type=vod&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get vod get year fail!");
        die();
    }


    return $content;

}


function getVodGetYear($portal, $port, $mac, $category){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=vod&action=get_years&category=$category&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get vod get year fail!");
        die();
    }


    return $content;

}

function getVodGetAbc($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=vod&action=get_abc&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get vod get abc fail!");
        die();
    }


    return $content;

}

function getVodGetGenresByCategoryAlias($portal, $port, $mac, $cat_alias){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=vod&action=get_genres_by_category_alias&cat_alias=$cat_alias&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("getVodGetGenresByCategoryAlias fail!");
        die();
    }


    return $content;

}

function getVodGetOrderedList($portal, $port, $mac, $category, $fav, $sortby, $hd, $not_ended, $page, $abc, $genre, $years, $search){


    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=vod&action=get_ordered_list&category=$category&fav=$fav&sortby=$sortby&hd=$hd&not_ended=$not_ended&p=$page&JsHttpRequest=1-xml&abc=$abc&genre=$genre&years=$years&search=$search";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("getVodGetOrderedList fail!");
        die();
    }


    return $content;

}

function getRealMovieLink($portal, $port, $mac, $cmd){


    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=create_link&type=vod&cmd=$cmd&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("getRealMovieLink fail!");
        die();
    }


    return $content;

}

// ================= SERIES =======================

function getSeriesGetCategories($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?action=get_categories&type=series&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get vod get categories fail!");
        die();
    }


    return $content;

}


function getSeriesGenresByCategoryAlias($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=series&action=get_genres_by_category_alias&cat_alias=*&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get series genres by category alias!");
        die();
    }


    return $content;

}
function getSeriesGetAbc($portal, $port, $mac){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=series&action=get_abc&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get series genres by category alias!");
        die();
    }


    return $content;

}

function getSeriesGetYears($portal, $port, $mac, $category){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=series&action=get_years&category=*&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get series genres by category alias!");
        die();
    }


    return $content;

}

function getSeriesGetOrderedList($portal, $port, $mac, $category, $fav, $sortby, $hd, $not_ended, $page, $abc, $genre, $years, $search, $movie_id=0){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=series&action=get_ordered_list&category=$category&fav=$fav&sortby=$sortby&hd=$hd&not_ended=$not_ended&p=$page&JsHttpRequest=1-xml&abc=$abc&genre=$genre&years=$years&search=$search&movie_id=$movie_id";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get series genres by category alias!");
        die();
    }


    return $content;

}


function getRealSerieLink($portal, $port, $mac, $cmd, $series, $forced_storage, $disable_ad){


    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    //$path = "/server/load.php?action=create_link&type=series&cmd=$cmd&series=$series&forced_storage=$forced_storage&disable_ad=$disable_ad&JsHttpRequest=1-xml";
    $path = "/server/load.php?action=create_link&type=vod&cmd=$cmd&series=$series&forced_storage=$forced_storage&disable_ad=$disable_ad&JsHttpRequest=1-xml";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("getRealSerieLink fail!");
        die();
    }


    return $content;

}


// ============== RADIO ===================


function getRadioOrderedList($portal, $port, $mac, $sortby){

    $context = stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 2 rev: 234 Safari/533.3\r\n" .
                "X-User-Agent: Model: MAG250; Link: \r\n" .
                "Accept: Model: */*\r\n" .
                "Connection: Keep-Alive\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Accept-Language: fr-BE,en,*\r\n" .
                "Host: " . $portal . ":" . $port . "\r\n" .
                "Authorization: ".$_SERVER['HTTP_AUTHORIZATION']."\r\n" .
                "Cookie: mac=$mac; stb_lang=en; timezone=Europe%2FKiev; aid=9467fbcc14e730592624a21c71b1893a"
        ]
    ]);

    $path = "/server/load.php?type=radio&action=get_ordered_list&p=1&JsHttpRequest=1-xml&sortby=$sortby";

    if (!$content = file_get_contents("http://" . $portal . ":" . $port . "/" . $path, false, $context)) {

        writeLog("get radio ordered list fail!");
        die();
    }


    return $content;

}
?>