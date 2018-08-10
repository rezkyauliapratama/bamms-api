<?php namespace App\Controllers;

use Illuminate\Database\Query\Builder;
use app\models\UserTbl;
use app\models\AccountTbl;
use app\models\ParameterTbl;
use app\models\UserRoleTbl;
use app\utilities\Utility;
use app\models\LoginTbl;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use Illuminate\Database\Capsule\Manager as DB;
use \Datetime;

class UserController {
   /*
    protected $table;

    public function __construct(Builder $table) {

        $this->table = $table;
    }*/


    public function users(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $result = UserTbl::get()->toJson();
        $response->getBody()->write($result);
    }

    public function userbyid(ServerRequestInterface $request, ResponseInterface $response, $args)
    {   
            $id = $args['id'];
            $result = UserTbl::find($id)->toJson();
            $response->getBody()->write($result);
    }


  
/*  
request for create function   
    {
        "role_code": "CUSTOMER",
        "name": "rezky aulia",
        "email": "rezkyaulia@gmail.com",
        "phone": "081210101",
        "address": "add2",
        "username": "itsa049",
        "password": "1234",
        "id": "1",
        "type_code": "MASTERCARD"
      } */
    public function create(ServerRequestInterface $request, ResponseInterface $response, $args)
    {


        $body = $request->getBody();
        $req = json_decode($body,true);

        if (isset($req['role_code'])){
            $userRole = UserRoleTbl::where('code',$req['role_code'])->get()->first();
            $req['role_id'] = $userRole->id;
            if ($userRole != null){
                $user = $this->store($req,$userRole);

                if ($user != null){
                    $insertedId = $user->id;
                    if ($insertedId > 0){
                        $paramTbl = ParameterTbl::where('code',$req['type_code'])->get()->first();
                        if ($paramTbl != null){
                            $accountTbl = $this->storeAccount($user,$paramTbl);
                            if ($accountTbl != null){
                                $resArrr = array(
                                    'user_tbl' => $user,
                                    'account_tbl' => $accountTbl
                                );
                                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_CREATED,"created",$resArrr));
                            }else{
                                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Cannot created the account",null));

                            }   
                        }else{
                         $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Cannot created the account",null));
                        }
                    }else{
                        $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Cannot created the account",null));

                    }
                }else{
                    $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"This username / email already registered",null));
                }
            }else{
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Cannot create this account",null));
            }
        }else{
            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Cannot create this account",null));
        }



        $response->getBody()->write($result);
    }

    public function store($req,$userRole)
	{
		 DB::beginTransaction();
	    try {
	        
            $userTbl = new UserTbl();
            $userTbl->name = $req['name'];
	        $userTbl->email = $req['email'];
			$userTbl->password = $req['password'];
			$userTbl->username = $req['username'];
			$userTbl->role_id = $userRole->id;
			$userTbl->address = $req['address'];
			$userTbl->phone = $req['phone'];

	        $userTbl->save();
	        DB::commit();

	        return $userTbl;
	    } catch (\Exception $e) {
            echo $e;
	        DB::rollback();
	        return null;
	    }


    }
    

    public function storeAccount($userTbl,$paramTbl)
	{
		 DB::beginTransaction();
	    try {
	        $formatted_value = sprintf("%07d", $userTbl->id);
            $customerAccount = "1".$formatted_value;

            $accountTbl = new AccountTbl();
            $accountTbl->type = $paramTbl->parameter_id;
	        $accountTbl->user_id = $userTbl->id;
			$accountTbl->balance = 0;
			$accountTbl->account_number = $customerAccount;
			$accountTbl->description = "";
			
	        $accountTbl->save();
	        DB::commit();

	        return $accountTbl;
	    } catch (\Exception $e) {
            echo $e;
	        DB::rollback();
	        return null;
	    }


	}


}


?>
