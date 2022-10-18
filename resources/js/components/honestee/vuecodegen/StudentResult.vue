<template>
  <section class="content">
    <!-- PDF Generator begins -->
    <html-pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="true"
      :paginate-elements-by-height="14000" filename="assessment_lists" :pdf-quality="2" :manual-pagination="true"
      pdf-format="a4" pdf-orientation="landscape" pdf-content-width="100%" ref="html2Pdf">
      <section id="printPaper" slot="pdf-content"
        style=" width:100%; background-color: white;  padding: 0% 0.5% 40% 0.5%;">
        <div style="margin-left: 0; width: 100%; ">
          <h3 style="text-align:center; text-decoration: underline; padding: 1em; "> Assessment Lists</h3>
          <table class="table table-bordered" style="width: 100%; ">
            <thead>
              <tr>
                <th>School Section</th>
                <th>Classroom</th>
                <th>User</th>
                <th>Subject</th>
                <th>Assessment Name</th>
                <th>Year</th>
                <th>Term</th>
                <th>Assessment Sequence</th>
                <th>Score</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(assessment, key, index) in assessments">
                <td>
                  {{ (sections.find(a => a.id === assessment.section_id))? 
                    (sections.find(a => a.id === assessment.section_id).name) : "" 
                  }}
                </td>
                <td>
                  {{ (classrooms.find(a => a.id === assessment.classroom_id))? 
                    (classrooms.find(a => a.id === assessment.classroom_id).name) : "" 
                  }}
                </td>
                <td> 
                    {{ (users.find(a => a.id === assessment.user_id))? 
                      (
                        users.find(a => a.id === assessment.user_id).name + " (" +
                        users.find(a => a.id === assessment.user_id).user_number + ")"                    
                      ) : "" 
                    }}
                </td>
                <td>
                  {{ (subjects.find(a => a.id === assessment.subject_id))? 
                    (subjects.find(a => a.id === assessment.subject_id).name) : "" 
                  }}
                </td>

                <td>{{ assessment.name }} </td>
                <td>{{ assessment.year }} </td>
                <td>{{ assessment.term }} </td>
                <td>{{ assessment.type }} </td>
                <td>{{ assessment.score }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
    </html-pdf>
    <!-- PDF Generator Ends -->

    <!-- Container Begins -->
    <div class="container-fluid">
      <!-- Row begins-->
      <div class="row">
        <!-- Card Begins (Only Admin can see this content) -->
        <div class="card w-100" v-if="$gate.isAdmin()">
          <!-- card header -->
          <div class="card-header pr-sm-3">
            <div class="d-flex mb-3">
              <h3 class="card-title mr-auto "> Student Result Checking </h3>
              <!----<button type="button" class="btn btn-sm btn-primary " @click="newModal">
                <i class="fa fa-plus-square"></i>
                Add New
              </button>-->
            </div>
          </div> <!-- /.card header -->

          <!-- card-body table container -->
          <div class="card-body table-responsive p-1">



<nav class="navbar navbar-light bg-light">
      <form class="form-inline pt-3 pt-sm-0"  @submit.prevent="editResultMode ? editResult() : showResult()">
        <input  v-model="userNumber" type="text" class="form-control" required = "required" placeholder="User Number">
        
        <select v-model="resultYear" class="custom-select m-sm-2 my-2" required = "required" >
            <option selected>Select Session</option>
            <option value="2022/2023">2022/2023</option>
            <option value="2023/2024">2023/2024</option>
            <option value="2024/2025">2024/2025</option>
            <option value="2025/2026">2025/2026</option>
            <option value="2026/2027">2026/2027</option>
            <option value="2027/2028">2027/2028</option>
            <option value="2028/2029">2028/2029</option>
            <option value="2029/2030">2029/2030</option>
        </select>

        <select  v-model="resultTerm"  class="custom-select mr-sm-2" required = "required">
            <option selected>Select Term</option>
            <option value="First">First</option>
            <option value="Second">Second</option>
            <option value="Third">Third</option>
        </select>

        <button type="submit" class="btn btn-primary my-sm-2 my-3" @click="editResultMode = false">Check</button>
        <button type="submit" class="btn btn-primary my-sm-2 ml-2 my-3" v-if="!editResultMode"  @click="editResultMode = true"> Edit</button>
        <button type="submit" class="btn btn-primary my-sm-2 ml-2 my-3" v-if="editResultMode" @click="saveResult(); editResultMode = false"> Save </button>
        
    </form>
</nav>



<div class="container table-responsive py-5" style="background:gray; width:100% ">
  
  <div class="col" id = "result-sheet" style=" background:white; max-width: 900px; min-width:900px; min-height: 1000px; margin:auto; padding:1%;">
    <div class="row my-3" id = "result-sheet-border" style="width:96%; border: solid 3px;   margin:auto; padding:1%">

          <div class="row mb-2" style=" height:auto; width:96.7% ; margin:auto; padding:1%;">
            <div class="mx-1" style="width:20%; "><img style="width:100%; max-height:130px " src= "/images/batch.jpeg" /></div>
            <div class="mx-1" style="width:55%; text-align:center">
              <p> 
                <h2>Some School Name</h2>
                <span> Motto: Some school motto <br /></span> 
                <span> Address: Some school Address </span> 
                <span> Contact: 08123456789, Schoolname@email.com </span> 
              </p> 
              <h5>STUDENT REPORT SHEET</h5>

            </div>
            <div class="mx-1" style="width:20%; ">
              <!---<img style="width:100%; max-height:130px " src= "/images/passpor.jpg" /> -->
              <i style="font-size:8em; color:gray" class="fa fa-user"></i> 
            </div>
          </div>  

          <div class="row mb-2" style="border-top: solid 2px; border-bottom: solid 2px; height:auto; width:96.7% ; margin:auto; padding:1%;">
            <div class="mx-1" style="width:32.3%">
              <table border="2" style="width:100%">
                <tr style=""><th class="">Session:</th><td>2022/2023</td></tr>
                <tr style=""><th class="">Term:</th><td>First</td></tr>
                <tr style=""><th class="">Resumption Date:</th><td>2022/2023</td></tr>
              </table>
            </div>
            <div class="mx-1" style="width:32.3%">
              <table border="2" style="width:100%">
                <tr style=""><th class="">Classroom:</th><td> </td></tr>
                <tr style=""><th class="">No. of Students:</th><td>First</td></tr>
                <tr style=""><th class="">Class Teacher:</th><td></td></tr>
              </table>
            </div>
            <div class="mx-1" style="width:32.3%">
              <table border="2" style="width:100%">
                <tr style="text-align:center"><th class="">STUDENT FULL NAME</th></tr>
                <tr style="text-align:center"><th class="">REGISTRATION NUMBER</th></tr>
                <tr style="text-align:center"><th class="">POSITION</th></tr>
              </table>
            </div>
          </div>

          <div class="col-8">
            
              <table border="2" style="width:100%; border-collapse: collapse;">
                  <tr style="height:100px">
                    <td >SCHOOL SUBJECTS</td>
                    <th class="vert">CA</th>
                    <th class="vert">EXAMS</th>
                    <th class="vert">TOTAL</th>
                    <th class="vert">GRADE</th>

                    <th class="vert">POSITION</th>

                    <th class="vert">HIGHEST</th>
                    <th class="vert">LOWEST</th>
                    <th class="vert">AVERAGE</th>
                  </tr>
                <tbody>
                    <tr v-for="(assessment, key) in studentAssessments" :key="key"> 
                      <th  >{{ assessment.subject }}</th>
                      <td  >{{ assessment.ca }}</td>
                      <td  >{{ assessment.exams }}</td>
                      <td  >{{ assessment.total }}</td>
                      <td  >{{ assessment.grade }}</td>

                      <td  >{{ assessment.subjectPosition }}</td>

                      <td  >{{ assessment.max }}</td>
                      <td  >{{ assessment.min }}</td>
                      <td  >{{ assessment.ave }}</td>

                    </tr>
                
                </tbody>
              </table>
          </div>

          <div class="col-4">
            <table border="2" style="width:100%">
                <thead>
                  <tr>
                    <th colspan = "2" style = "text-align:center; font-size:12pt"> EFFECTIVE SKILLS </th>
                  </tr>
                </thead>
                <tbody>
                  <tr><th>PUNCTUALITY</th><td><select v-model="effective_punctuality" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_punctuality}}</span></td></tr>
                  <tr><th>POLITENESS</th><td><select v-model="effective_politeness" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_politeness}}</span></td></tr>
                  <tr><th>NEATNESS</th><td><select v-model="effective_neatness" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_neatness}}</span></td></tr>
                  <tr><th>HONESTY</th><td><select v-model="effective_honesty" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_honesty}}</span></td></tr>
                  <tr><th>LEADERSHIP SKILL</th><td><select v-model="effective_leadership_skill" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_leadership_skill}}</span></td></tr>
                  <tr><th>COOPERATION</th><td><select v-model="effective_cooperation" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_cooperation}}</span></td></tr>
                  <tr><th>ATTENTIVENESS</th><td><select v-model="effective_attentiveness" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_attentiveness}}</span></td></tr>
                  <tr><th>PERSEVERANCE</th><td><select v-model="effective_perseverance" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_perseverance}}</span></td></tr>
                  <tr><th>ATTITUDE TO WORK</th><td><select v-model="effective_attitude_to_work" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{effective_attitude_to_work}}</span></td></tr>
                </tbody>
              </table>

              <table border="2" style="width:100%; margin-top:1em">
                <thead>
                  <tr>
                    <th colspan = "2" style = "text-align:center; font-size:12pt"> PSYCHOMOTOR SKILLS </th>
                  </tr>
                </thead>
                <tbody>
                  <tr><th>HANDWRITING</th><td><select v-model="psychomotor_handwriting" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_handwriting}}</span></td></tr>
                  <tr><th>VERBAL FLUENCY</th><td><select v-model="psychomotor_verbal_fluency" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_verbal_fluency}}</span></td></tr>
                  <tr><th>SPORT</th><td><select v-model="psychomotor_sport" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_sport}}</span></td></tr>
                  <tr><th>HANDLING TOOLS</th><td><select v-model="psychomotor_handling_tools" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_handling_tools}}</span></td></tr>
                  <tr><th>DRAWING AND PAINTING</th><td><select v-model="psychomotor_drawing_and_painting" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_drawing_and_painting}}</span></td></tr>
                  <tr><th>COOPERATION</th><td><select v-model="psychomotor_cooperation" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_cooperation}}</span></td></tr>
                  <tr><th>ATTENTIVENESS</th><td><select v-model="psychomotor_attentiveness" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_attentiveness}}</span></td></tr>
                  <tr><th>PERSEVERANCE</th><td><select v-model="psychomotor_perseverance" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_perseverance}}</span></td></tr>
                  <tr><th>ATTITUDE TO WORK</th><td><select v-model="psychomotor_attitude_to_work" v-if="editResultMode"><option v-for="score in 5"> {{ score }}</option></select> <span v-if="!editResultMode">{{psychomotor_attitude_to_work}}</span></td></tr>
                </tbody>
              </table>


              <table border="2" style="width:100%; margin-top:1em">
                <thead>
                  <tr>
                    <th colspan = "2" style = "text-align:center; font-size:12pt">GRADING SYSTEM</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><th>A</th><td>75-100</td></tr>
                  <tr><th>B</th><td>70-74</td></tr>
                  <tr><th>C</th><td>50-59</td></tr>
                  <tr><th>D</th><td>45-49</td></tr>
                  <tr><th>E</th><td>40-44</td></tr>
                  <tr><th>F</th><td>0-39</td></tr>
                </tbody>
              </table>


          </div>

          <div class="row my-2" style="border-top: solid 2px; border-bottom: solid 2px; height:auto; width:96.7% ; margin:auto; padding:1%;">
            <div class="mx-1" style="width:100%">
              <table border="2" style="width:100%">
                <tr style=""> 
                  <th rowspan = "2" class="">SUMMARY</th> <th> TOTAL SCORE </th> <th> AVERAGE SCORE </th> <th> GRADE </th></tr>
                  <tr style=""> <td>10000</td>  <td>85.8</td> <td>A</td> </tr>
              </table>
            </div>

            <div class="mx-1" style="width:75%">
              <table border="2" style="width:100%; margin-top:0.5em">
                <tr style="text-align:center"><th class="">CLASS TEACHER COMMENT</th></tr>
                <tr ><td><textarea style="width:100%" v-model="form_master_comment" v-if="editResultMode"></textarea> <span v-if="!editResultMode">{{form_master_comment}}</span></td></tr>
              </table>
              <table border="2" style="width:100%; margin-top:0.5em">
                <tr style="text-align:center"><th class="">PRINCIPAL/HEADTEACHER COMMENT</th></tr>
                <tr style=""><td><textarea style="width:100%" v-model="principal_comment" v-if="editResultMode"></textarea> <span v-if="!editResultMode">{{principal_comment}}</span></td></tr>
              </table>
              
              <br /> <strong>A MESSAGE TO THE PARENTS:</strong>
              <p><textarea style="width:100%" v-model="message_to_parent" v-if="editResultMode"></textarea> <span v-if="!editResultMode">{{message_to_parent}}</span></p>
            </div>
            <div class="circle" style="width:23%; padding:0.3em; font-size:20pt; transform: rotate(-45deg); text-align:center; border: solid 1px; margin-top:3em;">
              SCHOOL STAMP
            </div>

          </div>




    </div>
  </div>

