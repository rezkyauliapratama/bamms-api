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

class TransactionController {

    public function __construct() {

    }

    /*    request for signin method
          {username, password}
        */
    public function getAllTransactions(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $header = Utility::checkHeader($request);

        if ($header){
                $userKey = $request->getHeaderLine(Utility::HEADER2);

              $result = $this->retriveTransaction($req,$userKey,null);
           

        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }

   /*  {
        "start_date":"".
        "end_date":""

    } */
    public function getAllTransactionsByDate(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $header = Utility::checkHeader($request);

        if ($header){
            $userKey = $request->getHeaderLine(Utility::HEADER2);

            $loginTbl = LoginTbl::where('user_key',$userKey)->get()->first();
            $accountTbl = AccountTbl::where('user_id',$loginTbl->user_id)->get();
            
            if ($accountTbl != null){
                $transaction = array();
        
                foreach ($accountTbl as $value) {
                  
                        $transactionTbl = TransactionTbl::where('account_id',$value->id)
                        ->where('date', '>=', $req['start_date'])
                        ->where('date', '<=', $req['end_date'])
                        ->get();
                    
                    array_push($transaction, $transactionTbl);
                }
                
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$transaction));
           
            }else{
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot proses your data",null));
    
            }
        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }

    /*  {
        "id":"",    
        "start_date":"".
        "end_date":""

    } */
    public function getAccountTransactionsByDate(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $header = Utility::checkHeader($request);

        if ($header){
            $userKey = $request->getHeaderLine(Utility::HEADER2);
            $loginTbl = LoginTbl::where('user_key',$userKey)->get()->first();

            $accountTbl = AccountTbl::where('user_id',$loginTbl->user_id)
                            ->where('user_id',$loginTbl->user_id)
                            ->where('id',$req['id'])
                            ->get();
            
            if ($accountTbl != null){
            
                $transactionTbl = TransactionTbl::where('account_id',$accountTbl->id)
                ->where('date', '>=', $req['start_date'])
                ->where('date', '<=', $req['end_date'])
                ->get();
                    
                
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$transaction));
           
            }else{
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot proses your data",null));
    
            }
        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }


    private function retriveTransaction($req,$userKey,$query){
        $loginTbl = LoginTbl::where('user_key',$userKey)->get()->first();
        $accountTbl = AccountTbl::where('user_id',$loginTbl->user_id)->get();
        
        if ($accountTbl != null){
            $transaction = array();
    
            foreach ($accountTbl as $value) {
                if ($query == null){
                    $transactionTbl = TransactionTbl::where('account_id',$value->id)->get();
                }
                array_push($transaction, $transactionTbl);
            }
            
            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$transaction));
        }else{
            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot proses your data",null));

        }
        return $result;
    }
  

}






?>
