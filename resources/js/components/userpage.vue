<template>
    <div class="container">

        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <div class="row">
                    <div class="col card-tools">
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <h6>Total User Number</h6>
                                <input type="Text" class="form-control" disabled v-model="total_user">
                            </div>
                            <div class="form-group col-md-6">
                                <h6>Search User By ID</h6>
                                <input class="form-control" type="text" placeholder="Search by user id" v-model="searchUser" @keyup="searchit">
                            </div> 
                        </div>      
                    </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>User Phone</th>
                                <th>City</th>
                                <th>Create at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.phone}}</td>
                                <td>{{user.user_city}}</td>
                                <td>{{user.created_at | date}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="users" @pagination-change-page="getResults"></pagination>
                </div>
                </div>
                <!-- /.card -->
            </div>
            </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            users : {},
            total_user : null,
            searchUser : null,
        }
    },
    methods:{
        getUser(){
            axios.get('/api/getuser')
            .then((data) => {
                this.users = data.data[0]
                this.total_user = data.data[1]
            });
        },
        getResults(page = 1) {
          axios.get('/api/getuser?page=' + page)
            .then(response => {
              this.users = response.data[0];
            });
        },
        searchit: _.debounce(() => {
            Fire.$emit('searchUser')
        },1000)

    },
    created(){
        this.getUser()
        Fire.$on('searchUser', () =>{
            let query = this.searchUser
            axios.get('/api/searchuser?q=' + query)
            .then((data) =>{
                this.users = data.data
            })
            .catch(() =>{
            })
        })
    }
}
</script>