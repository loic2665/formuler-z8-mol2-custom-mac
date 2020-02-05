<?php

require_once("./functions.php");


$portal = file_get_contents("./portal.txt");
$port   = file_get_contents("./port.txt");
$mac    = file_get_contents("./mac.txt");
//$mac    = "00:1A:79:02:1b:1e";

//die();

$response = "";




switch ($_GET["type"]){
    case "account_info":
        switch ($_GET["action"]) {
            case "get_main_info":
                $response = getMainInfo($portal, $port, $mac);
                break;
        }
        break;

    case "stb":
        switch ($_GET["action"]){
            case "handshake":
                $response = getAuthToken($portal, $port, $mac);

                break;
            case "get_profile":
                writeLog($portal." ".$port." ".$mac);

                $response = getProfileDetails($portal, $port, $mac);
                break;
            case "get_localization":
                $response = getLocalization($portal, $port, $mac);
                break;
        }
        break;

    case "itv":
        switch ($_GET["action"]){
            case "get_genres":
                $response = getTvGenres($portal, $port, $mac);
                break;
            case "get_all_channels":
                $response = getAllChannels($portal, $port, $mac);
                break;
            case "create_link":
                $response = getRealTvLink($portal, $port, $mac, $_GET["cmd"]);
                break;
            case "get_short_epg":
                $response = getShortEpg($portal, $port, $mac, $_GET["ch_id"]);
                break;
            case "get_epg_info":
                $response = getEpgInfo($portal, $port, $mac, $_GET["period"]);
                break;
        }
        break;

    case "tv_archive":
        switch ($_GET["action"]){
            case "get_link_for_channel":
                $response = getLinkForChannel($portal, $port, $mac, $_GET["ch_id"]);
                break;
            case "create_link":
                $response = getRealTvArchiveLink($portal, $port, $mac, $_GET["cmd"], $_GET["series"], $_GET["forced_storage"], $_GET["disable_ad"]);
                break;
        }
        break;


    case "epg":
        switch ($_GET["action"]){
            case "get_week":
                $response = getWeek($portal, $port, $mac);
                break;
            case "get_simple_data_table":
                $response = getSimpleDataTable($portal, $port, $mac, $_GET["ch_id"], $_GET["date"], $_GET["p"]);


        }
        break;



    case "vod":
        switch ($_GET["action"]){
            case "get_years":
                $response = getVodGetYear($portal, $port, $mac, $_GET["category"]);
                break;
            case "get_abc":
                $response = getVodGetAbc($portal, $port, $mac);
                break;
            case "get_genres_by_category_alias":
                $response = getVodGetGenresByCategoryAlias($portal, $port, $mac, $_GET["cat_alias"]);
                break;
            case "get_categories":
                $response = getVodGetCategories($portal, $port, $mac);
                break;
            case "get_ordered_list":
                $response = getVodGetOrderedList($portal, $port, $mac, $_GET["category"], $_GET["fav"], $_GET["sortby"], $_GET["hd"], $_GET["not_ended"], $_GET["p"], $_GET["abc"], $_GET["genre"], $_GET["years"], $_GET["search"]);
                break;
            case "create_link":
                $response = getRealMovieLink($portal, $port, $mac, $_GET["cmd"]);
                break;

        }
        break;

    case "series":
        switch ($_GET["action"]){
            case "get_genres_by_category_alias":
                $response = getSeriesGenresByCategoryAlias($portal, $port, $mac);
                break;
            case "get_abc":
                $response = getSeriesGetAbc($portal, $port, $mac);
                break;
            case "get_years":
                $response = getSeriesGetYears($portal, $port, $mac, $_GET["category"]);
                break;
            case "get_categories":
                $response = getSeriesGetCategories($portal, $port, $mac);
                break;
            case "create_link":
                $response = getRealSerieLink($portal, $port, $mac, $_GET["cmd"], $_GET["series"], $_GET["forced_storage"], $_GET["disable_ad"]);
                break;
            case "get_ordered_list":
                if(isset($_GET["movie_id"])){
                    $response = getSeriesGetOrderedList($portal, $port, $mac, $_GET["category"], $_GET["fav"], $_GET["sortby"], $_GET["hd"], $_GET["not_ended"], $_GET["p"], $_GET["abc"], $_GET["genre"], $_GET["years"], $_GET["search"], $_GET["movie_id"]);

                }else{

                $response = getSeriesGetOrderedList($portal, $port, $mac, $_GET["category"], $_GET["fav"], $_GET["sortby"], $_GET["hd"], $_GET["not_ended"], $_GET["p"], $_GET["abc"], $_GET["genre"], $_GET["years"], $_GET["search"]);

                }
                break;

        }
        break;

    case "radio":
        switch ($_GET["action"]){
            case "get_ordered_list":
                $response = getRadioOrderedList($portal, $port, $mac, $_GET["sortby"]);

        }
        break;
}

echo($response);
if($response){
    $txt = "text !";

}else{
    $txt = "no....";
}
writeLog($_SERVER["REQUEST_URI"]. "\n\n======> \n\n".$txt);