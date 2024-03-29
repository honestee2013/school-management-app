<?php 
namespace App\Http\Controllers\Honestee\VueCodeGen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Schema;

use App\Models\Honestee\VueCodeGen\Resultinfo;
use App\Models\Honestee\VueCodeGen\Assessment;
use App\Models\Honestee\VueCodeGen\Subject;
use App\Models\Honestee\VueCodeGen\Classroom;
use App\Models\Honestee\VueCodeGen\User;


use DB;
use Str;


class AssessmentController extends Controller
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

        if($request['resultinfo'] == 'get' )
            return $this->getResultinfo($request);
        else if($request['resultinfo'] == 'set' )
            return $this->setResultinfo($request);

        if($request['id'] && $request['term'] && $request['year'] ){
            
       
            //Classroom::find($assessments->first()->classroom_id)->users()->get();
            //$userAssessments = $this->getUserAssessments($request['id'], $request['term'] , $request['year']);
            $classroomId = User::where("id", $request['id'])->first()->currentClassroom()->first()->id;
            $classroomAssessments = $this->getClassroomAssessments($classroomId, $request['term'] , $request['year']);
            ///$classroomSubjects = Classroom::find($classroomId)->subjects;
            //$classroomAssessments = $this->getClassroomAssessments($userAssessments->first()->classroom_id, $request['term'] , $request['year']);
            $preparedClassroomResult = $this->prepareClassroomResult( $request,  $classroomAssessments);



///return $this->sendResponse($preparedClassroomResult[$request['id']], 'Result list ');
//return $this->sendResponse($classroomSubjects, 'Result list ');


            if (array_key_exists($request['id'], $preparedClassroomResult))
                return $this->sendResponse($preparedClassroomResult[$request['id']], 'Result list ');
            else
                return $this->sendResponse(null, 'No result with user id: '.$request['id']." found!");

            //$students = Classroom::find($assessments->first()->classroom_id)->users()->get();
            //return $this->sendResponse($this->prepareUserResult( $assessments), 'Assessments list ');

        }else if(Str::plural($request['id'] == 'all')){
            $result = Assessment::all();
            return $this->sendResponse($result, 'Assessments list ');
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
            $query = Assessment::query();
        }

        if($request['searchTerm'])
            $query = $this->search($request, $query);
        
        if($sortField)
            $assessments = $query->orderBy($sortField, $sortType)->paginate( $perPage );
        else       
            $assessments = $query->paginate( $perPage );
  
        return $this->sendResponse($assessments, 'Assessments list ');
    }


    public function setResultInfo(Request $request){

        $resultInfo = Resultinfo::firstOrNew( 
            array(
                'session' => $request['session'],
                'term' => $request['term'],
                'user_number' => $request['user_number']
            ) 
        );
        
        $resultInfo->result_scope = 'student';
        $resultInfo->user_number = $request['user_number'];
        $resultInfo->owner_id = $request['user_id'];

        $resultInfo->effective_punctuality = $request['effective_punctuality'];
        $resultInfo->effective_politeness = $request['effective_politeness'];
        $resultInfo->effective_neatness = $request['effective_neatness'];
        $resultInfo->effective_honesty = $request['effective_honesty'];
        $resultInfo->effective_leadership_skill = $request['effective_leadership_skill'];
        $resultInfo->effective_cooperation = $request['effective_cooperation'];
        $resultInfo->effective_attentiveness = $request['effective_attentiveness'];
        $resultInfo->effective_perseverance = $request['effective_perseverance'];
        $resultInfo->effective_attitude_to_work = $request['effective_attitude_to_work'];

        $resultInfo->psychomotor_handwriting = $request['psychomotor_handwriting'];
        $resultInfo->psychomotor_verbal_fluency = $request['psychomotor_verbal_fluency'];
        $resultInfo->psychomotor_sport = $request['psychomotor_sport'];
        $resultInfo->psychomotor_handling_tools = $request['psychomotor_handling_tools'];
        $resultInfo->psychomotor_drawing_and_painting = $request['psychomotor_drawing_and_painting'];
        $resultInfo->psychomotor_cooperation = $request['psychomotor_cooperation'];
        $resultInfo->psychomotor_attentiveness = $request['psychomotor_attentiveness'];
        $resultInfo->psychomotor_perseverance = $request['psychomotor_perseverance'];
        $resultInfo->psychomotor_attitude_to_work = $request['psychomotor_attitude_to_work'];

        $resultInfo->form_master_comment = $request['form_master_comment'];
        $resultInfo->principal_comment = $request['principal_comment'];

        $resultInfo->message_to_parent = $request['message_to_parent'];
        $resultInfo->message_to_student = $request['message_to_student'];
        $resultInfo->message_to_staff = $request['message_to_staff'];
        
        $resultInfo->debt = 0;
        $resultInfo->next_term_school_fees = 0;
        $resultInfo->section_id = 0;
        $resultInfo->next_term_begins_on = '0';


        $resultInfo->session = $request['session'];
        $resultInfo->term = $request['term'];
        $resultInfo->save();


        return $this->sendResponse($resultInfo, "set Info00000");





    }


    public function getUserAssessments($userId, $term, $year){
        if($userId && $term && $year){
            return Assessment::select("classroom_id", "subject_id", "name", "type", "score")->where([
                'user_id' => $userId,
                'term' => $term,
                'year' => $year,
             ])->get();
        }

        return null;
    }


    public function getClassroomAssessments($classId, $term, $year){
        if($classId && $term && $year){
            return Assessment::select("user_id", "subject_id", "name", "type", "score")->where([
                'classroom_id' => $classId,
                'term' => $term,
                'year' => $year,
             ])->get();
        }

        return null;
    }




    public function prepareUserResult($assessment){

        
        $assessment = $assessment->groupBy('subject_id');

        $newAssessment = $assessment->map(function ($item, $key) {  
            //$key = Subject::find($key)->name;
            $formattedAssessments = [];
            $CA = 0;
            $exams = 0;
            foreach($item as $ass){
                $subject = Subject::find($ass->subject_id)->name;
                $formattedAssessments[$subject]["subject"] = $subject;

                if($ass->name == "Assignment" || $ass->name == "Test"){
                    $CA = $CA + $ass->score;
                    $formattedAssessments[$subject]["ca"] = $CA;  
                }else if($ass->name == "Exams"){
                    $exams = $ass->score;
                    $formattedAssessments[$subject]["exams"] = $ass->score;
                }  
                
                $formattedAssessments[$subject]["total"] = $exams + $CA;

                //$subjectStatistics = $this->getSubjectStatistics($ass->term, $ass->year, $ass, $ass->subject_id);
                //$formattedAssessments[$subject]["highestScore"] = $subjectStatistics['highest'];

            }

            return $formattedAssessments;  // Next subject

        });
         
        return $newAssessment->all();
    }




    public function prepareClassroomResult( $request, $assessments){
        $assessments = $assessments->groupBy('user_id');
        $newAssessment = $assessments->map(function ($item, $key) {  // All subjects assessments
            //$key = Subject::find($key)->name;
            $formattedAssessments = [];
            $CA = 0;
            $exams = 0;
            foreach($item as $ass){ // Single subject assessment
                //$userId = $ass->user_id;
                $subject = Subject::find($ass->subject_id)->name;
                $formattedAssessments[$subject]["subject"] = $subject;
                $formattedAssessments[$subject]["subjectId"] = $ass->subject_id;

                if($ass->name == "Assignment" || $ass->name == "Test"){
                    $CA = $CA + $ass->score;
                    $formattedAssessments[$subject]["ca"] = $CA;  
                }else if($ass->name == "Exams"){
                    $exams = $ass->score;
                    $formattedAssessments[$subject]["exams"] = $ass->score;
                }  

                $formattedAssessments[$subject]["total"] = $exams + $CA;
                $formattedAssessments[$subject]["grade"] = $this->getGrade($exams + $CA);
            }

            return $formattedAssessments;  // Next subject
        });

        return $this->setSubjectStatistics($request, $newAssessment->all());
        //return $newAssessment->all();
    }


    public function getGrade($score) {
        if( $score >= 75)
            return "A"; 
        else if( $score >= 60)
            return "B"; 
        else if( $score >= 50)
            return "C";   
        else if( $score >= 45)
            return "D";       
        else if( $score >= 40)
            return "E";    
        else if( $score < 40)
            return "F";       
    }



    public function setSubjectStatistics($request, $formattedAssessments) {

        $allUsersAllSubjectsScores = [];
        $subjectStatistics = [];
        $userSubjects = [];
        $allUsersAllSubjectsGrandTotal = [];


       $userIds = array_keys($formattedAssessments);
       for($id=0; $id < count( $userIds) ; $id++){
            $userSubjects = array_keys($formattedAssessments[$userIds[$id]]);
            for($subject=0; $subject < count( $userSubjects) ; $subject++){
                $total = $formattedAssessments[ $userIds[$id] ][ $userSubjects[$subject] ]["total"];
                // Each user id with his corresponding all subjects total scores
                $allUsersAllSubjectsScores[$userIds[$id]][ $userSubjects[$subject] ] = $total;
                
                if( array_key_exists($userIds[$id], $allUsersAllSubjectsGrandTotal )){
                    $allUsersAllSubjectsGrandTotal[$userIds[$id]][ "grandTotal" ] 
                        =  $allUsersAllSubjectsGrandTotal[$userIds[$id]][ "grandTotal" ] + $total;
                } else {
                    $allUsersAllSubjectsGrandTotal[$userIds[$id]][ "grandTotal" ] = $total;
                }
            }
       }

       $subjectStatistics = $this->getSubjectStatistics($userIds, $allUsersAllSubjectsScores);

       for($id=0; $id < count( $userIds) ; $id++){
            $userSubjects = array_keys($formattedAssessments[$userIds[$id]]);
            for($subject=0; $subject < count( $userSubjects) ; $subject++){
                $subjectName = $userSubjects[$subject];
                $formattedAssessments[$userIds[$id]][ $subjectName]["max"] = $subjectStatistics[$subjectName]["max"];
                $formattedAssessments[$userIds[$id]][ $subjectName]["min"] = $subjectStatistics[$subjectName]["min"];
                $formattedAssessments[$userIds[$id]][ $subjectName]["ave"] = $subjectStatistics[$subjectName]["ave"];
                $formattedAssessments[$userIds[$id]][ $subjectName]["maxScoreUserId"] = $subjectStatistics[$subjectName]["maxScoreUserId"];
                $formattedAssessments[$userIds[$id]][ $subjectName]["minScoreUserId"] = $subjectStatistics[$subjectName]["minScoreUserId"];
                $formattedAssessments[$userIds[$id]][ $subjectName]["subjectPosition"] = $subjectStatistics[$userIds[$id]][$subjectName]["subjectPosition"];
            }
            // Add student result info such as psychomotor_handwriting etc
            $user_number = User::find($userIds[$id])->user_number;
            $studentResultInfo = Resultinfo::where("user_number", $user_number)
                ->where("term", $request["term"])
                ->where("result_scope", "student")
                ->where("session", $request["year"])->get();

            // Add school result info such as resumption date
            $schoolResultInfo = Resultinfo::where("user_number", $user_number)
                ->where("term", $request["term"])
                ->where("result_scope", "school")
                ->where("session", $request["year"])->get();    

            $formattedAssessments[$userIds[$id]][ "studentResultInfo" ] = $studentResultInfo ;
            $formattedAssessments[$userIds[$id]][ "schoolResultInfo" ] = $schoolResultInfo ;
            $formattedAssessments[$userIds[$id]][ "grandTotal" ] = $allUsersAllSubjectsGrandTotal[$userIds[$id]][ "grandTotal" ];
        
            $classroomId = User::where("id", $request['id'])->first()->currentClassroom()->first()->id;
            $classroomSubjects = Classroom::find($classroomId)->subjects;
            $formattedAssessments[$userIds[$id]][ "classroomSubjects" ] = $classroomSubjects;

        }

        return $formattedAssessments;
    }



    public function getSubjectStatistics($userIds, $allUsersAllSubjectsScores){
        $subjectStatistics = [];

        for($id=0; $id < count( $userIds) ; $id++){
            $userSubjects = array_keys($allUsersAllSubjectsScores[$userIds[$id]]);
            for($subject=0; $subject < count( $userSubjects) ; $subject++){
                $subjectName = $userSubjects[$subject];
                $subjectScore = $allUsersAllSubjectsScores[$userIds[$id]][$subjectName];

                // Initialize the statistic variable
                if(empty($subjectStatistics[$subjectName]["max"]))
                    $subjectStatistics[$subjectName]["max"] = -1000; // Seed lowest to find the max val
                if(empty($subjectStatistics[$subjectName]["min"]))
                    $subjectStatistics[$subjectName]["min"] = 1000; // Seed highest to find the min val
                

                $subjectScores = array_filter(array_column($allUsersAllSubjectsScores, $subjectName));
                $subjectStatistics[$userIds[$id]][$subjectName]["subjectPosition"] = $this->getSubjectPosition($subjectScores, $subjectScore);

                if(empty($subjectStatistics[$subjectName]["ave"])){
                    $subjectStatistics[$subjectName]["ave"] = array_sum($subjectScores)/count($subjectScores);
                }


                // User with max score
                if($subjectScore > $subjectStatistics[$subjectName]["max"] ){
                    $subjectStatistics[$subjectName]["max"] = $subjectScore;
                    $subjectStatistics[$subjectName]["maxScoreUserId"] = $userIds[$id];                
                } 
                
                if($subjectScore < $subjectStatistics[$subjectName]["min"] ){
                    $subjectStatistics[$subjectName]["min"] = $subjectScore; 
                    $subjectStatistics[$subjectName]["minScoreUserId"] = $userIds[$id];                
                }
                
            }
       }

       return $subjectStatistics;
    }



    public function getSubjectPosition($allSubjectScores, $subjectScore){
        rsort($allSubjectScores); // Sort in descending order
        $pos = array_search($subjectScore, $allSubjectScores) + 1;
        return $this->getOrdinalValue($pos);
    }


    public function getOrdinalValue($number){
        //$formatter = new NumberFormatter('en-US', NumberFormatter::ORDINAL);
        //return $formatter->format($num);
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
        
    }





    public function search($request, $query)
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }
        $this->authorize('isAdmin');

        $fields = Schema::getColumnListing('$assessments');
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
            $assessment = Assessment::create($request->all());    
            return $this->sendResponse( $assessment, 'Assessment Created Successfully');
        }


     }



    public function checkValidation(Request $request){
        $data = DB::select('DESCRIBE '.strtolower( 'Assessments' ));
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
        $assessment = Assessment::findOrFail($id);
        $input = $request->all();
        $assessment->fill($input)->save();
        return $this->sendResponse($assessment, 'Assessment Information has been updated');
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
            Assessment::whereIn('id', $idsArray)->delete();
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