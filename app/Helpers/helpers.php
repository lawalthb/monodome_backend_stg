<?php

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * [unique code
 * @return [void] [unique code for each transaction]
 */
function unique_code($length = 13)
{

    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($length / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return strtoupper(substr(bin2hex($bytes), 0, $length));
}

function generateQr($val)
{

    return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$val&choe=UTF-8&chf=bg,s,FFFFFF00";
}

function generate()
{
    // Generate a new private key
    $privateKey = openssl_pkey_new(array(
        'private_key_bits' => 2048,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ));

    // Get the private key as a string
    openssl_pkey_export($privateKey, $privateKeyString);

    // Generate a new public key
    $publicKey = openssl_pkey_get_details($privateKey)['key'];

    return array(
        'public_key' => $publicKey,
        'private_key' => $privateKeyString,
    );
}

function error_processor($validator)
{
    $err_keeper = [];
    foreach ($validator->errors()->getMessages() as $index => $error) {
        $err_keeper[] = ['code' => $index, 'message' => $error[0]];
    }
    return $err_keeper;
}

function get_business_settings($name)
{
    $config = null;
    $data = Setting::where(['slug' => $name])->first();
    if (isset($data)) {
        $config = json_decode($data['value'], true);
        if (is_null($config)) {
            $config = $data['value'];
        }
    }

    return $config;
}

function getOTPNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    // return $randomString;
}

function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return "MO-" . $randomString;
    // return $randomString;
}

if (!function_exists('getSlug')) {
    function getSlug($text)
    {
        if ($text) {
            $data = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $text);
            $slug = preg_replace("/[\/_|+ -]+/", "-", $data);
            return $slug;
        }
        return '';
    }
}

function get_number_format($amount)
{
    return number_format($amount, 2, '.', '');
}

function decimal_to_int($amount)
{
    return number_format(number_format($amount, 2, '.', '') * 100, 0, '.', '');
}
function int_to_decimal($amount)
{
    return number_format($amount / 100, 2, '.', '');
}

function userBalance($userId = null)
{
    if ($userId == null) {
        return int_to_decimal(Auth::user()->balance);
    }
    $user = User::find($userId);
    return int_to_decimal($user->balance);
}


function getPublicImageFile($file)
{
    return asset($file);
}


// function getImageFile($file)
// {
//     if (!$file) {
//         return asset('default.jpg'); // Return the default image path if $file is null or empty
//     }

//     return asset('storage/' . $file); // Return the asset path for the provided file
// }


function getImageFile($file)
{
    //  return asset($file);
    return asset('storage/' . $file);
}

function getVideoFile($file)
{
    if ($file == '' || $file == null) {
        return null;
    }

    try {
        if (env('STORAGE_DRIVER') != "public") {
            if (Storage::disk(env('STORAGE_DRIVER'))->exists($file)) {
                // Use storage_path to get the absolute path to the file
                $storagePath = Storage::disk(env('STORAGE_DRIVER'))->path($file);
                return $storagePath;
            }
        } else {
            // Use storage_path to get the absolute path to the file in the public storage directory
            $publicPath =  asset('storage/' . $file);; //storage_path('app/public/' . $file);
            return $publicPath;
        }
    } catch (Exception $e) {
    }

    return asset($file);
}



function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}




function getBrowser($useragent)
{
    $u_agent = $useragent;
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}


