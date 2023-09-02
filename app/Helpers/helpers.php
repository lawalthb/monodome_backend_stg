<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * [unique code
 * @return [void] [unique code for each transaction]
 */
function unique_code($length = 13)
{

    if (function_exists("random_bytes"))
    {
        $bytes = random_bytes(ceil($length / 2));
    }
    elseif (function_exists("openssl_random_pseudo_bytes"))
    {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    }
    else
    {
        throw new Exception("no cryptographically secure random function available");
    }
    return strtoupper(substr(bin2hex($bytes), 0, $length));
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


function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return "MO-".$randomString;
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
            $publicPath =  asset('storage/' . $file); ;//storage_path('app/public/' . $file);
            return $publicPath;
        }
    } catch (Exception $e) {
    }

    return asset($file);
}

















?>


