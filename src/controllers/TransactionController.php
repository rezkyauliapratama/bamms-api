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

    public function transferToAnotherAccount(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $header = Utility::checkHeader($request);

        if ($header){
              $transactionTbl = $this->transactionTransfer($req);
              if ($transactionTbl != null){
                $accountTbl = AccountTbl::where('id',$transactionTbl->account_id)->get()->first();
            
                if ($accountTbl != null){
                    $totalAmount = 0;
                   $listTransactions = TransactionTbl::where('account_id',$accountTbl->id)->get();            
                    foreach ($listTransactions as $value) {
                        $parameterTbl = ParameterTbl::where('parameter_id',$value->type)->get()->first();
                        if ($parameterTbl->code == "CREDIT"){
                            $totalAmount += $value->amount;
                        }else{
                            $totalAmount -= $value->amount;
                        }       
                    }
                    $accountTbl->balance = $totalAmount;

                    $this->storeAccount($accountTbl);

                    $transactionTbl->account = $accountTbl;
                }
              $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$transactionTbl));

              }else{
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Cannot proses your transfer",null));
              }

        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }


    private function storeAccount($accountTbl){
        DB::beginTransaction();
        try {

        
         $accountTbl->save();
         DB::commit();
 
         return $accountTbl;
       } catch (\Exception $e) {
 
         DB::rollback();
         return null;
       }
    }

    private function transactionTransfer($req){
        $from = $req['from_account'];
        $to = $req['to_account'];
        $fromAccount = AccountTbl::where('account_number',$from)->get()->first();
        $toAccount = AccountTbl::where('account_number',$to)->get()->first();
        
        $paramFrom = ParameterTbl::where('code',"DEBIT")->get()->first();
        $paramTo = ParameterTbl::where('code',"CREDIT")->get()->first();

        DB::beginTransaction();
        try {
 
         $transactionTbl1  = new TransactionTbl;
         $transactionTbl1->account_id = $fromAccount->id;
         $transactionTbl1->type = $paramFrom->parameter_id;
         $transactionTbl1->date = $req['date'];
         $transactionTbl1->name = "Transfer to ".$toAccount->account_number;
         $transactionTbl1->amount = $req['amount'];
         $transactionTbl1->save();

         $transactionTbl2  = new TransactionTbl;
         $transactionTbl2->account_id = $toAccount->id;
         $transactionTbl2->type = $paramTo->parameter_id;
         $transactionTbl2->date = $req['date'];
         $transactionTbl2->name = "Received from ".$toAccount->account_number;
         $transactionTbl2->amount = $req['amount'];
         $transactionTbl2->save();
         DB::commit();
 
         return $transactionTbl1;
       } catch (\Exception $e) {
        echo $e;
         DB::rollback();
         return null;
       }
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        
        $body = $request->getBody();
        $req = json_decode($body,true);

        $header = Utility::checkHeader($request);

        if ($header){
              $transactionTbl = $this->storeTransaction($req);
              if ($transactionTbl != null){
                $accountTbl = AccountTbl::where('id',$req['account_id'])->get()->first();
            
                if ($accountTbl != null){
                    $totalAmount = 0;
                   $listTransactions = TransactionTbl::where('account_id',$req['account_id'])->get();            
                    foreach ($listTransactions as $value) {
                        $parameterTbl = ParameterTbl::where('parameter_id',$value->type)->get()->first();
                        if ($parameterTbl->code == "CREDIT"){
                            $totalAmount += $value->amount;
                        }else{
                            $totalAmount -= $value->amount;
                        }       
                    }
                    $accountTbl->balance = $totalAmount;
                    $this->storeAccount($accountTbl);

                    $transactionTbl->account = $accountTbl;
                }
              }
              $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$transactionTbl));

        }else{
        	 $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Error",null));
        }


        $response->getBody()->write($result);

    }

    private function storeTransaction($req){
        DB::beginTransaction();
        try {
 
         $transactionTbl  = new TransactionTbl;
         $transactionTbl->account_id = $req['account_id'];
         $transactionTbl->type = $req['type'];
         $transactionTbl->date = $req['date'];
         $transactionTbl->name = $req['name'];
         $transactionTbl->amount = $req['amount'];
        
         $transactionTbl->save();
         DB::commit();
 
         return $transactionTbl;
       } catch (\Exception $e) {
 
         DB::rollback();
         return null;
       }
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
              if ($result != null){
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$result));

              }else{
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Sorry , cannot proses your data",null));

              }
           

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

                    if (count($transactionTbl) > 0){
                        foreach ($transactionTbl as $val2) {
                            $val2->account = $value;
                            array_push($transaction, $val2);
                        }
                       
                    }
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
                            ->get()->first();
            
            if ($accountTbl != null){
            
                $transactionTbl = TransactionTbl::where('account_id',$accountTbl->id)
                ->where('date', '>=', $req['start_date'])
                ->where('date', '<=', $req['end_date'])
                ->get();
                    
                if (count($transactionTbl)>0){
                    foreach ($transactionTbl as $val2) {
                        $val2->account = $accountTbl;
                
                    }
                }
                
                $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$transactionTbl));
           
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
