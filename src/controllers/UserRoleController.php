<?php namespace App\Controllers;

use app\models\UserRoleTbl;

use app\utilities\Utility;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use \Datetime;


class UserRoleController {

    public function UserRoles(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $UserTbl = Utility::checkHeader($request);
        if (!is_null($UserTbl)){
            $arr =  UserRoleTbl::get();
                if (!is_null($arr)){

                    $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_OK,"",$arr));

                }else{
                    $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Cannot get the roles",null));
                }


        }else{
            $result = json_encode(Utility::getResponse(Utility::HTTP_CODE_BAD_REQUEST,"Header null",null));
        }

        $response->getBody()->write($result);
        return $response;
    }



}


?>
