
<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                                <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                                <li class="nav-item"><a class="nav-link" href="#change-password" data-toggle="tab">Change Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Activity Tab -->
                                <div class="tab-pane" id="activity">
                                    <h3 class="text-center">Display User Activity</h3>
                                </div>







<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>









                                

                                <div class="text-center" >
                                    <img :src="form.profile_picture" class="rounded-circle img-thumbnail" alt="profile image" style = "width:200px; height:200px;">
                                </div>
                                
                                <!-- Setting Tab -->
                                <div class="tab-pane active show" id="settings">
                                    <form @submit.prevent="updateInfo" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Name</label>

                                            <div class="col-sm-12">
                                            <input type="" v-model="form.name" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                            <div class="col-sm-12">
                                                <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                                <has-error :form="form" field="email"></has-error>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPhone" class="col-sm-2 control-label">Phone</label>

                                            <div class="col-sm-12">
                                                <input type="phone" v-model="form.phone" class="form-control" id="inputPhone" placeholder="Phone"  :class="{ 'is-invalid': form.errors.has('email') }">
                                                <has-error :form="form" field="phone"></has-error>
                                            </div>
                                        </div>



            <div class="form-group">
                <label for="gender" class="col-sm-2 control-label"> Gender </label>
                <div class="col-sm-12">
                    <select v-model="form.gender" name="gender" class="form-control" id = "gender" >
                        <option> Male </option>
                       <option> Female </option>
                    </select>
                </div>    
                <has-error :form="form" field="gender"></has-error>
            </div>


            <label for="profilePicture" class="col-sm-2 control-label">Profile picture</label> 
            <div class="col-sm-12">
    
                <div class="form-group">
                    <input type="file" class="custom-file-inpu" id="profilePicture" 
                    :class="{ 'is-invalid': form.errors.has('profilePicture') }"
                    ref="file" @change="handleFileObject"
                    accept="image/*"
                    >
                    <has-error :form="form" field="profilePicture"></has-error>
                </div>
            </div>

            <div class="col-sm-12" style="background-color:gray; border: solid dashed; width:100%; height: 5em">

            </div>







                                        
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success">Update Profile</button>
                                                <div class="float-right d-sm-inline text-muted">Member since: <span>{{form.created_at|myDate}}</span></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Setting Tab -->
                                <div class="tab-pane" id="change-password">
                                    <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="current_password" class="col-sm-2 control-label">Current Password</label>

                                        <div class="col-sm-12">
                                            <input type="password"
                                                v-model="form.current_password"
                                                class="form-control"
                                                id="current_password"
                                                placeholder="Current Password"
                                                :class="{ 'is-invalid': form.errors.has('current_password') }"
                                            >
                                            <has-error :form="form" field="current_password"></has-error>
                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password" class="col-sm-2 control-label">New Password</label>

                                        <div class="col-sm-12">
                                            <input type="password"
                                                v-model="form.new_password"
                                                class="form-control"
                                                id="new_password"
                                                placeholder="New Password"
                                                :class="{ 'is-invalid': form.errors.has('new_password') }"
                                            >
                                            <has-error :form="form" field="new_password"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>

                                        <div class="col-sm-12">
                                            <input type="password"
                                                v-model="form.confirm_password"
                                                class="form-control"
                                                id="confirm_password"
                                                placeholder="Confirm Password"
                                                :class="{ 'is-invalid': form.errors.has('confirm_password') }"
                                            >
                                            <has-error :form="form" field="confirm_password"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-12">
                                        <button @click.prevent="updatePassword" type="submit" class="btn btn-success">Update Password</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
            </div>
            <!-- end tabs -->
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return {
                 form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    phone: '',
                    gender: 'Male',
                    profile_picture: '',
                    password: '',
                    created_at: ''
                }),
                profilePictureObj: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{

            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }

                if(this.form.gender == undefined){
                    this.form.gender =  '';
                }

                let formData = new FormData();
                formData.append('id', this.form.id);
                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('gender', this.form.gender);
                formData.append('phone', this.form.phone);
                formData.append('profilePicture', this.profilePictureObj);

                formData.append('password', this.form.password);
                formData.append('created_at', this.form.created_at);


                //this.form.put('api/profile')
                axios.post('api/profile', formData, {
                    headers: {
                        'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substring(2)
                    }
                })
                .then((data)=>{
                    this.$Progress.finish();
                    Toast.fire({
                        icon: 'success',
                        title: data.data.message

                    }).then((result) => {
                        window.location.reload();
                    });

                })
                .catch((data) => {
                    this.$Progress.fail();

                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                });
            },

            updatePassword(){
                this.$Progress.start();
                this.form.post('api/change-password')
                .then((data)=>{
                    //  Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                    this.form.current_password = '';
                    this.form.new_password = '';
                    this.form.confirm_password = '';

                    Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                })
                .catch(() => {
                    this.$Progress.fail();

                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                });
            },


            handleFileObject(e) {
                if(e.target.id == 'profilePicture'){




                    if (e.target.files[0].size > 300000) {
                        Toast.fire(
                            'Error!',
                            'This image is larger than 3KB! Please choose a smaller image and try again.',
                            'error',
                            9000
                        );
                        const file = document.getElementById('profilePicture');
                        file.value = '';
                    }else{
                        this.profilePictureObj = e.target.files[0];
                        console.log(this.profilePictureObj.size);
                    }








                    
                    
                } 
            }







        },

        created() {

            this.$Progress.start();

            axios.get("api/profile")
            .then(({ data }) => (this.form.fill(data.data)));
            
            this.$Progress.finish();
        }
    }
</script>
