<?php namespace App\Controllers;

use app\models\UserRoleTbl;
use app\models\LoginTbl;
use app\models\UserTbl;
use app\models\ParameterTbl;
use app\models\AccountTbl;
use app\models\TransactionTbl;

use Illuminate\Database\Capsule\Manager as DB;
use \Datetime;


use app\utilities\Utility;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class AccountController {

    public function __construct() {

    }

    /*    request for signin method
          {username, password}
        */
    public function getAccounts(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $header = Utility::checkHeader($request);

        if ($header){
                $userKey = $request->getHeaderLine(Utility::HEADER2);

              $result = $this->retrieveAccounts($req,$userKey);
           

        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }

    public function getByAccountNumber(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $header = Utility::checkHeader($request);

        if ($header){
            $accountTbl = AccountTbl::where('account_number',$req['account_number'])->get()->first();
            $userTbl = UserTbl::where('id',$accountTbl->user_id)->get()->first();
            $accountTbl->user = $userTbl;
            
            if ($accountTbl != null){
                
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$accountTbl));
            }else{
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot proses your data",null));
    
            }
           

        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }


    private function retrieveAccounts($req,$userKey){
        $loginTbl = LoginTbl::where('user_key',$userKey)->get()->first();
        $accountTbl = AccountTbl::where('user_id',$loginTbl->user_id)->get();
        
        if ($accountTbl != null){
            
            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$accountTbl));
        }else{
            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot proses your data",null));

        }
        return $result;
    }
  

}






?>
