<?php namespace app\utilities;
use app\utilities\Constant as Constant;
use App\models\UserTbl;
use app\models\LoginTbl;

class Utility extends Constant
{
    // Hold an instance of the class
    private static $instance;


    public function __construct() {

    }

    // The singleton method
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Utility();
        }
        return self::$instance;
    }

    function timestamp($t = null){
        if($t == null){
          $t = time();
        }
        return date('Y-m-d H:i:s', $t);
    }
    public function getResponse($http_code,$message,$value){
        $finalArr = array();

        $msg = '';

        if (empty($message)){
            $msg = self::getHttpStatusCode($http_code);
        }else{
            $msg = $message;
        }

        $finalArr['ApiStatus'] = $http_code;
        $finalArr['ApiMessage'] = $msg;

        if (!empty($value)){
            $json = json_encode($value);
            $apiList = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json));

            if (is_array($apiList)){
                $finalArr['ApiList'] = $apiList;
            }else{
                $value = json_decode($json,true);
                $finalArr['ApiValue'] = $apiList;

            }
        }

        return $finalArr;

    }

    public function generateUserKey($user){
        return $user.'.'.md5(uniqid(rand(), TRUE));
    }

    public function generateGuid()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function checkApiKey($request){
        // echo var_dump($request->getHeaders());
        $ApiKey = $request->getHeaderLine(Utility::HEADER1);
        $UserKey = $request->getHeaderLine(Utility::HEADER2);
        $ContentType = $request->getHeaderLine(Utility::HEADER3);

        if (!empty($ApiKey)){
          if (Utility::API_KEY == $ApiKey){
            return true;
          }else{
            return false;
          }

        }else{
            return false;
        }
    }

    public function checkHeader($request){
        // echo var_dump($request->getHeaders());
        $ApiKey = $request->getHeaderLine(Utility::HEADER1);
        $UserKey = $request->getHeaderLine(Utility::HEADER2);
        $ContentType = $request->getHeaderLine(Utility::HEADER3);

        if (!empty($ApiKey) && !empty($UserKey) /*&& $ContentType == Utility::CONTENT_TYPE*/){
            $parts = explode('.', $UserKey);

            if (count($parts) > 1 && Utility::API_KEY == $ApiKey){
                $UserId = $parts[0];

                $LoginTbl = LoginTbl::where('user_id',$UserId)->orderBy('created_at', 'desc')->first();
                if ($LoginTbl->user_key == $UserKey){
                    $result = $LoginTbl->user;

                }else{
                    $result = null;
                }

                return $result;
            }else{
                return null;
            }


        }else{
            return null;
        }
    }

    private function getHttpStatusCode($code){
        $text = '';
         if ($code !== NULL) {

                switch ($code) {
                    case 100: $text = 'Continue'; break;
                    case 101: $text = 'Switching Protocols'; break;
                    case 200: $text = 'OK'; break;
                    case 201: $text = 'Created'; break;
                    case 202: $text = 'Accepted'; break;
                    case 203: $text = 'Non-Authoritative Information'; break;
                    case 204: $text = 'No Content'; break;
                    case 205: $text = 'Reset Content'; break;
                    case 206: $text = 'Partial Content'; break;
                    case 300: $text = 'Multiple Choices'; break;
                    case 301: $text = 'Moved Permanently'; break;
                    case 302: $text = 'Moved Temporarily'; break;
                    case 303: $text = 'See Other'; break;
                    case 304: $text = 'Not Modified'; break;
                    case 305: $text = 'Use Proxy'; break;
                    case 400: $text = 'Bad Request'; break;
                    case 401: $text = 'Unauthorized'; break;
                    case 402: $text = 'Payment Required'; break;
                    case 403: $text = 'Forbidden'; break;
                    case 404: $text = 'Not Found'; break;
                    case 405: $text = 'Method Not Allowed'; break;
                    case 406: $text = 'Not Acceptable'; break;
                    case 407: $text = 'Proxy Authentication Required'; break;
                    case 408: $text = 'Request Time-out'; break;
                    case 409: $text = 'Conflict'; break;
                    case 410: $text = 'Gone'; break;
                    case 411: $text = 'Length Required'; break;
                    case 412: $text = 'Precondition Failed'; break;
                    case 413: $text = 'Request Entity Too Large'; break;
                    case 414: $text = 'Request-URI Too Large'; break;
                    case 415: $text = 'Unsupported Media Type'; break;
                    case 500: $text = 'Internal Server Error'; break;
                    case 501: $text = 'Not Implemented'; break;
                    case 502: $text = 'Bad Gateway'; break;
                    case 503: $text = 'Service Unavailable'; break;
                    case 504: $text = 'Gateway Time-out'; break;
                    case 505: $text = 'HTTP Version not supported'; break;
                    default:
                        $text = 'Unknown http status code' ;
                        exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
                }

        }
        return $text;
    }

    function array_change_key_case_ext(array $array, $useMB = false, $mbEnc = 'UTF-8') {
        $newArray = array();

        //for more speed define the runtime created functions in the global namespace

        //get function
        $function = 'ucfirst';


        //loop array
        foreach($array as $key => $value) {
            if(is_array($value)) //$value is an array, handle keys too
                $newArray[$function($key)] = array_change_key_case_ex($value, $case, $useMB);
            elseif(is_string($key))
                $newArray[$function($key)] = $value;
            else $newArray[$key] = $value; //$key is not a string
        } //end loop

        return $newArray;
    }


}
?>