function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
{
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

// $ipaddress = getUserIP();
//             $country = ip_info($ipaddress, "Country");
//             $city =  ip_info($ipaddress, "City");
//             $region =  ip_info($ipaddress, "Address");
// 			$subject = trans('main.subject_login',  array(
// 							'name' => Config::get('app.name'),
//                             'country' => $country
// 							));
// 		    $message = trans('main.message_login', array('ip' => $ipaddress,'name' => Config::get('app.name'),
// 							'username' => Auth::user()->username,
// 							'time' => date('d F Y, h:i:s A'),
//                             'country' => $country,
//                             'city' => $city,
//                             'region' => $region,
// 							'userAgent' => $_SERVER['HTTP_USER_AGENT']
// 							));


function notify($user, $type, $shortCodes = null)
{

    sendEmail($user, $type, $shortCodes);
    sendSms($user, $type, $shortCodes);
}
function sendSms($user, $type, $shortCodes = [])
{
    // $general = GeneralSetting::first(['sn', 'sms_api']);
    // $sms_template = SmsTemplate::where('act', $type)->where('sms_status', 1)->first();
    // if ($general->sn == 1 && $sms_template) {

    //     $template = $sms_template->sms_body;

    //     foreach ($shortCodes as $code => $value) {
    //         $template = shortCodeReplacer('{{' . $code . '}}', $value, $template);
    //     }
    //     $template = urlencode($template);

    //     $message = shortCodeReplacer("{{number}}", $user->mobile, $general->sms_api);
    //     $message = shortCodeReplacer("{{message}}", $template, $message);
    //     $result = @file_get_contents($message);
    // }
}

function shortCodeReplacer($shortCode, $replace_with, $template_string)
{
    return str_replace($shortCode, $replace_with, $template_string);
}


function sendEmail($user, $type = null, $shortCodes = [])
{
    // $general = GeneralSetting::first();

    // $email_template = EmailTemplate::where('act', $type)->where('email_status', 1)->first();
    // if ($general->en != 1 || !$email_template) {
    //     return;
    // }

    // $username = $user->username ? $user->username : $user->firstname.' '.$user->lastname;

    // $message = shortCodeReplacer("{{name}}", $username, $general->email_template);
    // $message = shortCodeReplacer("{{message}}", $email_template->email_body, $message);

    // if (empty($message)) {
    //     $message = $email_template->email_body;
    // }

    // foreach ($shortCodes as $code => $value) {
    //     $message = shortCodeReplacer('{{' . $code . '}}', $value, $message);
    // }
    // $config = $general->mail_config;

    // if ($config->name == 'php') {
    //     sendPhpMail($user->email, $username,$email_template->subj, $message);
    // } else if ($config->name == 'smtp') {
    //     sendSmtpMail($config, $user->email, $username, $email_template->subj, $message,$general);
    // }
}

function sendPhpMail($receiver_email, $receiver_name, $subject, $message)
{
    $gnl = Setting::first();
    $headers = "From: $gnl->sitename <$gnl->email_from>\r\n";
    $headers .= "Reply-To: $gnl->sitename <$gnl->email_from>\r\n";
    $headers .= "Return-Path: $gnl->sitename <$gnl->email_from>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Organization: monodome\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

    @mail($receiver_email, $subject, $message, $headers);
}


function generateReferralCode($length = 8)
{
    $referralCode = Str::random($length); // Generate a random string

    // Check if the generated code already exists in the database
    $exists = User::where('referral_code', $referralCode)->exists();

    // If the code already exists, regenerate until a unique code is found
    while ($exists) {
        $referralCode = Str::random($length);
        $exists = User::where('referral_code', $referralCode)->exists();
    }

    return $referralCode;
}


/**
 * Initiates a transaction with Paystack API.
 *
 * @param mixed $fields The fields required for the transaction.
 * @return mixed The result of the API call.
 */
function payStack_checkout($fields)
{

    $secretkey = Setting::where(['slug' => 'secretkey'])->first()->value;

    $url = "https://api.paystack.co/transaction/initialize";


    $fields_string = http_build_query($fields);

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $secretkey",
        "Cache-Control: no-cache",
    ));

    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);

    return $result  = json_decode($result);
}

function nombaAccessToken()
{

    $AccountId = Setting::where(['slug' => 'nombaAccountID'])->first()->value;
    $client_id = Setting::where(['slug' => 'nombaClientID'])->first()->value;
    $client_secret = Setting::where(['slug' => 'nombaPrivatekey'])->first()->value;


    $response = Http::withHeaders([
        'AccountId' => $AccountId,
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ])->post('https://api.nomba.com/v1/auth/token/issue', [
        'grant_type' => 'client_credentials',
        'client_id' => $client_id,
        'client_secret' => $client_secret,
    ]);

    $result = $response->json();

    if (isset($result['data']['access_token'])) {
        $accessToken = $result['data']['access_token'];
        return ["accessToken" => $accessToken, "accountId" => $AccountId];;
    }

    return null;
}


function topUpWallet($amount)
{

    $AccountId = Setting::where(['slug' => 'nombaAccountID'])->first()->value;
    $client_id = Setting::where(['slug' => 'nombaClientID'])->first()->value;
    $client_secret = Setting::where(['slug' => 'nombaPrivatekey'])->first()->value;

    $response = Http::withHeaders([
        'accountId' => $AccountId,
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . nombaAccessToken(),
    ])->post('https://api.nomba.com/v1/checkout/order', [
        'order' => [
            'orderReference' => Str::uuid(),
            //  'customerId' => '762878332454',
            'callbackUrl' => 'https://talosmart-monodone-frontend.vercel.app/customer',
            'customerEmail' => Auth::user()->email,
            'amount' => $amount,
            'currency' => 'NGN',
        ],
        'tokenizeCard' => 'true',
    ]);

    // Assuming you want to retrieve the response as an array

    $result = $response->json();

    if (isset($result['data']['checkoutLink']) && isset($result['data']['orderReference'])) {
        $checkoutLink = $result['data']['checkoutLink'];
        $orderReference = $result['data']['orderReference'];

        return [
            'status' => true,
            'checkoutLink' =>  $checkoutLink,
            'orderReference' => $orderReference
        ];
    }
    return null;
}
