<template>
    <div class="container">

        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col card-tools">
                      
                  </div>              
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                    <label>User Name</label>
                    <input type="text" class="form-control" disabled v-model="form.name">
                </div>
                <div class="form-group">
                    <label>Email Address(Can't Edit)</label>
                    <input type="text" class="form-control" disabled v-model="form.email">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" disabled v-model="form.phone">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" class="form-control" disabled v-model="form.user_city">
                </div>
                <button class="btn btn-primary" @click="edit">Edit</button>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  
              </div>
            </div>
            <!-- /.card -->
          </div>

          <!-- Modal -->
        <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" v-model="form.name"
                    :class="{ 'is-invalid': form.errors.has('name')}">
                    <has-error :form="form" field="name" style="color:red;"></has-error>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" v-model="form.user_password" placeholder="Leave empty if not edit"
                    :class="{ 'is-invalid': form.errors.has('user_password')}">
                    <has-error :form="form" field="user_password" style="color:red;"></has-error>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" v-model="form.phone" 
                    :class="{ 'is-invalid': form.errors.has('phone')}">
                    <has-error :form="form" field="phone" style="color:red;"></has-error>
                </div>
                <div class="form-group mt-3">
                    <h6>City</h6>
                    <select class="form-control" v-model="form.user_city" :class="{ 'is-invalid': form.errors.has('user_city')}">
                        <option disabled>Choose your city</option>
                        <option>Nam Kham</option>
                        <option>Muse</option>
                        <option>Lashio</option>
                        <option>Pyin Oo Lwin</option>
                        <option>Mandalay</option>
                        <option>Yangon</option>
                    </select>
                    <has-error :form="form" field="user_city" style="color:red;"></has-error>
                </div>
                <button type="button" class="btn btn-success" @click="update">Update</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            form : new Form({
                id : null,
                name : null,
                email : null,
                phone : null,
                user_password : null,
                user_city : null,
            })
        }
    },
    methods:{
        getProfile(){
            axios.get('/api/profile')
            .then(({data})=>(this.form.fill(data)))
        },
        edit(){
            $('#editModal').modal('show')
        },
        update(){
            this.form.post('/api/updateprofile')
            .then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Profile update successfully'
                })
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Opps!',
                    text: 'Something went wrong',
                })
            })
        }
    },
    created(){
        this.getProfile()
    }
}
</script>