<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
@OA\Info(
    description="",
    version="1.0.0",
    title="Employee Api",
 )
*/
/**
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   in="header"
 * )
 */

class UserController extends Controller
{

    /**
     * @OA\Get(
     *   path="/api/view-employees",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="successful operation"),
     *   @OA\Response(response=406, description="not acceptable"),
     *   @OA\Response(response=500, description="internal server error"),
     * )
     *
     */
    public function viewEmployees(Request $request)
    {
        if ($request->user()->tokenCan('view')) {

           $employees = Employee::all();
           if(empty($employees)){
               return response()->json([
                   'code' => 404,
                   'data' => "No Employees Found"
               ]);
           }
            return response()->json([
                'code' => 200,
                'data' => $employees
            ]);

        }
        return response()->json(401);
    }


    /**
     * @OA\Get(
     *   path="/api/view-single-employee/{id}",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="successful operation"),
     *   @OA\Response(response=406, description="not acceptable"),
     *   @OA\Response(response=500, description="internal server error"),
     *   @OA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *           @OA\Schema(
     *          type="integer"
     *          )
     *      ),
     * )
     *
     */
    public function viewSingleEmployees(Request $request, $id)
    {
        if ($request->user()->tokenCan('view')) {

            $employee = Employee::all()->where('id',$id);
            if(empty($employee)){
                return response()->json([
                    'code' => 404,
                    'data' => "No Employee Found"
                ]);
            }
            return response()->json([
                'code' => 200,
                'data' => $employee
            ]);

        }
        return response()->json(401);
    }

    /**
     * @OA\Put(
     *   path="/api/update-employees/{id}",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(response=200, description="successful operation"),
     *   @OA\Response(response=406, description="not acceptable"),
     *   @OA\Response(response=500, description="internal server error"),
     *   @OA\Parameter(
     *          name="firstname",
     *          in="query",
     *          required=true,
     *           @OA\Schema(
     *          type="string"
     *          )
     *      ),
     *   @OA\Parameter(
     *     name="lastname",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *     name="prof_qual",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *     name="dob",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *     name="address",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *     name="phone_number",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *     name="next_of_kin",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *     name="marital_status",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *     type="string"
     *      )
     *   )
     *
     * )
     *
     */
    public function updateEmployees(Request $request, $id)
    {
        if ($request->user()->tokenCan('update')) {
            $employee=Employee::find($id);
            if(empty($employee)){
                return response()->json([
                    'code' => 404,
                    'data' => "No User With The ID Found"
                ]);
            }
            Employee::where('id', $id)
                ->update([
                    'firstname' => $request['firstname'],
                    'lastname' => $request['lastname'],
                    'prof_qual' => $request['prof_qual'],
                    'dob' => strtotime($request['dob']),
                    'address' => $request['address'],
                    'phone_number' => $request['phone_number'],
                    'next_of_kin' => $request['next_of_kin'],
                    'marital_status' => $request['marital_status']
                ]);

            return response()->json([
                'code' => 201,
                'message' => "User Updated Successfully"
            ]);
        }

    }

    public function createusers(Request $request)
    {
        User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request["email"],
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);
        return response()->json([
            'code' => 201,
            'message' => "User Created Successfully"
        ]);
    }


    public function createEmployees(Request $request)
    {

            Employee::create([
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'prof_qual' => $request['prof_qual'],
                'dob' => time(),
                'address' => $request['address'],
                'phone_number' => $request['phone_number'],
                'next_of_kin' => $request['next_of_kin'],
                'marital_status' => $request['marital_status']
                ]);

            return response()->json([
                'code' => 201,
                'message' => "User Created Successfully"
            ]);
        //}

    }



}
