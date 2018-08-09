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



    public function signin(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        /*
          {name, email, token, sign_id}
        */
        $body = $request->getBody();
        $req = json_decode($body,true);

        $name = "";
        $email = "";
        $token = "";
        $signId = "";
        $isRegister = false;

        if (!empty($req['name'])){
          $name = $req['name'];
        }

        if (!empty($req['email'])){
          $email = $req['email'];
          $isRegister = true;

        }

        if (!empty($req['token'])){
          $token = $req['token'];
        }

        if (!empty($req['sign_id'])){
          $signId = $req['sign_id'];
        }

        $count = 0;
        if ($isRegister){
          $res = UserTbl::where('email',$req['email']);
          $count = $res->count();
        }

        $correctApiKey = Utility::checkApiKey($request);

        if ($count == 1 && $correctApiKey){
          $userTbl = $res->first();
          $userTbl->sign_id = $signId;
          $result = $this->createLogin($userTbl,$token);


        }else if ($count == 0 && $correctApiKey){

            $loginTbl = LoginTbl::where('token',$token)->orderBy('id', 'DESC')->first();

            $userId = 0;

            if (!is_null($loginTbl)){
              $userId = $loginTbl->user_id;
            }
            $userArr = array(
                'id' => $userId,
                'name' => $name,
                'email' => $email,
                'sign_id' => $signId,
            );

            $userTbl = $this->storeUser($userArr);

            if (!is_null($userTbl)){
              $result = $this->createLogin($userTbl,$token);
            }else{
              $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot create new user",$data));
            }

        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);
        return $response;

    }

    private function createLogin($userTbl,$token){
      //initialize usertbl data

      DB::beginTransaction();
       try {
          $userTbl->save();
          DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        return null;
      }

      //generate user key
      $userId = $userTbl->id;
      $userKey = Utility::generateUserKey($userId);


      $insertArr = array(
          'user_id' => $userTbl->id,
          'user_key' => $userKey,
          'token' => $token
      );

      $loginTbl = $this->store($insertArr);

      if (!is_null($loginTbl)){

        $loginArr = array(
            'name' => $userTbl->name,
            'email' => $userTbl->email,
            'sign_id' => $userTbl->sign_id,
            'user_id' => $userTbl->id,
            'user_key' => $loginTbl->user_key,
            'token' => $loginTbl->token
        );

        $parameterTbl = ParameterTbl::get();
        $activityTbl = ActivityTbl::where('user_id',$userTbl->id)->get();

        $detail = array();

        foreach ($activityTbl as $value) {
            $detailTbl = ActivityDetailTbl::where('activity_id',$value->id)->get();
            $value->details = $detailTbl;
            array_push($detail, $value);
        }

        $data = array();
        $data['user_tbl'] = $loginArr;
        $data['parameter_tbl'] = $parameterTbl;
        $data['activity_tbl'] = $detail;

        $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$data));
      }else{
        $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot input your login data",null));
      }
      return $result;
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        // proceed to deleting a new user
    }



}


?>