</div>















          </div> <!-- card-body table container ends -->

          <div class="card-footer">
            <!--<pagination :data="assessments" @pagination-change-page="getResults"></pagination>-->
          </div>
        </div> <!-- /.card ends-->
      </div> <!-- /.row ends-->
    </div> <!-- /.container ends-->

    <!-- Containt Not Found! -->
    <div v-if="!$gate.isAdmin()">
      <not-found></not-found>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Modal Header -->
            <h5 class="modal-title" v-show="!editmode">New Assessment</h5>
            <h5 class="modal-title" v-show="editmode">Update Assessment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!-- <form @submit.prevent="createModel"> -->
          <form @submit.prevent="editmode ? updateAssessment() : createAssessment()">
            <div class="modal-body">
              <div class="form-group">

                <input type="hidden" v-model="form.id"></input>

              </div>
              <div class="form-group">
                <label>Section</label>
                <select v-model="form.section_id" name="section_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'section_id' ) }">
                  <option v-for="(item, index)  in sections" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="section_id"></has-error>

              </div>
              <div class="form-group">
                <label>Classroom</label>
                <select v-model="form.classroom_id" name="classroom_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'classroom_id' ) }">
                  <option v-for="(item, index)  in classrooms" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="classroom_id"></has-error>

              </div>
              <div class="form-group">
                <label>User</label>
                <select v-model="form.user_id" name="user_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'user_id' ) }">
                  <option v-for="(item, index)  in users" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="user_id"></has-error>

              </div>
              <div class="form-group">
                <label>Subject</label>
                <select v-model="form.subject_id" name="subject_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'subject_id' ) }">
                  <option v-for="(item, index)  in subjects" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="subject_id"></has-error>

              </div>
              <div class="form-group">
                <label>Name</label>
                <select v-model="form.name" name="name" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'name' ) }">
                  <option> CA </option>
                  <option> Test </option>
                  <option> Exams </option>
                </select>
                <has-error :form="form" field="name"></has-error>

              </div>
              <div class="form-group">
                <label>Year</label>
                <select v-model="form.year" name="year" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'year' ) }">
                  <option> 2022 </option>
                  <option> 2023 </option>
                  <option> 2024 </option>
                  <option> 2025 </option>
                  <option> 2026 </option>
                  <option> 2027 </option>
                  <option> 2028 </option>
                  <option> 2029 </option>
                  <option> 2030 </option>
                </select>
                <has-error :form="form" field="year"></has-error>

              </div>
              <div class="form-group">
                <label>Term</label>
                <select v-model="form.term" name="term" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'term' ) }">
                  <option> First </option>
                  <option> Second </option>
                  <option> Third </option>
                </select>
                <has-error :form="form" field="term"></has-error>

              </div>
              <div class="form-group">
                <label>Type</label>
                <select v-model="form.type" name="type" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'type' ) }">
                  <option> First </option>
                  <option> Second </option>
                  <option> Third </option>
                </select>
                <has-error :form="form" field="type"></has-error>

              </div>
              <div class="form-group">
                <label>Score</label>
                <input type="number" v-model="form.score" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'score' ) }"></input>
                <has-error :form="form" field="score"></has-error>
              </div>
              <div class="form-group">

                <input type="hidden" v-model="form.created_at"></input>

              </div>
              <div class="form-group">

                <input type="hidden" v-model="form.updated_at"></input>

              </div>
            </div><!-- Modal body ends -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form> <!-- Form Ends -->
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="assessmentDetail" tabindex="-1" role="dialog" aria-labelledby="assessmentDetail"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Modal Header -->
            <h5 class="modal-title"> Assessment Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table">
              <tr class="row" v-for="(item, key, index) in clickedRow" v-if="!isSpecialColumn(key)">
                <th class="text-primary col-4" style="text-align: right; margin-left:0em"> {{ ucAllWords(key) }} </th>
                <td v-if="key === 'section_id'" class="col-8"> 
                  {{ (sections.find(a => a.id === item))? 
                    (sections.find(a => a.id === item).name) : "" 
                  }}
                </td>
                <td v-else-if="key === 'classroom_id'" class="col-8"> 
                  {{ (classrooms.find(a => a.id === item))? 
                    (classrooms.find(a => a.id === item).name) : "" 
                  }}
                </td>
                <td v-else-if="key === 'subject_id'" class="col-8"> 
                  {{ (subjects.find(a => a.id === item))? 
                    (subjects.find(a => a.id === item).name) : "" 
                  }}
                </td>                
                <td v-else-if="key === 'user_id'" class="col-8"> 
                  {{ (users.find(a => a.id === item))? 
                    (
                      users.find(a => a.id === item).name + " (" +
                      users.find(a => a.id === item).user_number + ")"                    
                    ) : "" 
                  }}
                </td>
                <td v-else class="col-8"> 
                  {{ item }} 
                </td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"
              @click="deleteAssessment(clickedRow.id)"><i class="fa fa-trash"></i> Delete </button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="editModal(clickedRow)"><i
                class="fa fa-edit"></i> Edit</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>
              Close</button>

          </div>
        </div>
      </div>
    </div>


  </section>
