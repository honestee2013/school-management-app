<template>
  <section class="content">
    <!-- PDF Generator begins -->
    <html-pdf :show-layout="false" :float-layout="true" :enable-download="true" :preview-modal="true"
      :paginate-elements-by-height="14000" filename="user_lists" :pdf-quality="2" :manual-pagination="true"
      pdf-format="a4" pdf-orientation="landscape" pdf-content-width="100%" ref="html2Pdf">
      <section id="printPaper" slot="pdf-content"
        style=" width:100%; background-color: white;  padding: 0% 0.5% 40% 0.5%;">
        <div style="margin-left: 0; width: 100%; ">
          <h3 style="text-align:center; text-decoration: underline; padding: 1em; "> user Lists</h3>
          <table class="table table-bordered" style="width: 100%; ">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Number</th>
                <th>Parent Number</th>
                <th>Password</th>
                <th>Email Verified At</th>
                <th>Remember Token</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) in users" :key="user.id">
                <td>{{ user.name }} </td>
                <td>{{ user.email }} </td>
                <td>{{ user.user_number }} </td>
                <td>{{ user.parent_number }} </td>
                <td>{{ user.password }} </td>
                <td>{{ user.email_verified_at }} </td>
                <td>{{ user.remember_token }} </td>
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
              <h3 class="card-title mr-auto ">
                Classroom users
              </h3>

              <button type="button" class="btn btn-sm btn-primary " @click="newModal" v-show="queryId">
                <i class="fa fa-plus-square"></i>
                Add New
              </button>
            </div>
          </div> <!-- /.card header -->

          <!-- More options -->
          <nav class="navbar  navbar-light bg-light">
            <span class="navbar-brand">
              <router-link to="/classrooms">
                <a type="button" class="btn btn-primary btn-sm" role="button" aria-pressed="true">
                  <i class="nav-icon fas fa-chalkboard-teacher"></i>
                  Classrooms
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

          <!-- card-body table container -->
          <div class="card-body table-responsive p-2">
            <div class="form-row mb-2">
              <div v-show="queryId" class="bg-light py-2 col-12 text-bold mb-2 pl-3" style="margin-top:-0.2em">
                Users for <h5> {{selectedName}} </h5>
              </div>

              <div class="col">
                <select class="custom-select" v-model="queryId" @change="onQueryIdChanged($event, 'classroom' )">
                  <option v-show="(queryId==0)" selected value="0">Select classroom</option>
                  <option v-if="classrooms" v-for="row in classrooms" :value="row.id+'_'+row.name"
                    :selected="row.id == queryId">{{ row.name }}</option>
                </select>
              </div>

            </div>
            <!-- VUE GOOD TABLE BEGINS -->
            <vue-good-table v-show="queryId" mode="remote" @on-page-change="onPageChange" @on-sort-change="onSortChange"
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
                      }" :rows="classroomUsers" :columns="columns">
              <!-- Vue Good TABLE CONTENTS and ACTIONS slot -->
              <div slot="table-actions">
                <!-- Button Groups for EXPORTING TABLE - ->  
                              <div class="mr-auto btn-group my-1" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                  <button id="btnGroupDrop1" type="button" class="btn btn-default btn-sm " data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-download"></i> Export
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <button href="#" class="dropdown-item" @click.prevent="print">
                                        <i class="fa fa-print mr-1"></i> Print
                                    </button>  
                                      <button href="#" class="dropdown-item">
                                        <!-- JSON_EXCEL Component - ->  
                                        <json-excel class="" :data="users" :fields="table_heders" worksheet="user List" name="user_lists.xls">
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
                No user records found
              </div>

              <!-- Vue Good TABLE ACTION COLUMN options -->
              <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'action'">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-primary" @click="userDetail(props)">Detail</button>
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split"
                      data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>

                    <div class="dropdown-menu">
                      <!--<a class="dropdown-item" href="#" @click="userDetail('show')"><i class="fa fa-eye"> <span style="margin-left:0.1em"> Details </span> </i></a>
                                  <div class="dropdown-divider"></div>-->
                      <!--<a class="dropdown-item" href="#" @click="editModal(props.row)"><i class="fa fa-edit">  <span style="margin-left:0.1em"> Edit </span>  </i></a>-->
                      <a class="dropdown-item " href="#" @click="deleteClassroomUsers(props.row.id)"><i
                          class="fa fa-trash"> <span style="margin-left:0.1em"> Remove </span> </i></a>
                    </div>
                  </div>
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
                    Selected users
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item " href="#" @click="deleteSelectedUsers()"><i class="fa fa-trash"> <span
                          style="margin-left:0.1em"> Remove </span> </i></a>
                  </div>
                </div>
              </div>
            </vue-good-table>

          </div> <!-- card-body table container ends -->

          <div class="card-footer">
            <!--<pagination :data="users" @pagination-change-page="getResults"></pagination>-->
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
            <h5 class="modal-title" v-show="!editmode">Add users</h5>
            <h5 class="modal-title" v-show="editmode">Update users</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!-- <form @submit.prevent="createModel"> -->
          <form @submit.prevent="editmode ? updateClassroomUsers() : createClassroomUsers()">
            <div class="modal-body">

              <div class="card border-light w-100">
                <div class="card-header">
                  Select users for <h5> {{selectedName}} </h5>
                </div>
                <ul class="list-group list-group-flush">

                  <li class="list-group-item bg-light">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="select_all"
                        v-on:change="onSelectAll()">
                      <label class="form-check-label" for="select_all"> All users </label>
                    </div>
                  </li>



                  <li v-for="row in users" class="list-group-item">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" :value="row.id" :id="row.id"
                        v-model="checkedUsers">
                      <label class="form-check-label" :for="row.id"> {{row.name}}</label>
                    </div>
                  </li>
                </ul>
              </div>

            </div><!-- Modal body ends -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary"> OK </button>
            </div>
          </form> <!-- Form Ends -->
        </div>
      </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="userDetail" tabindex="-1" role="dialog" aria-labelledby="userDetail" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- Modal Header -->
            <h5 class="modal-title"> User Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table">
              <tr class="row" v-for="(item, key, index) in clickedRow" v-if="!isSpecialColumn(key)">
                <th class="text-primary col-4" style="text-align: right; margin-left:0em"> {{ ucAllWords(key) }} </th>
                <td class="col-8"> {{ item }} </td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"
              @click="deleteClassroomUsers(clickedRow.id)"><i class="fa fa-trash"></i> Remove </button>
            <!--<button type="button" class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="editModal(clickedRow)"><i class="fa fa-edit"></i> Edit</button>-->
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
      classroomUsers: [],
      users: [],
      classrooms: [],
      checkedUsers: [],
      search: '',
      selectAll: false,

      isLoading: false,
      totalRecords: 0,
      clickedRow: null,
      selectedRows: [],
      selectedRows: [],
      queryId: 0,
      selectedName: "",
      queryTable: "",

      serverParams: {
        columnFilters: {
        },
        sort: [
          {
            "type": "asc",
            "field": "name"
          },
          {
            "type": "asc",
            "field": "email"
          },
          {
            "type": "asc",
            "field": "user_number"
          },
          {
            "type": "asc",
            "field": "parent_number"
          },
          {
            "type": "asc",
            "field": "password"
          },
          {
            "type": "asc",
            "field": "email_verified_at"
          },
          {
            "type": "asc",
            "field": "remember_token"
          },
        ],
        page: 1,
        perPage: 5,
        searchTerm: '',
      },

      form: new Form({
        "id": "",
        "name": "",
        "email": "",
        "user_number": "",
        "parent_number": "",
        "password": "",
        "email_verified_at": "",
        "remember_token": "",
        "created_at": "",
        "updated_at": "",
      }),

      table_heders: {
        "Name": "name",
        "Email": "email",
        "User Number": "user_number",
        "Parent Number": "parent_number",
        "Password": "password",
        "Email Verified At": "email_verified_at",
        "Remember Token": "remember_token",
      },

      columns: [
        {
          label: "Id",
          field: "id",
          hidden: true
        },
        {
          label: "Name",
          field: "name",
          hidden: false
        },
        {
          label: "Email",
          field: "email",
          hidden: false
        },
        {
          label: "User Number",
          field: "user_number",
          hidden: false
        },
        {
          label: "Parent Number",
          field: "parent_number",
          hidden: false
        },
        {
          label: "Password",
          field: "password",
          hidden: false
        },
        {
          label: "Email Verified At",
          field: "email_verified_at",
          hidden: false
        },
        {
          label: "Remember Token",
          field: "remember_token",
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

    userDetail(params) {
      this.clickedRow = params.row;
      $('#userDetail').modal('show');
    },

    updateClassroomUsers() {
      this.$Progress.start();
      // console.log('Editing data');
      this.form.put("api/user-classrooms/" + this.form.id)
        .then((response) => {
          // success
          $('#addNew').modal('hide');
          Toast.fire({
            icon: 'success',
            title: response.data.message
          });
          this.$Progress.finish();
          //  Fire.$emit('AfterCreate');
          this.loadClassroomUsers();
        })
        .catch(() => {
          Toast.fire({
            icon: 'error',
            title: 'Some error occured!'
          });
          this.$Progress.fail();
        });
    },

    editModal(user) {
      this.loadUsers();
      this.editmode = true;
      this.form.reset();
      $('#addNew').modal('show');
      this.form.fill(user);
    },

    newModal() {
      this.loadUsers();
      this.editmode = false;
      this.form.reset();
      $('#addNew').modal('show');
    },

    deleteClassroomUsers(id) {
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

          var parameters = new Object();
          parameters["tbl"] = "user";
          parameters["pv_tbl"] = this.queryTable;
          parameters["pv_id"] = this.queryId;
          parameters["pv_ids"] = id;//this.checkedUsers;

          //const theData = [id];
          axios.delete('api/user-classrooms/' + JSON.stringify(parameters)).then(() => {
            Swal.fire(
              'Deleted!',
              'The user was deleted successfully.',
              'success'
            );
            // Fire.$emit('AfterCreate');
            this.loadClassroomUsers();
          }).catch((data) => {
            Swal.fire("Failed!", data.message, "warning");
          });
        }
      })
    },

    deleteSelectedUsers() {
      Swal.fire({
        title: 'Are you sure?',
        text: "Remove " + this.selectedRows.length + " records? You won't be able to revert this!",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        // Send request to the server
        if (result.value) {

          var parameters = new Object();
          parameters["tbl"] = "user";
          parameters["pv_tbl"] = this.queryTable;
          parameters["pv_id"] = this.queryId;
          parameters["pv_ids"] = this.selectedRows;//this.checkedUsers;



          let theData = JSON.stringify(parameters);
          axios.delete("api/user-classrooms/" + theData).then(() => {
            Swal.fire(
              'Deleted!',
              'The user was deleted successfully.',
              'success'
            );
            // Fire.$emit('AfterCreate');
            this.loadClassroomUsers();
          }).catch((data) => {
            Swal.fire("Failed!", data.message, "warning");
          });
        }
      })
    },


    createClassroomUsers() {
      var parameters = "?tbl=user";
      parameters = parameters + "&pv_tbl=" + this.queryTable;
      parameters = parameters + "&pv_id=" + this.queryId;
      parameters = parameters + "&pv_ids=" + this.checkedUsers;
      var url = "api/user-classrooms" + parameters;

      axios.post(url)
        .then((response) => {
          $('#addNew').modal('hide');
          Toast.fire({
            icon: 'success',
            title: response.data.message
          });
          this.$Progress.finish();
          this.loadClassroomUsers();
        })
        .catch(() => {
          Toast.fire({
            icon: 'error',
            title: 'Some error occured!'
          });
        })
    },


    onQueryIdChanged(event, table) {
      var selected = event.target.value;
      this.queryId = selected.substring(0, selected.indexOf("_"));
      this.selectedName = selected.substring(selected.indexOf("_") + 1);
      this.queryTable = table;
      this.$Progress.start();
      this.loadClassroomUsers();
      this.$Progress.finish();
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
      this.loadClassroomUsers();
    },

    onPerPageChange(params) {
      this.updateParams({ perPage: params.currentPerPage });
      this.loadClassroomUsers();
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
      this.loadClassroomUsers();
    },


    onColumnFilter(params) {
      this.updateParams(params);
      this.loadClassroomUsers();
    },


    onSearch(params) {
      this.updateParams({ searchTerm: params.searchTerm });
      this.loadClassroomUsers();
    },


    onSelectAll() {
      this.selectAll = !this.selectAll;
      if (this.selectAll) {
        var ids = this.users
          .map(function (data) { return data.id; });
        this.checkedUsers = ids;
      } else {
        this.checkedUsers = [];
      }
      console.log(JSON.stringify(ids));
      //checkedUsers;
    },


    toggleColumn(index, event) {
      // Set hidden to inverse of what it currently is
      this.$set(this.columns[index], 'hidden', !this.columns[index].hidden);
    },


    // load items is what brings back the rows from server
    loadClassroomUsers() {
      if (!this.queryId)
        return;

      this.$Progress.start();
      var parameters = "?perPage=" + this.serverParams.perPage;
      parameters = parameters + "&page=" + this.serverParams.page;
      parameters = parameters + "&sortField=" + this.serverParams.sort[0].field;
      parameters = parameters + "&sortType=" + this.serverParams.sort[0].type;
      parameters = parameters + "&searchTerm=" + this.serverParams.searchTerm;
      parameters = parameters + "&tbl=user";
      parameters = parameters + "&pv_tbl=" + this.queryTable;
      parameters = parameters + "&pv_id=" + this.queryId;
      var url = "api/user-classrooms" + parameters;
      //console.log(JSON.stringify( url));
      try {
        this.form.get(url).then(users => {
          if (users.data.data) {
            this.totalRecords = users.data.data.total
            this.classroomUsers = users.data.data.data;
            this.checkedUsers
              = this.classroomUsers
                .map(function (data) { return data.id; });

          }
        });
      } catch (error) {
        console.log(error.message);
      };
      this.$Progress.finish();
    },



    // load pivot_tables data
    loadClassrooms() {
      var url = "api/classrooms";
      this.form.get(url).then(classrooms => {
        if (classrooms.data.data.data) {
          this.classrooms = classrooms.data.data.data
        }
      });
    },


    // load the table data
    loadUsers() {
      var url = "api/users";
      this.form.get(url).then(users => {
        if (users.data.data.data) {
          this.users = users.data.data.data
        }
      });
    },


    ucAllWords(words) {
      var separateWord = words.toLowerCase().split('_');
      for (var i = 0; i < separateWord.length; i++) {
        separateWord[i] = separateWord[i].charAt(0).toUpperCase() +
          separateWord[i].substring(1);
      }
      return separateWord.join(' ');
    },


    isSpecialColumn(field) {
      if (field != 'id' && field != 'updated_at' && field != 'created_at' && field != 'pivot'
        && field != 'vgt_id' && field != 'vgtSelected' && field != 'originalIndex')
        return false;
      else
        return true;
    }

  },


  mounted() {
    //console.log('classroom Component mounted.')
    //const urlParams = new URLSearchParams(window.location.search.substring(1));
    //this.queryId = urlParams.get('queryId');
    //console.log('xxxxxxxxxxx '+ urlParams.get('queryId') );
    //this.queryId = this.$route.params.queryId;

    //console.log('user Component mounted.')
    this.$Progress.start();
    this.loadClassrooms();
    this.$Progress.finish();
  },
  


  created() {
    this.$Progress.start();
    //this.loadClassroomUsers();
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
</style>



