<?php

/**
 * @param $url - YouTube video-URL
 * @return array URL-templates, preview picture, video-id
 */
function youtube_video($url) {
    $arrUrl = parse_url($url);

    if(isset($arrUrl['query'])) {
        $arrUrlGet = explode('&', $arrUrl['query']);
        foreach ($arrUrlGet as $value) {
            $arrGetParam = explode('=', $value);
            if(!strcmp(array_shift($arrGetParam), 'v')) {
                $videoID = array_pop($arrGetParam);
                break;
            }
        }
        if (empty($videoID)) {
            $videoID = array_pop(explode('/', $arrUrl['path']));
        }
    } else {
        $videoID = array_pop(explode('/', $url));
    }

    return array(
        'iframe' => 'https://www.youtube.com/embed/'.$videoID,
        'src' => 'https://www.youtube.com/watch?v='.$videoID,
        'image_maxresdefault' => 'http://img.youtube.com/vi/'.$videoID.'/maxresdefault.jpg',
        'id' => $videoID
    );
}