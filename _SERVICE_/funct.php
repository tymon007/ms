<?php
function alert($message)
{
    echo '<div class="alert alert-danger">';
    echo $message;
    echo '</div>';
}

function deleteNotUniqeValues(array $one, array $two)
{
    foreach ($one as $oneKey => &$oneVal) {
        foreach ($two as $twoKey => &$twoVal) {
            if ($oneVal == $twoVal) {
                unset($two[$twoKey]);
                unset($one[$oneKey]);
                break;
            }
        }
    }

    return array_merge($one, $two);
}

function sendMessageMail($to, $from, $title, $message)
{
    $subject = $title;
    $subject = '=?utf-8?b?' . base64_encode($subject) . '?=';
    $headers = "Content-type: text/html; charset=\"utf-8\"\r\n";
    $headers .= "From: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Date: " . date('D, d M Y h:i:s O') . "\r\n";
    if (!mail($to, $subject, $message, $headers)) return false;
    else return true;
}

function salt()
{
    $salt = substr(md5(uniqid()), -8);
    return $salt;
}

function entities($string)
{
    $stringBuilder = "";
    $offset = 0;

    if (empty($string)) {
        return "";
    }

    while ($offset >= 0) {
        $decValue = ordutf8($string, $offset);
        $char = unichr($decValue);

        $htmlEntited = htmlentities($char);
        if ($char != $htmlEntited) {
            $stringBuilder .= $htmlEntited;
        } elseif ($decValue >= 128) {
            $stringBuilder .= "&#" . $decValue . ";";
        } else {
            $stringBuilder .= $char;
        }
    }

    return $stringBuilder;
}

function ordutf8($string, &$offset)
{
    $code = ord(substr($string, $offset, 1));
    if ($code >= 128) {        //otherwise 0xxxxxxx
        if ($code < 224) $bytesnumber = 2;                //110xxxxx
        else if ($code < 240) $bytesnumber = 3;        //1110xxxx
        else if ($code < 248) $bytesnumber = 4;    //11110xxx
        $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
        for ($i = 2; $i <= $bytesnumber; $i++) {
            $offset++;
            $code2 = ord(substr($string, $offset, 1)) - 128;        //10xxxxxx
            $codetemp = $codetemp * 64 + $code2;
        }
        $code = $codetemp;
    }
    $offset += 1;
    if ($offset >= strlen($string)) $offset = -1;
    return $code;
}

function unichr($u)
{
    return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
}

function local2gm($localStamp = false)
{
    if ($localStamp === false) $localStamp = time();
    $tzOffset = date('Z', $localStamp);
    return $localStamp - $tzOffset;
}

function gm2local($gmStamp = false, $tzOffset = false)
{
    if ($gmStamp === false) return time();
    if ($tzOffset === false) $tzOffset = date("Z", $gmStamp);
    else $tzOffset *= 60 * 60;
    return $gmStamp + $tzOffset;
}

function post($id, $whoID, $title, $text, $time, $forward, $IDusersLiked, string $at, $pictures = null, $video = null, $audio = null, $docs = null)
{
    global $me;

    $author = $me->select('users', ['*'], ['id' => $whoID])[0];

    if ($author['image'] === NULL) {
        $authorImage = '/img/01I.png';
    } else {
        $authorImage = '/userimg/users/' . $author['image'];
    }

    $iLikedPostKey = false;

    if ($IDusersLiked === NULL) {
        $likes = 0;
    } else {
        $idUsersLikedPostList = explode(';', $IDusersLiked);
        if (in_array($me->id, $idUsersLikedPostList)) {
            $iLikedPostKey = true;
        }
        $likes = count($idUsersLikedPostList);
    }

    $post = '<div class="post" data-post-id="' . $id . '">';
    $post .= '    <div class="who-posted">';
    $post .= '        <div class="image-name">';
    $post .= '            <div class="image" style="background-image: url(\'' . ADDRESS_DATA . $authorImage . '\')"></div>';
    $post .= '            <div class="name--time-date">';
    $post .= '                <div class="name">';
    $post .= '                    <span class="firstName">' . $author['firstName'] . '</span>';
    $post .= '                    <span class="lastName">' . $author['lastName'] . '</span>';
    $post .= '                </div>';
    $post .= '                <div class="time-date">';
    $post .= '                    <div class="display-none" data-timestamp="' . $time . '"></div>';
    $post .= '                    <div class="date"></div>';
    $post .= '                    <div class="at">' . $at . '</div>';
    $post .= '                    <div class="time"></div>';
    $post .= '                </div>';
    $post .= '            </div>';
    $post .= '        </div>';
    $post .= '    </div>';
    $post .= '    <div class="title">' . $title . '</div>';
    $post .= '    <div class="text">';
    $post .= '        <span class="gottenText">' . $text . '</span>';
    $post .= '        <span class="showedText"></span>';
    if ($forward != "no") $post .= forwardPost($forward, 0, $at);
    $post .= '    </div>';
    $post .= '    <div class="likes-comments-forwards">';
    if ($iLikedPostKey) $post .= '        <div class="l-c-f-block likes _yes">';
    else $post .= '        <div class="l-c-f-block likes _no">';
    if ($likes == 0) $post .= '            <div class="value"></div>';
    else $post .= '            <div class="value">' . $likes . '</div>';
    $post .= '            <div class="icon"></div>';
    $post .= '        </div>';
    $post .= '        <div class="l-c-f-block comments _no">';
    $post .= '            <div class="value"></div>';
    $post .= '            <div class="icon"></div>';
    $post .= '        </div>';
    $post .= '        <div class="l-c-f-block forwards _no">';
    $post .= '            <div class="value"></div>';
    $post .= '            <div class="icon"></div>';
    $post .= '        </div>';
    $post .= '    </div>';
    $post .= '</div>';
    return $post;
}

