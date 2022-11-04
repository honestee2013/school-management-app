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
                <th>Student</th>
                <th>Subject</th>
                <th>Assessment Name</th>
                <th>Session</th>
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
              <h3 class="card-title mr-auto ">Assessment List </h3>
              <button type="button" class="btn btn-sm btn-primary " @click="newModal">
                <i class="fa fa-plus-square"></i>
                Add New
              </button>
            </div>
          </div> <!-- /.card header -->

          <!-- card-body table container -->
          <div class="card-body table-responsive p-2">
            <!-- VUE GOOD TABLE BEGINS -->
            <vue-good-table mode="remote" @on-page-change="onPageChange" @on-sort-change="onSortChange"
              @on-column-filter="onColumnFilter" @on-per-page-change="onPerPageChange" @on-search="onSearch"
              @on-selected-rows-change="onSelectionChanged" styleClass="vgt-table  bordered table-hover "
              :totalRows="totalRecords" :isLoading.sync="isLoading" :select-options="{
                enabled: true,
              }" :pagination-options="{
                        enabled: true,
                        perPageDropdown: [5, 10, 20, 50, 75, 100],
                        dropdownAllowAll: false,
                      }" :search-options="{
                        enabled: true,
                        placeholder: 'Search the table',
                      }" :rows="assessments" :columns="columns">
              <!-- Vue Good TABLE CONTENTS and ACTIONS slot -->
              <div slot="table-actions">
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

                <!-- Button Groups for SHOWING/HIDING Columns -->
                <div class="mr-auto btn-group my-1" role="group" aria-label="Button group with nested dropdown">
                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-default btn-sm " data-toggle="dropdown"
                      aria-expanded="false">
                      <i class="fa fa-eye"></i> Show
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <li v-for="(column, index) in columns" :key="index">
                        <a href="#" class="dropdown-item" tabIndex="-1"
                          @click.prevent="toggleColumn( index, $event )"><input :checked="!column.hidden"
                            type="checkbox" />&nbsp;&nbsp;{{column.label}}</a>
                      </li>
                    </div>
                  </div>
                </div>
              </div><!-- Vue Good Table Action slot and contents ends -->

              <div slot="emptystate">
                No {{$data['singular_lower']}} records found
              </div>

              <!-- Vue Good TABLE ACTION COLUMN options -->
              <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'action'">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary"
                      @click="assessmentDetail(props)">Detail</button>
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split"
                      data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>

                    <div class="dropdown-menu">
                      <!--<a class="dropdown-item" href="#" @click="assessmentDetail('show')"><i class="fa fa-eye"> <span style="margin-left:0.1em"> Details </span> </i></a>
                                  <div class="dropdown-divider"></div>-->
                      <a class="dropdown-item" href="#" @click="editModal(props.row)"><i class="fa fa-edit"> <span
                            style="margin-left:0.1em"> Edit </span> </i></a>
                      <a class="dropdown-item " href="#" @click="deleteAssessment(props.row.id)"><i class="fa fa-trash">
                          <span style="margin-left:0.1em"> Delete </span> </i></a>
                    </div>
                  </div>
                </span>
                <span v-else-if="props.column.field == 'section_id'">
                  {{ (sections.find(a => a.id === props.formattedRow[props.column.field]))? 
                    (sections.find(a => a.id === props.formattedRow[props.column.field]).name) : "" 
                  }}
                </span>
                <span v-else-if="props.column.field == 'classroom_id'">
                  {{ (classrooms.find(a => a.id === props.formattedRow[props.column.field]))? 
                    (classrooms.find(a => a.id === props.formattedRow[props.column.field]).name) : "" 
                  }}
                </span>
                <span v-else-if="props.column.field == 'subject_id'">
                  {{ (subjects.find(a => a.id === props.formattedRow[props.column.field]))? 
                    (subjects.find(a => a.id === props.formattedRow[props.column.field]).name) : "" 
                  }}
                </span>
                <span v-else-if="props.column.field == 'user_id'">
                  {{ (users.find(a => a.id === props.formattedRow[props.column.field]))? 
                    (
                      users.find(a => a.id === props.formattedRow[props.column.field]).name + " (" +
                      users.find(a => a.id === props.formattedRow[props.column.field]).user_number + ")"                    
                    ) : "" 
                  }}
                </span>                                
                <span v-else>
                  {{props.formattedRow[props.column.field]}}
                </span>
              </template> <!-- Vue Good TABLE ACTION Column ends -->

              <!-- Vue Good TABLE SELECTED ROW Actions -->
              <div slot="selected-row-actions">
                <div class="dropdown">
                  <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-expanded="false">
                    Selected Assessments
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item " href="#" @click="deleteSelectedAssessments()"><i class="fa fa-trash">
                        <span style="margin-left:0.1em"> Delete </span> </i></a>
                  </div>
                </div>
              </div>
            </vue-good-table>
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
                <label>School Section</label>
                <select v-model="form.section_id" name="section_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'section_id' ) }" @change="loadNextField($event, 'classrooms')" >
                  <option v-for="(item, index)  in sections" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="section_id"></has-error>

              </div>
              <div class="form-group" v-show="classrooms.length">
                <label>Classroom</label>
                <select v-model="form.classroom_id" name="classroom_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'classroom_id' ) }" @change="loadNextField($event, 'users')">
                  <option v-for="(item, index)  in classrooms" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="classroom_id"></has-error>

              </div>
              <div class="form-group" v-show="users.length">
                <label>Student</label>
                <select v-model="form.user_id" name="user_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'user_id' ) }" @change="loadNextField($event, 'subjects')">
                  <option v-for="(item, index)  in users" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="user_id"></has-error>

              </div>
              <div class="form-group" v-show="subjects.length">
                <label>Subject</label>
                <select v-model="form.subject_id" name="subject_id" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'subject_id' ) }">
                  <option v-for="(item, index)  in subjects" :key="index" :value="item.id"> {{item.name}} </option>
                </select>
                <has-error :form="form" field="subject_id"></has-error>

              </div>
              <div class="form-group" v-show="subjects.length">
                <label>Name</label>
                <select v-model="form.name" name="name" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'name' ) }">
                  <option> Assignment </option>
                  <option> Test </option>
                  <option> Exams </option>
                </select>
                <has-error :form="form" field="name"></has-error>

              </div>
              <div class="form-group" v-show="subjects.length">
                <label>Session</label>
                <select v-model="form.year" name="year" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'year' ) }">
                  <option>2022/2023</option>
                  <option>2024/2025</option>
                  <option>2026/2027</option>
                  <option>2028/2029</option>
                  <option>2030/2030</option>
                </select>
                <has-error :form="form" field="year"></has-error>

              </div>
              <div class="form-group" v-show="subjects.length">
                <label>Term</label>
                <select v-model="form.term" name="term" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'term' ) }">
                  <option> First </option>
                  <option> Second </option>
                  <option> Third </option>
                </select>
                <has-error :form="form" field="term"></has-error>

              </div>
              <div class="form-group" v-show="subjects.length">
                <label>Type</label>
                <select v-model="form.type" name="type" class="form-control"
                  :class="{ 'is-invalid': form.errors.has( 'type' ) }">
                  <option> First </option>
                  <option> Second </option>
                  <option> Third </option>
                </select>
                <has-error :form="form" field="type"></has-error>

              </div>
              <div class="form-group" v-show="subjects.length">
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
        "Student": "user_id",
        "Subject": "subject_id",
        "Assessment Name": "name",
        "Session": "year",
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
          label: "Student",
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
          label: "Session",
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


    loadNextField(event, theField){
        //console.log(event.target.value)
        var url = "api/";

        if(theField == "classrooms")
          url = url + "classrooms?sectionId=" + event.target.value;
        else if(theField == "users")
          url = url + "users?classroomId=" + event.target.value;
        else if(theField == "subjects")
          url = url + "subjects?userId=" + event.target.value;
        

        try {
          axios.get(url).then(response => {
            if (response.data.data) {
              if(theField == "classrooms")
                this.classrooms = response.data.data.data;
              else if(theField == "users")
                this.users = response.data.data.data;
              else if(theField == "subjects")
                this.subjects = response.data.data.data;

                //alert(JSON.stringify( this.classrooms) );
            }
          });
        } catch (error) {
          console.log(error.message);
        };

    },

    




  },


  mounted() {
    this.loadAssessments();
    this.loadSections();

    //console.log('Assessment Component mounted.')
    /*this.$Progress.start();
    //this.loadAssessments();
    this.loadSections();
    this.loadClassrooms();
    this.loadUsers();
    this.loadSubjects();
    this.$Progress.finish();*/

  },


  /*created() {
    this.$Progress.start();
    this.$Progress.start();
    this.loadAssessments();
    this.loadSections();
    this.loadClassrooms();
    this.loadUsers();
    this.loadSubjects();;
    this.$Progress.finish();

  },*/


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
</style>



