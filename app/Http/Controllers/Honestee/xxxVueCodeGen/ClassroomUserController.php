<?php 
namespace App\Http\Controllers\Honestee\VueCodeGen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Schema;

use App\Models\Honestee\VueCodeGen\ClassroomUser;


use DB;
use Str;


class ClassroomUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return    void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return    \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }
        $this->authorize('isAdmin');

        if($request['id'] == "all"){
            $result = ClassroomUser::all();
            return $this->sendResponse($result, 'classroom_user list ');

        }else if($request['id']){
            $result = ClassroomUser::findOrFail($request['id']);
            return $this->sendResponse($result, 'classroom_user ');
        }



        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', '5');
        $sortType = $request->query('sortType', 'asc');
        $sortField = $request->query('sortField');
        $searchTerm = $request->query('searchTerm', '');

        $model = "App\Models\Honestee\VueCodeGen\\".ucfirst($request->query('pv_tbl', ''));
        $model_id = $request->query('pv_id', '');
        $relation = Str::plural($request->query('tbl', ''));



        if($model_id && $relation ){ // Many to Many relationships
            $query = $model::find($model_id)->{$relation}();
        } else {
            $query = ClassroomUser::query();
        }

        if($request['searchTerm'])
            $query = $this->search($request, $query);
        
        if($sortField)
            $classroom_user = $query->orderBy($sortField, $sortType)->paginate( $perPage );
        else       
            $classroom_user = $query->paginate( $perPage );
  
        return $this->sendResponse($classroom_user, 'classroom_user list ');
    }


    public function search($request, $query)
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }
        $this->authorize('isAdmin');

        $fields = Schema::getColumnListing('$classroom_user');
        foreach( $fields as $field) {
            $query = $query->orWhere($field, 'LIKE', '%'.$request['searchTerm']. '%');
        }
        return $query;    
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param    $request
     *
     * @param    $id
     *
     * @return    \Illuminate\Http\Response
     * @throws    \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // ******* Using attach *********
        //$user->tasks()->getRelatedIds(); // [1,2,3,4,5,6]
        //$user->tasks()->attach([5,6,7]);
        // then
        //$user->tasks()->getRelatedIds(); // [1,2,3,4,5,6,5,6,7]

        // ******** Using sync *********
        //$user->roles()->getRelatedIds(); // [1,2,3,4,5,6]
        //$user->tasks()->sync([1,2,3]);
        // then
        //$user->tasks()->getRelatedIds(); // [1,2,3]

        //or
        //$user->tasks()->sync([5,6,7,8], false); // 2nd param = detach
        // then
        //$user->tasks()->getRelatedIds(); // [1,2,3,4,5,6,7,8]
        // *****************************


        $model = "App\Models\Honestee\VueCodeGen\\".ucfirst($request->query('pv_tbl', ''));
        $model_id = $request->query('pv_id', '');
        $pv_ids = $request->query('pv_ids', '');
        $relation = Str::plural($request->query('tbl', ''));

        if($model_id && $relation &&  $pv_ids){ // Many to Many relationships
            $query = $model::find($model_id)->{$relation}()->sync( explode(",", $pv_ids) );
            return $this->sendResponse($query, ucfirst($relation)." were attached to the ".ucfirst($request->query('pv_tbl', '')." Successfully"));
        } else {
            $this->checkValidation($request);
            $classroomuser = ClassroomUser::create($request->all());    
            return $this->sendResponse( $classroomuser, 'ClassroomUser Created Successfully');
        }


     }



    public function checkValidation(Request $request){
        $data = DB::select('DESCRIBE '.strtolower( 'classroom_user' ));
        $validationInfo = array();

        foreach($data as $column){  // First array element as  Require field definition 
            //extract the number for the max attribute
            preg_match_all('!\d+!', $column->Type, $matches);
            $max = (isset($matches[0][0])) ? (int)$matches[0][0] : false;
            $required = ($column->Null == 'NO') ? true : false ;
            if($required && $max && $column->Field != "id" && $column->Field !="created_at" && $column->Field !="updated_at" )
                $validationInfo[$column->Field] = 'required';
            else if($required && $column->Field != "id" && $column->Field !="created_at" && $column->Field !="updated_at" )
                $validationInfo[$column->Field] = 'required';

        }

        foreach($data as $column){ // Second array element as  Require field error messages
            //extract the number for the max attribute
            preg_match_all('!\d+!', $column->Type, $matches);
            $max = (isset($matches[0][0])) ? (int)$matches[0][0] : false;

            // Extract if its required
            $required = ($column->Null == 'NO') ? true : false ;

            if($required && $column->Field != "id" && $column->Field !="created_at" && $column->Field !="updated_at" ){
                $validationInfo[$column->Field.'.required'] = $column->Field.' is a required field.';
            }

            if($max && $column->Field != "id" && $column->Field !="created_at" && $column->Field !="updated_at" ){
                $validationInfo[$column->Field.'.max'] = $column->Field.' can only be '.$max.' characters.';
            }
        }

        return $request->validate($validationInfo);
    }


    /**
     * Update the resource in storage
     *
     * @param    $request
     * @param    $id
     *
     * @return    \Illuminate\Http\Response
     * @throws    \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->checkValidation($request);
        $classroomuser = ClassroomUser::findOrFail($id);
        $input = $request->all();
        $classroomuser->fill($input)->save();
        return $this->sendResponse($classroomuser, 'ClassroomUser Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param        int  $id
     * @return    \Illuminate\Http\Response
     */
    public function destroy($parameters)
    {
        $data = (array)json_decode($parameters);


        if (array_key_exists('tbl', $data) && array_key_exists('pv_tbl', $data) 
            && array_key_exists('pv_id', $data) && array_key_exists('pv_id', $data) ) 
           { // Many to Many relationships
        
            $model = "App\Models\Honestee\VueCodeGen\\".ucfirst($data['pv_tbl']);
            $model_id = $data['pv_id'];
            $pv_ids = $data['pv_ids'];
            $relation = Str::plural($data['tbl']);

            $query = $model::find($model_id)->{$relation}()->detach( $pv_ids );
            return $this->sendResponse($query, ucfirst($relation)." were detached from the ".ucfirst( $data['pv_tbl'] )." Successfully");
        } else {
            $idsArray = json_decode($parameters,true);
            ClassroomUser::whereIn('id', $idsArray)->delete();
            return $this->sendResponse($idsArray, "The record was deleted successfully.");
        }
    }



    /** 
    * success response method.
     *
     * @param    $result
     * @param    $message
     *
     * @return    \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success'        => true,
            'message'        => $message,
            'data'           => $result,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @param    $error
     * @param        array  $errorMessages
     * @param        int  $code
     *
     * @return    \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }


    /**
     * return Unauthorized response.
     *
     * @param    $error
     * @param        int  $code
     *
     * @return    \Illuminate\Http\Response
     */
    public function unauthorizedResponse($error = 'Forbidden', $code = 403)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        return response()->json($response, $code);
    }



} ?>