</template>


<script>
import JsonExcel from "vue-json-excel";
import VueHtml2pdf from "vue-html2pdf";

export default {
  data() {
    return {

      effective_punctuality: 0,
      effective_politeness: 0,
      effective_neatness: 0,
      effective_honesty: 0,
      effective_leadership_skill: 0,
      effective_cooperation: 0,
      effective_attentiveness: 0,
      effective_perseverance: 0,
      effective_attitude_to_work: 0,


      psychomotor_handwriting: 0,
      psychomotor_verbal_fluency: 0,
      psychomotor_sport: 0,
      psychomotor_handling_tools: 0,
      psychomotor_drawing_and_painting: 0,
      psychomotor_cooperation: 0,
      psychomotor_attentiveness: 0,
      psychomotor_perseverance: 0,
      psychomotor_attitude_to_work: 0,

      form_master_comment: "",
      principal_comment: "",
      message_to_parent: "",



      editmode: false,
      editResultMode: false,
      search: '',

      isLoading: false,
      totalRecords: 0,
      clickedRow: null,
      selectedRows: [],

      userNumber: '',
      resultTerm: '',
      resultYear: '',
      user: '',
      classrooms: [],
      users: [],
      studentAssessments: [],




      assessments: [],
      sections: [],
      classrooms: [],
      users: [],
      subjects: [],

      selectedSectionId: 0,
      selectedClassroomId: 0,
      selectedUserId: 0,
      selectedSubjectId: 0,

      serverParams: {
        columnFilters: {
        },
        sort: [
          {
            "type": "asc",
            "field": "section_id"
          },
          {
            "type": "asc",
            "field": "classroom_id"
          },
          {
            "type": "asc",
            "field": "user_id"
          },
          {
            "type": "asc",
            "field": "subject_id"
          },
          {
            "type": "asc",
            "field": "name"
          },
          {
            "type": "asc",
            "field": "year"
          },
          {
            "type": "asc",
            "field": "term"
          },
          {
            "type": "asc",
            "field": "type"
          },
          {
            "type": "asc",
            "field": "score"
          },
        ],
        page: 1,
        perPage: 5,
        searchTerm: '',
      },

      form: new Form({
        "id": "",
        "section_id": "",
        "classroom_id": "",
        "user_id": "",
        "subject_id": "",
        "name": "",
        "year": "",
        "term": "",
        "type": "",
        "score": "",
        "created_at": "",
        "updated_at": "",
      }),

      table_heders: {
        "Section": "section_id",
        "Classroom": "classroom_id",
        "User": "user_id",
        "Subject": "subject_id",
        "Assessment Name": "name",
        "Year": "year",
        "Term": "term",
        "Sequence": "type",
        "Score": "score",
      },

      columns: [
        {
          label: "Id",
          field: "id",
          hidden: true
        },
        {
          label: "School Section",
          field: "section_id",
          hidden: false
        },
        {
          label: "Classroom",
          field: "classroom_id",
          hidden: false
        },
        {
          label: "User",
          field: "user_id",
          hidden: false
        },
        {
          label: "Subject",
          field: "subject_id",
          hidden: false
        },
        {
          label: "Assessment Name",
          field: "name",
          hidden: false
        },
        {
          label: "Year",
          field: "year",
          hidden: false
        },
        {
          label: "Term",
          field: "term",
          hidden: false
        },
        {
          label: "Assessment Sequence",
          field: "type",
          hidden: false
        },
        {
          label: "Score",
          field: "score",
          hidden: false
        },
        {
          label: "Created At",
          field: "created_at",
          hidden: true
        },
        {
          label: "Updated At",
          field: "updated_at",
          hidden: true
        },

        {
          label: 'Actions',
          field: 'action',
          sortable: false,

        },

      ],

    };
  },


  components: {
    "json-excel": JsonExcel,
    "html-pdf": VueHtml2pdf,
  },


  methods: {

    assessmentDetail(params) {
      this.clickedRow = params.row;
      $('#assessmentDetail').modal('show');
    },

    updateAssessment() {
      this.$Progress.start();
      // console.log('Editing data');
      this.form.put('api/assessments/' + this.form.id)
        .then((response) => {
          // success
          $('#addNew').modal('hide');
          Toast.fire({
            icon: 'success',
            title: response.data.message
          });
          this.$Progress.finish();
          //  Fire.$emit('AfterCreate');
          this.loadAssessments();
        })
        .catch(() => {
          Toast.fire({
            icon: 'error',
            title: 'Some error occured!'
          });
          this.$Progress.fail();
        });
    },

    editModal(assessment) {
      this.editmode = true;
      this.form.reset();
      $('#addNew').modal('show');
      this.form.fill(assessment);
    },

    newModal() {
      this.editmode = false;
      this.form.reset();
      $('#addNew').modal('show');
    },

    deleteAssessment(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          const theData = [id];
          this.form.delete('api/assessments/' + JSON.stringify(theData)).then(() => {
            Swal.fire(
              'Deleted!',
              'The assessment was deleted successfully.',
              'success'
            );
            // Fire.$emit('AfterCreate');
            this.loadAssessments();
          }).catch((data) => {
            Swal.fire("Failed!", data.message, "warning");
          });
        }
      })
    },

    deleteSelectedAssessments() {
      Swal.fire({
        title: 'Are you sure?',
        text: "Delete " + this.selectedRows.length + " records? You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        // Send request to the server
        if (result.value) {
          let theData = JSON.stringify(this.selectedRows);
          this.form.delete('api/assessments/' + theData).then(() => {
            Swal.fire(
              'Deleted!',
              'The assessment was deleted successfully.',
              'success'
            );
            // Fire.$emit('AfterCreate');
            this.loadAssessments();
          }).catch((data) => {
            Swal.fire("Failed!", data.message, "warning");
          });
        }
      })
    },


    createAssessment() {
      this.form.post('api/assessments')
        .then((response) => {
          $('#addNew').modal('hide');
          Toast.fire({
            icon: 'success',
            title: response.data.message
          });
          this.$Progress.finish();
          this.loadAssessments();
        })
        .catch(() => {
          Toast.fire({
            icon: 'error',
            title: 'Some error occured!'
          });
        })
    },


    generatePDF() {
      this.$Progress.start();
      this.$refs.html2Pdf.generatePdf();
      this.$Progress.finish();
    },

    print() {
      this.$Progress.start();
      this.$htmlToPaper('printPaper');
      this.$Progress.finish();
    },


    updateParams(newProps) {
      this.serverParams = Object.assign({}, this.serverParams, newProps);
    },


    onSelectionChanged(params) {
      this.selectedRows = [];
      for (var i = 0; i < params.selectedRows.length; i++) {
        if (params.selectedRows[i].vgtSelected)
          this.selectedRows[i] = params.selectedRows[i].id;
      }
    },


    onPageChange(params) {
      this.updateParams({ page: params.currentPage });
      this.loadAssessments();
    },

    onPerPageChange(params) {
      this.updateParams({ perPage: params.currentPerPage });
      this.loadAssessments();
    },

    onSortChange(params) {
      var sortType = params[0].type;
      if (sortType != 'asc' && sortType != 'desc')
        sortType = 'asc';
      this.updateParams({
        sort: [{
          type: sortType,
          field: params[0].field,
        }],
      });
      this.loadAssessments();
    },


    onColumnFilter(params) {
      this.updateParams(params);
      this.loadAssessments();
    },


    onSearch(params) {
      this.updateParams({ searchTerm: params.searchTerm });
      this.loadAssessments();
    },


    toggleColumn(index, event) {
      // Set hidden to inverse of what it currently is
      this.$set(this.columns[index], 'hidden', !this.columns[index].hidden);
    },


    // load items is what brings back the rows from server
    loadAssessments() {
      this.$Progress.start();
      var parameters = "?perPage=" + this.serverParams.perPage;
      parameters = parameters + "&page=" + this.serverParams.page;
      parameters = parameters + "&sortField=" + this.serverParams.sort[0].field;
      parameters = parameters + "&sortType=" + this.serverParams.sort[0].type;
      parameters = parameters + "&searchTerm=" + this.serverParams.searchTerm;
      var url = "api/assessments" + parameters;
      //console.log(JSON.stringify( url));
      try {
        this.form.get(url).then(assessments => {
          if (assessments.data.data) {
            this.totalRecords = assessments.data.data.total
            this.assessments = assessments.data.data.data;
          }
        });
      } catch (error) {
        console.log(error.message);
      };
      this.$Progress.finish();
    },


    ucAllWords(words) {
      var separateWord = words.toLowerCase().split('_');
      for (var i = 0; i < separateWord.length; i++) {
        separateWord[i] = separateWord[i].charAt(0).toUpperCase() +
          separateWord[i].substring(1);
      }
      var res = separateWord.join(' ');
      return res.replace(" Id", "");
    },


    isSpecialColumn(field) {
      if (field != 'id' && field != 'updated_at' && field != 'created_at'
        && field != 'vgt_id' && field != 'vgtSelected' && field != 'originalIndex')
        return false;
      else
        return true;
    },


    loadSections() {


      try {
        var url = "api/sections?all=all";
        axios.get(url).then(sections => {
          if (sections.data.data) {
            this.sections = sections.data.data;
          }
        });
      } catch (error) {
        console.log(error.message);
      };

    },
    loadClassrooms() {


      try {
        var url = "api/classrooms?all=all";
        axios.get(url).then(classrooms => {
          if (classrooms.data.data) {
            this.classrooms = classrooms.data.data;
          }
        });
      } catch (error) {
        console.log(error.message);
      };

    },
    loadUsers() {


      try {
        var url = "api/users?id=all";
        axios.get(url).then(users => {
          if (users.data.data) {
            this.users = users.data.data;
          }
        });
      } catch (error) {
        console.log(error.message);
      };

    },
    loadSubjects() {


      try {
        var url = "api/subjects?all=all";
        axios.get(url).then(subjects => {
          if (subjects.data.data) {
            this.subjects = subjects.data.data;
          }
        });
      } catch (error) {
        console.log(error.message);
      };

    },

    editResult(){
        alert("edit mod")
    },

    saveResult(){
        alert("saeved")
    },

    showResult(){
        //console.log( this.userNumber+" "+ this.resultTerm+" "+this.resultYear );

        try {
          var url = "api/users?userNumber="+this.userNumber;
          axios.get(url).then(user => {
            if (user.data.data) {
              //console.log(user.data.data);
              this.user = user.data.data;


              url = "api/users?q=classroom&id="+this.user.id;
                axios.get(url).then(classrooms => {
                  if (classrooms.data.data) {
                    //console.log(classrooms.data.data.reverse());
                    this.classrooms = classrooms.data.data.reverse();
                  }
              });

              url = "api/classrooms?q=users&id="+this.classrooms[0].id;
                axios.get(url).then(users => {
                  if (users.data.data) {
                    //console.log(users.data.data.reverse());
                    this.users = users.data.data;
                  }
              });


              url = "api/assessments?id="+this.user.id+"&term="+ this.resultTerm+"&year="+ this.resultYear;
              axios.get(url).then(assessments => {
                if (assessments.data.data) {
                  console.log(assessments.data.data);
                  this.studentAssessments = assessments.data.data;

                  /*var formattedAssessments = {};
                  const subject_ids  =  Object.keys( assessments.data.data );
                  subject_ids.forEach(function (subject_id, index) {
                       var ass = assessments.data.data[subject_id];
                       for (var i = 0; i < ass.length; i++){
                        //formattedAssessments.subject_id = assessments.data.data[subject_id][ass[i]];
                        //var subject = (this.subjects.find(a => a.id === item))? (this.subjects.find(a => a.id === item).name) : "";
                        formattedAssessments[subject_id] = ass[i].subject_id;
                        if(ass[i].name == "CA" && ass[i].type == "First")
                            formattedAssessments["First CA"] = ass[i].score;
                        else if(ass[i].name == "CA" && ass[i].type == "Second")
                            formattedAssessments["Second CA"] = ass[i].score;
                        else if(ass[i].name == "CA" && ass[i].type == "Third")
                            formattedAssessments["Third CA"] = ass[i].score;
                        else if(ass[i].name == "Test" && ass[i].type == "First")
                            formattedAssessments["First Test"] = ass[i].score;
                        else if(ass[i].name == "Test" && ass[i].type == "Second")
                            formattedAssessments["Second Test"] = ass[i].score;
                        else if(ass[i].name == "Test" && ass[i].type == "Third")
                            formattedAssessments["Third Test"] = ass[i].score;
                        else if(ass[i].name == "Exams")
                            formattedAssessments["Exams"] = ass[i].score;                            


                        //console.log( JSON.stringify( ass[i].subject_id ) );

                       }
                    
                  });*/
                  
                  //console.log( JSON.stringify( formattedAssessments ) );
                  //console.log( JSON.stringify( this.subjects ) );

                  /*try {

                    var formattedAssessments = {};
                    const subject_ids  =  Object.keys( assessments.data.data );
                    subject_ids.forEach(function (subject_id, index) {
                      const ass =  Object.keys( assessments.data.data[subject_id]);
                      console.log( JSON.stringify( ass ) );

                      //formattedAssessments = Object.values( assessments.data.data[subject_id])

                     

                    } );



                  } catch(error){
                    console.log(error.message);
                  }*/
                  


                  //for(var i= 0; i<ass.length; i++ )
                      //console.log( JSON.stringify( ass[i]) )+" xxxxxx ";

                  
                  
                  //this.studentAssessments = assessments.data.data;






                }
              });












            }
          });


        } catch (error) {
          console.log(error.message);
        };




    }




  },


  mounted() {
    //console.log('Assessment Component mounted.')
    this.$Progress.start();
    this.loadAssessments();
    this.loadSections();
    this.loadClassrooms();
    this.loadUsers();
    this.loadSubjects();
    this.$Progress.finish();
  },


  created() {
    this.$Progress.start();
    this.loadAssessments();
    this.$Progress.finish();
  },


  computed: {},


}


</script>

<style>
@media screen and (min-width: 990px) {
  #printPaper {
    margin-left: -22.2%;
    padding: 0% 1% 3% 1%;
    width: 100%;
  }
}



th.vert{
  transform: rotate(180deg);
  white-space: nowrap;
  writing-mode: vertical-rl;
  line-height: 1;
  position: relative;
  padding: 0.7em;
}


.circle {
    background-color:#fff;
    border:1px solid red;    
    height:100px;
    border-radius:50%;
    -moz-border-radius:50%;
    -webkit-border-radius:50%;
    width:100px;
}

th, td {
  padding-left: 1em
}





</style>



