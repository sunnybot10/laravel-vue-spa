<template>
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card card-default card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle" :src="getProfilePhoto()" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">
                        {{ currentUser.name }}
                    </h3>
                    <p class="text-muted text-center">Role {{ currentUser.role }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-default">
                <div class="card-body">
                    <!-- Profile Form -->
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-4 control-label">Name</label>
                            <div class="col-sm-8">
                                <input  type="text" 
                                v-model="form.name" 
                                class="form-control" 
                                placeholder="Name" 
                                :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input  type="email" 
                                v-model="form.email" 
                                class="form-control" 
                                id="inputEmail" 
                                placeholder="Email"  
                                :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputExperience" class="col-sm-4 control-label">Experience</label>
                            <div class="col-sm-8">
                                <textarea   v-model="form.bio" 
                                class="form-control" 
                                id="inputExperience" 
                                placeholder="Experience" 
                                :class="{ 'is-invalid': form.errors.has('bio') }">    
                            </textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="updateProfile" class="col-sm-4 control-label">Profile Photo</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="updateProfile" @change="updateProfile">
                                <label class="custom-file-label" for="updateProfile">
                                    Choose file
                                </label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-12 control-label">Passport (leave empty if not changing)</label>
                        <div class="col-sm-8">
                            <input type="password"
                            v-model="form.password"
                            class="form-control"
                            id="password"
                            placeholder="Passport"
                            :class="{ 'is-invalid': form.errors.has('password') }"
                            >
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <button @click.prevent="updateInfo" type="submit" class="btn btn-success btn-sm">Save Changes</button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'home',
        data(){
            return {
                form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                }),
                profile:{}
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
        methods:{
            getProfilePhoto(){
                let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/"+ this.form.photo;
                return photo;
            },
            updateInfo(){

                this.$Progress.start();

                if(this.form.password == ''){
                    this.form.password = undefined;
                }

                this.form.put('api/profile')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    swal.fire('Profile Updated','Profile changes updated successfully','success');
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            }
        },
        created() {
            axios.get("api/profile")
            .then(({ data })=>{
                this.form.fill(data);
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            });
        }
    }
</script>
<style>
.widget-user-image img{
    width: 150px;
}
</style>