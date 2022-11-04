<template>
  <section class="content">
        <!-- PDF Generator begins -->
        <html-pdf
            :show-layout="false"
            :float-layout="true"
            :enable-download="true"
            :preview-modal="true"
            :paginate-elements-by-height="14000"
            filename="resultinfo_lists"
            :pdf-quality="2"
            :manual-pagination="true"
            pdf-format="a4"
            pdf-orientation="landscape"
            pdf-content-width="100%"
            ref="html2Pdf"
          >
              <section  id = "printPaper" slot="pdf-content" style=" width:100%; background-color: white;  padding: 0% 0.5% 40% 0.5%;">
                <div style = "margin-left: 0; width: 100%; ">
                  <h3 style="text-align:center; text-decoration: underline; padding: 1em; "> Resultinfo Lists</h3>
                  <table class="table table-bordered" style="width: 100%; ">
                        <thead>
                            <tr>
                                                                                                                                                              <th>Result Scope</th>
                                                                                                                                <th>User Number</th>
                                                                                                                                <th>Session</th>
                                                                                                                                <th>Term</th>
                                                                                                                                <th>Hold Result</th>
                                                                                                                                <th>Reason For Holding Result</th>
                                                                                                                                <th>Section Id</th>
                                                                                                                                <th>Owner</th>
                                                                                                                                <th>Debt</th>
                                                                                                                                <th>Next Term School Fees</th>
                                                                                                                                <th>Form Master Comment</th>
                                                                                                                                <th>Principal Comment</th>
                                                                                                                                <th>Message To Parent</th>
                                                                                                                                <th>Message To Student</th>
                                                                                                                                <th>Message To Staff</th>
                                                                                                                                <th>Effective Punctuality</th>
                                                                                                                                <th>Effective Politeness</th>
                                                                                                                                <th>Effective Neatness</th>
                                                                                                                                <th>Effective Honesty</th>
                                                                                                                                <th>Effective Leadership Skill</th>
                                                                                                                                <th>Effective Cooperation</th>
                                                                                                                                <th>Effective Attentiveness</th>
                                                                                                                                <th>Effective Perseverance</th>
                                                                                                                                <th>Effective Attitude To Work</th>
                                                                                                                                <th>Psychomotor Handwriting</th>
                                                                                                                                <th>Psychomotor Verbal Fluency</th>
                                                                                                                                <th>Psychomotor Sport</th>
                                                                                                                                <th>Psychomotor Handling Tools</th>
                                                                                                                                <th>Psychomotor Drawing And Painting</th>
                                                                                                                                <th>Psychomotor Cooperation</th>
                                                                                                                                <th>Psychomotor Attentiveness</th>
                                                                                                                                <th>Psychomotor Perseverance</th>
                                                                                                                                <th>Psychomotor Attitude To Work</th>
                                                                                                                                <th>Next Term Begins On</th>
                                                                                                                                                                                                                      </tr>   
                        </thead>
                        <tbody >
                            <tr v-for="(resultinfo, index) in resultinfos" :key="resultinfo.id">
                                                                                                                                                                              <td>{{ resultinfo.result_scope }} </td>
                                                                                                                                              <td>{{ resultinfo.user_number }} </td>
                                                                                                                                              <td>{{ resultinfo.session }} </td>
                                                                                                                                              <td>{{ resultinfo.term }} </td>
                                                                                                                                              <td>{{ resultinfo.hold_result }} </td>
                                                                                                                                              <td>{{ resultinfo.reason_for_holding_result }} </td>
                                                                                                                                              <td>{{ resultinfo.section_id }} </td>
                                                                                                                                              <td>{{ resultinfo.owner }} </td>
                                                                                                                                              <td>{{ resultinfo.debt }} </td>
                                                                                                                                              <td>{{ resultinfo.next_term_school_fees }} </td>
                                                                                                                                              <td>{{ resultinfo.form_master_comment }} </td>
                                                                                                                                              <td>{{ resultinfo.principal_comment }} </td>
                                                                                                                                              <td>{{ resultinfo.message_to_parent }} </td>
                                                                                                                                              <td>{{ resultinfo.message_to_student }} </td>
                                                                                                                                              <td>{{ resultinfo.message_to_staff }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_punctuality }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_politeness }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_neatness }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_honesty }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_leadership_skill }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_cooperation }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_attentiveness }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_perseverance }} </td>
                                                                                                                                              <td>{{ resultinfo.effective_attitude_to_work }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_handwriting }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_verbal_fluency }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_sport }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_handling_tools }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_drawing_and_painting }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_cooperation }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_attentiveness }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_perseverance }} </td>
                                                                                                                                              <td>{{ resultinfo.psychomotor_attitude_to_work }} </td>
                                                                                                                                              <td>{{ resultinfo.next_term_begins_on }} </td>
                                                                                                                                                                                                                                        </tr>
                        </tbody>
                  </table>
                </div>
              </section>
        </html-pdf>
        <!-- PDF Generator Ends -->

        <!-- Container Begins -->
        <div class="container-fluid" >
          <!-- Row begins-->
          <div class="row">
            <!-- Card Begins (Only Admin can see this content) -->
              <div class="card w-100" v-if="$gate.isAdmin()" > 
                <!-- card header -->
                <div class="card-header pr-sm-3">
                  <div class="d-flex mb-3">
                    <h3 class="card-title mr-auto ">Resultinfo List </h3>
                    <button type="button" class="btn btn-sm btn-primary " @click="newModal">
                        <i class="fa fa-plus-square"></i>
                        Add New
                    </button>
                  </div>
                </div> <!-- /.card header -->

                <!-- card-body table container -->
                <div class="card-body table-responsive p-2"> 
                    <!-- VUE GOOD TABLE BEGINS -->  
                    <vue-good-table
                      mode="remote"
                      @on-page-change="onPageChange"
                      @on-sort-change="onSortChange"
                      @on-column-filter="onColumnFilter"
                      @on-per-page-change="onPerPageChange"
                      @on-search="onSearch"
                      @on-selected-rows-change="onSelectionChanged"

                      styleClass="vgt-table  bordered table-hover "
                      :totalRows="totalRecords"
                      :isLoading.sync="isLoading"
                      :select-options="{
                        enabled: true,
                      }"
                      :pagination-options="{
                        enabled: true,
                        perPageDropdown: [5, 10, 20, 50, 75, 100],
                        dropdownAllowAll: false,
                      }"
                      :search-options="{
                        enabled: true,
                        placeholder: 'Search the table',
                      }"
                      :rows="resultinfos"
                      :columns="columns">
                          <!-- Vue Good TABLE CONTENTS and ACTIONS slot -->  
                          <div slot="table-actions">
                              <!-- Button Groups for EXPORTING TABLE -->  
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
                                        <!-- JSON_EXCEL Component -->  
                                        <json-excel class="" :data="resultinfos" :fields="table_heders" worksheet="Resultinfo Lits" name="resultinfo_lists.xls">
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
                                  <button id="btnGroupDrop1" type="button" class="btn btn-default btn-sm " data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-eye"></i> Show
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li v-for="(column, index) in columns" :key="index">
                                      <a href="#" class="dropdown-item" tabIndex="-1" @click.prevent="toggleColumn( index, $event )"><input :checked="!column.hidden" type="checkbox"/>&nbsp;&nbsp;{{column.label}}</a>
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
                                <button type="button" class="btn btn-sm btn-primary"  @click="resultinfoDetail(props)">Detail</button>
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>

                                <div class="dropdown-menu">
                                  <!--<a class="dropdown-item" href="#" @click="resultinfoDetail('show')"><i class="fa fa-eye"> <span style="margin-left:0.1em"> Details </span> </i></a>
                                  <div class="dropdown-divider"></div>-->
                                  <a class="dropdown-item" href="#" @click="editModal(props.row)"><i class="fa fa-edit">  <span style="margin-left:0.1em"> Edit </span>  </i></a>
                                  <a class="dropdown-item " href="#" @click="deleteResultinfo(props.row.id)"><i class="fa fa-trash">  <span style="margin-left:0.1em"> Delete </span>  </i></a>
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
                                  <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    Selected Resultinfos
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item " href="#" @click="deleteSelectedResultinfos()"><i class="fa fa-trash">  <span style="margin-left:0.1em"> Delete </span>  </i></a>
                                  </div>
                                </div>
                          </div>
                    </vue-good-table>
                </div> <!-- card-body table container ends -->

                <div class="card-footer">
                    <!--<pagination :data="resultinfos" @pagination-change-page="getResults"></pagination>-->
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
                  <div class="modal-header"> <!-- Modal Header -->
                      <h5 class="modal-title" v-show="!editmode">New Resultinfo</h5>
                      <h5 class="modal-title" v-show="editmode">Update Resultinfo</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>

                  <!-- <form @submit.prevent="createModel"> -->
                  <form @submit.prevent="editmode ? updateResultinfo() : createResultinfo()">
                    <div class="modal-body">
                                                    <div class="form-group">
                                 
                                  <input type="hidden" v-model="form.id"></input>
                              
                                                          </div>
                                                      <div class="form-group">
                                                                <label>Result scope</label>
                                  <input type="text" v-model="form.result_scope" name="result_scope" class="form-control" :class="{ 'is-invalid': form.errors.has( 'result_scope' ) }"  maxlength="125" >
                                                                        <has-error :form="form" field="result_scope"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>User number</label>
                                  <input type="text" v-model="form.user_number" name="user_number" class="form-control" :class="{ 'is-invalid': form.errors.has( 'user_number' ) }"  maxlength="125" >
                                                                        <has-error :form="form" field="user_number"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Session</label>
                                  <input type="text" v-model="form.session" name="session" class="form-control" :class="{ 'is-invalid': form.errors.has( 'session' ) }"  maxlength="125" >
                                                                        <has-error :form="form" field="session"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Term</label>
                                  <input type="text" v-model="form.term" name="term" class="form-control" :class="{ 'is-invalid': form.errors.has( 'term' ) }"  maxlength="125" >
                                                                        <has-error :form="form" field="term"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Hold result</label>
                                  <input type="number" v-model="form.hold_result" class="form-control" :class="{ 'is-invalid': form.errors.has( 'hold_result' ) }"></input>
                                                                        <has-error :form="form" field="hold_result"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Reason for holding result</label>
                                  <input type="text" v-model="form.reason_for_holding_result" name="reason_for_holding_result" class="form-control" :class="{ 'is-invalid': form.errors.has( 'reason_for_holding_result' ) }"  maxlength="125" >
                                                                        <has-error :form="form" field="reason_for_holding_result"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Section</label>
                                  <select v-model="form.section_id" name="section_id" class="form-control" 
                                          :class="{ 'is-invalid': form.errors.has( 'section_id' ) }">
                                      <option v-for="(item, index)  in sections"
                                            :key= "index" :value="item.id"> {{item.name}} </option>
                                  </select>
                                                                        <has-error :form="form" field="section_id"></has-error>
                                  
                                                          </div>
                                                      <div class="form-group">
                                                                <label>Owner</label>
                                  <input type="number" v-model="form.owner" class="form-control" :class="{ 'is-invalid': form.errors.has( 'owner' ) }"></input>
                                                                        <has-error :form="form" field="owner"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Debt</label>
                                  <input type="number" v-model="form.debt" class="form-control" :class="{ 'is-invalid': form.errors.has( 'debt' ) }"></input>
                                                                        <has-error :form="form" field="debt"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Next term school fees</label>
                                  <input type="number" v-model="form.next_term_school_fees" class="form-control" :class="{ 'is-invalid': form.errors.has( 'next_term_school_fees' ) }"></input>
                                                                        <has-error :form="form" field="next_term_school_fees"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Form master comment</label>
                                  <textarea v-model="form.form_master_comment"  :class="{ 'is-invalid': form.errors.has( 'form_master_comment' ) }" class="form-control" style="min-height: 100px; max-height: 300px;"></textarea>
                                                                        <has-error :form="form" field="form_master_comment"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Principal comment</label>
                                  <textarea v-model="form.principal_comment"  :class="{ 'is-invalid': form.errors.has( 'principal_comment' ) }" class="form-control" style="min-height: 100px; max-height: 300px;"></textarea>
                                                                        <has-error :form="form" field="principal_comment"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Message to parent</label>
                                  <textarea v-model="form.message_to_parent"  :class="{ 'is-invalid': form.errors.has( 'message_to_parent' ) }" class="form-control" style="min-height: 100px; max-height: 300px;"></textarea>
                                                                        <has-error :form="form" field="message_to_parent"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Message to student</label>
                                  <textarea v-model="form.message_to_student"  :class="{ 'is-invalid': form.errors.has( 'message_to_student' ) }" class="form-control" style="min-height: 100px; max-height: 300px;"></textarea>
                                                                        <has-error :form="form" field="message_to_student"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Message to staff</label>
                                  <textarea v-model="form.message_to_staff"  :class="{ 'is-invalid': form.errors.has( 'message_to_staff' ) }" class="form-control" style="min-height: 100px; max-height: 300px;"></textarea>
                                                                        <has-error :form="form" field="message_to_staff"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective punctuality</label>
                                  <input type="number" v-model="form.effective_punctuality" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_punctuality' ) }"></input>
                                                                        <has-error :form="form" field="effective_punctuality"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective politeness</label>
                                  <input type="number" v-model="form.effective_politeness" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_politeness' ) }"></input>
                                                                        <has-error :form="form" field="effective_politeness"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective neatness</label>
                                  <input type="number" v-model="form.effective_neatness" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_neatness' ) }"></input>
                                                                        <has-error :form="form" field="effective_neatness"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective honesty</label>
                                  <input type="number" v-model="form.effective_honesty" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_honesty' ) }"></input>
                                                                        <has-error :form="form" field="effective_honesty"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective leadership skill</label>
                                  <input type="number" v-model="form.effective_leadership_skill" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_leadership_skill' ) }"></input>
                                                                        <has-error :form="form" field="effective_leadership_skill"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective cooperation</label>
                                  <input type="number" v-model="form.effective_cooperation" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_cooperation' ) }"></input>
                                                                        <has-error :form="form" field="effective_cooperation"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective attentiveness</label>
                                  <input type="number" v-model="form.effective_attentiveness" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_attentiveness' ) }"></input>
                                                                        <has-error :form="form" field="effective_attentiveness"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective perseverance</label>
                                  <input type="number" v-model="form.effective_perseverance" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_perseverance' ) }"></input>
                                                                        <has-error :form="form" field="effective_perseverance"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Effective attitude to work</label>
                                  <input type="number" v-model="form.effective_attitude_to_work" class="form-control" :class="{ 'is-invalid': form.errors.has( 'effective_attitude_to_work' ) }"></input>
                                                                        <has-error :form="form" field="effective_attitude_to_work"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor handwriting</label>
                                  <input type="number" v-model="form.psychomotor_handwriting" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_handwriting' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_handwriting"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor verbal fluency</label>
                                  <input type="number" v-model="form.psychomotor_verbal_fluency" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_verbal_fluency' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_verbal_fluency"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor sport</label>
                                  <input type="number" v-model="form.psychomotor_sport" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_sport' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_sport"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor handling tools</label>
                                  <input type="number" v-model="form.psychomotor_handling_tools" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_handling_tools' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_handling_tools"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor drawing and painting</label>
                                  <input type="number" v-model="form.psychomotor_drawing_and_painting" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_drawing_and_painting' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_drawing_and_painting"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor cooperation</label>
                                  <input type="number" v-model="form.psychomotor_cooperation" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_cooperation' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_cooperation"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor attentiveness</label>
                                  <input type="number" v-model="form.psychomotor_attentiveness" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_attentiveness' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_attentiveness"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor perseverance</label>
                                  <input type="number" v-model="form.psychomotor_perseverance" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_perseverance' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_perseverance"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Psychomotor attitude to work</label>
                                  <input type="number" v-model="form.psychomotor_attitude_to_work" class="form-control" :class="{ 'is-invalid': form.errors.has( 'psychomotor_attitude_to_work' ) }"></input>
                                                                        <has-error :form="form" field="psychomotor_attitude_to_work"></has-error>
                                                                                            </div>
                                                      <div class="form-group">
                                                                <label>Next term begins on</label>
                                  <input type="text" v-model="form.next_term_begins_on" name="next_term_begins_on" class="form-control" :class="{ 'is-invalid': form.errors.has( 'next_term_begins_on' ) }"  maxlength="125" >
                                                                        <has-error :form="form" field="next_term_begins_on"></has-error>
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
        <div class="modal fade" id="resultinfoDetail" tabindex="-1" role="dialog" aria-labelledby="resultinfoDetail" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header"> <!-- Modal Header -->
                        <h5 class="modal-title" > Resultinfo Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <div class="modal-body">
                        <table class="table">
                          <tr class="row" v-for="(item, key, index) in clickedRow" v-if="!isSpecialColumn(key)">
                                <th class="text-primary col-4" style="text-align: right; margin-left:0em"> {{ ucAllWords(key) }} </th><td class="col-8"> {{ item }} </td>
                          </tr>
                        </table>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" 
                        data-dismiss="modal" 
                        @click="deleteResultinfo(clickedRow.id)"><i class="fa fa-trash"></i> Delete </button>
                        <button type="button" class="btn btn-primary" 
                        data-dismiss="modal" 
                        @click="editModal(clickedRow)"><i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-primary" 
                        data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                                          
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
        data () {
            return {
                editmode: false,
                resultinfos : [],
                search : '',

                isLoading: false,
                totalRecords: 0,
                clickedRow: null,
                selectedRows: [],


                                                                                                                                                                                                                                                                                                                        sections: [],          
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                serverParams: {
                  columnFilters: {
                  },
                  sort: [
                                                                                                                      {"type" : "asc",
                          "field" : "result_scope"},
                                                                                                {"type" : "asc",
                          "field" : "user_number"},
                                                                                                {"type" : "asc",
                          "field" : "session"},
                                                                                                {"type" : "asc",
                          "field" : "term"},
                                                                                                {"type" : "asc",
                          "field" : "hold_result"},
                                                                                                {"type" : "asc",
                          "field" : "reason_for_holding_result"},
                                                                                                {"type" : "asc",
                          "field" : "section_id"},
                                                                                                {"type" : "asc",
                          "field" : "owner"},
                                                                                                {"type" : "asc",
                          "field" : "debt"},
                                                                                                {"type" : "asc",
                          "field" : "next_term_school_fees"},
                                                                                                {"type" : "asc",
                          "field" : "form_master_comment"},
                                                                                                {"type" : "asc",
                          "field" : "principal_comment"},
                                                                                                {"type" : "asc",
                          "field" : "message_to_parent"},
                                                                                                {"type" : "asc",
                          "field" : "message_to_student"},
                                                                                                {"type" : "asc",
                          "field" : "message_to_staff"},
                                                                                                {"type" : "asc",
                          "field" : "effective_punctuality"},
                                                                                                {"type" : "asc",
                          "field" : "effective_politeness"},
                                                                                                {"type" : "asc",
                          "field" : "effective_neatness"},
                                                                                                {"type" : "asc",
                          "field" : "effective_honesty"},
                                                                                                {"type" : "asc",
                          "field" : "effective_leadership_skill"},
                                                                                                {"type" : "asc",
                          "field" : "effective_cooperation"},
                                                                                                {"type" : "asc",
                          "field" : "effective_attentiveness"},
                                                                                                {"type" : "asc",
                          "field" : "effective_perseverance"},
                                                                                                {"type" : "asc",
                          "field" : "effective_attitude_to_work"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_handwriting"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_verbal_fluency"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_sport"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_handling_tools"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_drawing_and_painting"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_cooperation"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_attentiveness"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_perseverance"},
                                                                                                {"type" : "asc",
                          "field" : "psychomotor_attitude_to_work"},
                                                                                                {"type" : "asc",
                          "field" : "next_term_begins_on"},
                                                                                                                                                            ],
                  page: 1, 
                  perPage: 5,
                  searchTerm: '',
                },   
                     
                form: new Form({
                                        "id" : "",
                                        "result_scope" : "",
                                        "user_number" : "",
                                        "session" : "",
                                        "term" : "",
                                        "hold_result" : "",
                                        "reason_for_holding_result" : "",
                                        "section_id" : "",
                                        "owner" : "",
                                        "debt" : "",
                                        "next_term_school_fees" : "",
                                        "form_master_comment" : "",
                                        "principal_comment" : "",
                                        "message_to_parent" : "",
                                        "message_to_student" : "",
                                        "message_to_staff" : "",
                                        "effective_punctuality" : "",
                                        "effective_politeness" : "",
                                        "effective_neatness" : "",
                                        "effective_honesty" : "",
                                        "effective_leadership_skill" : "",
                                        "effective_cooperation" : "",
                                        "effective_attentiveness" : "",
                                        "effective_perseverance" : "",
                                        "effective_attitude_to_work" : "",
                                        "psychomotor_handwriting" : "",
                                        "psychomotor_verbal_fluency" : "",
                                        "psychomotor_sport" : "",
                                        "psychomotor_handling_tools" : "",
                                        "psychomotor_drawing_and_painting" : "",
                                        "psychomotor_cooperation" : "",
                                        "psychomotor_attentiveness" : "",
                                        "psychomotor_perseverance" : "",
                                        "psychomotor_attitude_to_work" : "",
                                        "next_term_begins_on" : "",
                                        "created_at" : "",
                                        "updated_at" : "",
                                  }),
                
                table_heders: {
                                                                                                  "Result Scope" : "result_scope",
                                                                                "User Number" : "user_number",
                                                                                "Session" : "session",
                                                                                "Term" : "term",
                                                                                "Hold Result" : "hold_result",
                                                                                "Reason For Holding Result" : "reason_for_holding_result",
                                                                                "Section Id" : "section_id",
                                                                                "Owner" : "owner",
                                                                                "Debt" : "debt",
                                                                                "Next Term School Fees" : "next_term_school_fees",
                                                                                "Form Master Comment" : "form_master_comment",
                                                                                "Principal Comment" : "principal_comment",
                                                                                "Message To Parent" : "message_to_parent",
                                                                                "Message To Student" : "message_to_student",
                                                                                "Message To Staff" : "message_to_staff",
                                                                                "Effective Punctuality" : "effective_punctuality",
                                                                                "Effective Politeness" : "effective_politeness",
                                                                                "Effective Neatness" : "effective_neatness",
                                                                                "Effective Honesty" : "effective_honesty",
                                                                                "Effective Leadership Skill" : "effective_leadership_skill",
                                                                                "Effective Cooperation" : "effective_cooperation",
                                                                                "Effective Attentiveness" : "effective_attentiveness",
                                                                                "Effective Perseverance" : "effective_perseverance",
                                                                                "Effective Attitude To Work" : "effective_attitude_to_work",
                                                                                "Psychomotor Handwriting" : "psychomotor_handwriting",
                                                                                "Psychomotor Verbal Fluency" : "psychomotor_verbal_fluency",
                                                                                "Psychomotor Sport" : "psychomotor_sport",
                                                                                "Psychomotor Handling Tools" : "psychomotor_handling_tools",
                                                                                "Psychomotor Drawing And Painting" : "psychomotor_drawing_and_painting",
                                                                                "Psychomotor Cooperation" : "psychomotor_cooperation",
                                                                                "Psychomotor Attentiveness" : "psychomotor_attentiveness",
                                                                                "Psychomotor Perseverance" : "psychomotor_perseverance",
                                                                                "Psychomotor Attitude To Work" : "psychomotor_attitude_to_work",
                                                                                "Next Term Begins On" : "next_term_begins_on",
                                                                                                                                  },

                columns: [ 
                                        { label : "Id",
                      field : "id",
                                              hidden : true},
                                                              { label : "Result Scope",
                      field : "result_scope",
                                              hidden : false},
                                                              { label : "User Number",
                      field : "user_number",
                                              hidden : false},
                                                              { label : "Session",
                      field : "session",
                                              hidden : false},
                                                              { label : "Term",
                      field : "term",
                                              hidden : false},
                                                              { label : "Hold Result",
                      field : "hold_result",
                                              hidden : false},
                                                              { label : "Reason For Holding Result",
                      field : "reason_for_holding_result",
                                              hidden : false},
                                                              { label : "Section Id",
                      field : "section_id",
                                              hidden : false},
                                                              { label : "Owner",
                      field : "owner",
                                              hidden : false},
                                                              { label : "Debt",
                      field : "debt",
                                              hidden : false},
                                                              { label : "Next Term School Fees",
                      field : "next_term_school_fees",
                                              hidden : false},
                                                              { label : "Form Master Comment",
                      field : "form_master_comment",
                                              hidden : false},
                                                              { label : "Principal Comment",
                      field : "principal_comment",
                                              hidden : false},
                                                              { label : "Message To Parent",
                      field : "message_to_parent",
                                              hidden : false},
                                                              { label : "Message To Student",
                      field : "message_to_student",
                                              hidden : false},
                                                              { label : "Message To Staff",
                      field : "message_to_staff",
                                              hidden : false},
                                                              { label : "Effective Punctuality",
                      field : "effective_punctuality",
                                              hidden : false},
                                                              { label : "Effective Politeness",
                      field : "effective_politeness",
                                              hidden : false},
                                                              { label : "Effective Neatness",
                      field : "effective_neatness",
                                              hidden : false},
                                                              { label : "Effective Honesty",
                      field : "effective_honesty",
                                              hidden : false},
                                                              { label : "Effective Leadership Skill",
                      field : "effective_leadership_skill",
                                              hidden : false},
                                                              { label : "Effective Cooperation",
                      field : "effective_cooperation",
                                              hidden : false},
                                                              { label : "Effective Attentiveness",
                      field : "effective_attentiveness",
                                              hidden : false},
                                                              { label : "Effective Perseverance",
                      field : "effective_perseverance",
                                              hidden : false},
                                                              { label : "Effective Attitude To Work",
                      field : "effective_attitude_to_work",
                                              hidden : false},
                                                              { label : "Psychomotor Handwriting",
                      field : "psychomotor_handwriting",
                                              hidden : false},
                                                              { label : "Psychomotor Verbal Fluency",
                      field : "psychomotor_verbal_fluency",
                                              hidden : false},
                                                              { label : "Psychomotor Sport",
                      field : "psychomotor_sport",
                                              hidden : false},
                                                              { label : "Psychomotor Handling Tools",
                      field : "psychomotor_handling_tools",
                                              hidden : false},
                                                              { label : "Psychomotor Drawing And Painting",
                      field : "psychomotor_drawing_and_painting",
                                              hidden : false},
                                                              { label : "Psychomotor Cooperation",
                      field : "psychomotor_cooperation",
                                              hidden : false},
                                                              { label : "Psychomotor Attentiveness",
                      field : "psychomotor_attentiveness",
                                              hidden : false},
                                                              { label : "Psychomotor Perseverance",
                      field : "psychomotor_perseverance",
                                              hidden : false},
                                                              { label : "Psychomotor Attitude To Work",
                      field : "psychomotor_attitude_to_work",
                                              hidden : false},
                                                              { label : "Next Term Begins On",
                      field : "next_term_begins_on",
                                              hidden : false},
                                                              { label : "Created At",
                      field : "created_at",
                                              hidden : true},
                                                              { label : "Updated At",
                      field : "updated_at",
                                              hidden : true},
                                        
                  {
                    label: 'Actions',
                    field: 'action',
                    sortable: false,

                  },

                ],

            };
        },


        components: {
          "json-excel":JsonExcel,
          "html-pdf":VueHtml2pdf,  
        },

                               
        methods: {

            resultinfoDetail(params){
              this.clickedRow = params.row;
              $('#resultinfoDetail').modal('show');
            },

            updateResultinfo(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/resultinfos/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');
                    this.loadResultinfos();
                })
                .catch(() => {
                    Toast.fire({
                          icon: 'error',
                          title: 'Some error occured!'
                      });
                    this.$Progress.fail();
                });
            },

            editModal(resultinfo){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(resultinfo);
            },

            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            deleteResultinfo(id){
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
                                this.form.delete('api/resultinfos/'+JSON.stringify(theData) ).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'The resultinfo was deleted successfully.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadResultinfos();
                                }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                         }
                    })
            },

            deleteSelectedResultinfos(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete "+this.selectedRows.length+" records? You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                let theData = JSON.stringify(this.selectedRows);
                                this.form.delete('api/resultinfos/'+theData).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'The resultinfo was deleted successfully.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadResultinfos();
                                }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                         }
                    })
            },
            

            createResultinfo(){
                this.form.post('api/resultinfos')
                .then((response)=>{
                    $('#addNew').modal('hide');
                    Toast.fire({
                          icon: 'success',
                          title: response.data.message
                    });
                    this.$Progress.finish();
                    this.loadResultinfos();
                })
                .catch(()=>{
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

            print () {
              this.$Progress.start();
              this.$htmlToPaper('printPaper');
              this.$Progress.finish();
            },
            

            updateParams(newProps) {
              this.serverParams = Object.assign({}, this.serverParams, newProps);
            },


            onSelectionChanged(params){
              this.selectedRows = [];
              for( var i=0; i< params.selectedRows.length; i++){
                if (params.selectedRows[i].vgtSelected)
                    this.selectedRows[i] = params.selectedRows[i].id;
              }
            },
            
            
            onPageChange(params) {
              this.updateParams({page: params.currentPage});
              this.loadResultinfos();
            },

            onPerPageChange(params) {
              this.updateParams({perPage: params.currentPerPage});
              this.loadResultinfos();
            },

            onSortChange(params) {
                var sortType = params[0].type;
                if(sortType != 'asc' && sortType != 'desc')
                  sortType = 'asc';
                this.updateParams({
                    sort: [{
                        type: sortType,
                        field: params[0].field,
                    }],
                });
                this.loadResultinfos();
            },


            onColumnFilter(params) {
              this.updateParams(params);
              this.loadResultinfos();
            },
            

            onSearch(params) {
              this.updateParams({searchTerm: params.searchTerm});
              this.loadResultinfos();
            },    


            toggleColumn( index, event ){
              // Set hidden to inverse of what it currently is
              this.$set( this.columns[ index ], 'hidden', ! this.columns[ index ].hidden );
            },


            // load items is what brings back the rows from server
            loadResultinfos() {
                this.$Progress.start();
                var parameters = "?perPage="+ this.serverParams.perPage;
                parameters = parameters + "&page="+ this.serverParams.page;
                parameters = parameters + "&sortField="+ this.serverParams.sort[0].field;
                parameters = parameters + "&sortType="+ this.serverParams.sort[0].type;
                parameters = parameters + "&searchTerm="+ this.serverParams.searchTerm;
                var url = "api/resultinfos"+parameters;
                //console.log(JSON.stringify( url));
                try{
                    this.form.get( url ).then( resultinfos  => {
                        if(resultinfos.data.data){
                          this.totalRecords = resultinfos.data.data.total
                          this.resultinfos = resultinfos.data.data.data;
                        }
                    });
                } catch(error){
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
              return separateWord.join(' ');
            },


            isSpecialColumn(field){
              if(field != 'id' && field != 'updated_at' && field != 'created_at' 
                   && field != 'vgt_id' && field != 'vgtSelected' && field != 'originalIndex' ) 
                    return false;
                   else
                    return true;
            },

      
                                                                                                                                                                                                                                                    loadSections(){


                          try{
                              var url = "api/sections?id=all";
                              axios.get( url ).then( sections  => {
                                  if(sections.data.data){
                                    this.sections = sections.data.data;
                                  }
                              });
                          } catch(error){
                            console.log(error.message);
                          };

                    },
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        



        },


        mounted() {
            //console.log('Resultinfo Component mounted.')
            this.$Progress.start();
            this.loadResultinfos();
                                                                                                                                                                                                                                                    this.loadSections();          
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    this.$Progress.finish();

        },


        created() {
            this.$Progress.start();
            this.loadResultinfos();
            this.$Progress.finish();
            
        },


        computed: {},

        
    }


</script>

<style>
@media  screen and (min-width: 990px) {
  #printPaper {
    margin-left: -22.2%;
    padding: 0% 1% 3% 1%;
    width: 100%;
  }
}
</style>



