<template>
  <section class="content">


    <!-- PDF Generator begins -->
    <html-pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="true"
      :paginate-elements-by-height="14000" filename="assessment_lists" :pdf-quality="2" :manual-pagination="true"
      pdf-format="a4" pdf-orientation="landscape" pdf-content-width="100%" ref="html2Pdf">
      <section id="printPaper" slot="pdf-content"
        style=" width:100%; background-color: white;  padding: 0% 0.5% 40% 0.5%;">
      
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
    <h3 class="card-title mr-auto "> Student Result </h3>
    <button type="button" class="btn btn-sm btn-primary " @click="newModal">
      <i class="fa fa-plus-square"></i>
      Add New
    </button>
  </div>
</div> <!-- /.card header -->

<!-- More options -->
<nav class="navbar  navbar-light bg-light">
  <span class="navbar-brand">
    <router-link to="/assessments">
      <a type="button" class="btn btn-primary btn-sm" role="button" aria-pressed="true">
        <i class="fas fa-award" />
        Assessments
      </a>
    </router-link>
  </span>
  <span>
    <a href="/under-construction" type="button" class="btn btn-outline-primary btn-sm" role="button"
      aria-pressed="true">
      <i class="fas fa-user-cog" />
      Permissions
    </a>
    <a href="/under-construction" type="button" class="btn btn-outline-primary btn-sm" role="button"
      aria-pressed="true">
      <i class="fa fa-cog" />
      Settings
    </a>
  </span>
</nav>
<!--/ More options -->

<!-- Result check form -->
  <div class="input-group pt-2 pb-0" >
    <div class="col-12 col-md-3 my-1">
      <input type="text" class="form-control" placeholder="Student Number" aria-label="Student Number" >
    </div>

    <div class="col-12 col-md-3 my-1">
      <select class="custom-select" >
        <option selected>Select Term</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>  

    <div class="col-12 col-md-3 my-1">
      <select class="custom-select" >
        <option selected>Select Year</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>
    <div class="col-12 col-md-3  mt-1">
      <button class="btn btn-outline-secondary">Check result</button>
    </div> 

  </div>
<!--/ Result check form ends -->

<!-- Button Groups for EXPORTING TABLE -->
<div class="mr-auto btn-group my-1" role="group" aria-label="Button group with nested dropdown">
  <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-default btn-sm " data-toggle="dropdown"
      aria-expanded="false">
      <i class="fa fa-download"></i> Export
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <button href="#" class="dropdown-item" @click.prevent="print">
        <i class="fa fa-print mr-1"></i> Print
      </button>
      <button href="#" class="dropdown-item">
        <!-- JSON_EXCEL Component -->
        <json-excel class="" :data="assessments" :fields="table_heders" worksheet="Assessment Lits"
          name="assessment_lists.xls">
          <i class="fa fa-file-excel mr-1"></i> Excel
        </json-excel>
      </button>
      <button href="#" class="dropdown-item" @click.prevent="generatePDF">
        <i class="fa fa-file-pdf mr-1"></i> PDF
      </button>
    </div>
  </div>
</div>












          <!-- card-body table container -->
          <div class="card-body table-responsive p-2">
            <div id="printPaper" class = "ml-5" style = "width: 90%; height: 750px; border: solid gray 1px; ">
              <p id = "waterMark">
                  
              </p>









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
      editmode: false,
      assessments: [],
      search: '',

      isLoading: false,
      totalRecords: 0,
      clickedRow: null,
      selectedRows: [],

      sections: [],
      classrooms: [],
      users: [],
      subjects: [],

      

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
        var url = "api/users?all=all";
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


    setWatermark(){
      var schlName = "School Name";
      var wmark = "";
      for(var i= 0; i<10; i++){
        wmark = wmark + " " +schlName;
      }
        
       document.getElementById("waterMark").innerHTML = wmark;
    }




  },


  mounted() {
    this.$nextTick(function () {
      var schlName = "School Name";
      var wmark = "";
        //wmark = (wmark + " " +schlName).repeat(10);
       document.getElementById("waterMark").innerHTML = wmark;
    })

   
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
  #waterMark {
    margin-left: -22.2%;
    padding: 0% 1% 3% 1%;
    width: 100%;
  }
}






#waterMark {
  height: 450px;
  width: 600px;
  position: relative;
  overflow: hidden;
}
#waterMark img {
  max-width: 100%;
}
#waterMark p {

  
  position: absolute;
  top: 0;
  left: 0;
  color: rgb(20, 18, 18);
  opacity: 0.2;
  font-size: 0.9em;
  pointer-events: none;
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
}

@page {
  size: A4;
  margin: 0;
}
@media print {
  #printPaper {
    width: 210mm;
    height: 297mm;
  }
  /* ... the rest of the rules ... */
}




</style>



