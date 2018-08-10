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

class LoginController {

    public function __construct() {

    }

    private function store($arr){
      DB::beginTransaction();
       try {

        $loginTbl  = new LoginTbl;
        $loginTbl->user_id = $arr['user_id'];
        $loginTbl->user_key = $arr['user_key'];
        $loginTbl->token = $arr['token'];
        $loginTbl->save();
        DB::commit();

        return $loginTbl;
      } catch (\Exception $e) {

        DB::rollback();
        return null;
      }

    }



    /*    request for signin method
          {username, password}
        */
    public function signin(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $name = "";
        $email = "";
        
        $correctApiKey = Utility::checkApiKey($request);

        if ($correctApiKey){
         
              $result = $this->createLogin($req);
           

        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }

    private function createLogin($req){
      //initialize usertbl data
//!empty($req['name']
    
      $userTbl = UserTbl::where('username',$req['username'])->where('password',$req['password'])->get()->first();
      

      if ($userTbl != null){
          //generate user key
          $userId = $userTbl->id;
          $userKey = Utility::generateUserKey($userId);

          $userTbl->user_key = $userKey;
          $UserRole = UserRoleTbl::where('id',$userTbl->role_id)->get()->first();
          $userTbl->role_code = $UserRole->code;
          $insertArr = array(
              'user_id' => $userTbl->id,
              'user_key' => $userKey,
              'token' => ""
          );

          $loginTbl = $this->store($insertArr);

          if (!is_null($loginTbl)){

            
            $parameterTbl = ParameterTbl::get();
            $accountTbl = AccountTbl::where('user_id',$userTbl->id)->get(); 

            $transaction = array();
    
            foreach ($accountTbl as $value) {
                $transactionTbl = TransactionTbl::where('account_id',$value->id)->get();
                $value->transactions = $transactionTbl;
                array_push($transaction, $value);
            }

            
            $data = array();
            $data['user_tbl'] = $userTbl;
            $data['parameter_tbl'] = $parameterTbl;
            $data['account_tbl'] = $transaction;
            


            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$data));
          }else{
            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot input your login data",null));
          }
      }else{
        $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry ,username & password did not match",null));

      }

     
      return $result;
    }

}






?>