function forwardPost(int $idOfPost, int $counterOfForwarder, string $at)
{
    global $me;

    if ($counterOfForwarder >= 2) return;
    $counterOfForwarder++;

    $forwardPost = $me->select('postuser', ['*'], ['id' => $idOfPost])[0];

    $author = $me->select('users', ['*'], ['id' => $forwardPost['whoID']])[0];

    if ($author['image'] === NULL) {
        $authorImage = '/img/01I.png';
    } else {
        $authorImage = '/userimg/users/' . $author['image'];
    }

    $time = $forwardPost['time'];

    $result = '<div class="forwardedPost post">';
    $result .= '    <div class="who-posted">';
    $result .= '        <div class="image-name">';
    $result .= '            <div class="image" style="background-image: url(\'' . ADDRESS_DATA . $authorImage  . '\')"></div>';
    $result .= '            <div class="name--time-date">';
    $result .= '                <div class="name">';
    $result .= '                    <span class="firstName">' . $author['firstName'] . '</span>';
    $result .= '                    <span class="lastName">' . $author['lastName'] . '</span>';
    $result .= '                </div>';
    $result .= '                <div class="time-date">';
    $result .= '                    <div class="display-none" data-timestamp="' . $time . '"></div>';
    $result .= '                    <div class="date"></div>';
    $result .= '                    <div class="at">' . $at . '</div>';
    $result .= '                    <div class="time"></div>';
    $result .= '                </div>';
    $result .= '            </div>';
    $result .= '        </div>';
    $result .= '    </div>';
    $result .= '    <div class="title">' . $forwardPost['title'] . '</div>';
    $result .= '    <div class="text">';
    $result .= '        <span class="gottenText">' . $forwardPost['text'] . '</span>';
    $result .= '        <span class="showedText"></span>';
    if ($forwardPost['forward'] != 'no') $result .= forwardPost($forwardPost['forward'], $counterOfForwarder, $at);
    $result .= '    </div>';
    $result .= '</div>';
    return $result;
}

function mygetdate($messtimestamp, $currenttimestamp = false)
{
    if ($currenttimestamp === false) {
        $currenttimestamp = time();
    }
    $DataTimeCurrTimestamp = new DateTime(date('Y-m-d H:i:s', $currenttimestamp));
    $DataTimeMessTimestamp = new DateTime(date('Y-m-d H:i:s', $messtimestamp));
    $interval = $DataTimeCurrTimestamp->diff($DataTimeMessTimestamp);
    $difference['seconds'] = $interval->s;
    $difference['minutes'] = $interval->i;
    $difference['hours'] = $interval->h;
    $difference['days'] = $interval->d;
    $difference['months'] = $interval->m;
    $difference['years'] = $interval->y;

    $DataCurrTimestamp = new DateTime(date('Y-m-d', $currenttimestamp));
    $DataMessTimestamp = new DateTime(date('Y-m-d', $messtimestamp));

    if ($DataMessTimestamp->add(new DateInterval('P1D')) == $DataCurrTimestamp) {
        $time = 'yesterday';
    } else {
        if ($difference['hours'] < 12 && $difference['days'] == 0 && $difference['months'] == 0 && $difference['years'] == 0) {
            $time = date('H:i', $messtimestamp);
        } elseif ($difference['hours'] < 24 && $difference['days'] == 0 && $difference['months'] == 0 && $difference['years'] == 0) {
            $time = 'today';
        } elseif ($difference['days'] < 7 && $difference['months'] == 0 && $difference['years'] == 0) {
            $time = substr(getdate($messtimestamp)['weekday'], 0, 3);
        } else {
            $time = date('d.m.Y', $messtimestamp);
        }
    }

    return $time;
}

function reset_keys($array)
{
    $len = count($array);
    $keys = array_keys(array_fill(0, $len, 0));
    $newArray = array_combine($keys, $array);
    return $newArray;
}
