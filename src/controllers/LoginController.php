<?php namespace App\Controllers;

use app\models\UserRoleTbl;
use app\models\LoginTbl;
use app\models\UserTbl;
use app\models\ParameterTbl;
use app\models\ActivityTbl;
use app\models\ActivityDetailTbl;

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

    private function storeUser($arr){
      DB::beginTransaction();
       try {

        $userRole = UserRoleTbl::where('code',Utility::USER_ADMIN)->first();

        if (!is_null($userRole)){
          $userTbl = UserTbl::find($arr['id']);
          if (is_null($userTbl)){
            $userTbl = new UserTbl;
          }
          $userTbl->role_id = $userRole->id;
          $userTbl->name = $arr['name'];
          $userTbl->email = $arr['email'];
          $userTbl->sign_id = $arr['sign_id'];
          $userTbl->save();
          DB::commit();
          return $userTbl;
        }
      } catch (\Exception $e) {
        DB::rollback();
        echo $e;
      }
      return null;

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
          
          $insertArr = array(
              'user_id' => $userTbl->id,
              'user_key' => $userKey,
              'token' => ""
          );

          $loginTbl = $this->store($insertArr);

          if (!is_null($loginTbl)){

            
            $parameterTbl = ParameterTbl::get();
            

            $data = array();
            $data['user_tbl'] = $loginTbl;

            $data['parameter_tbl'] = $parameterTbl;

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
