<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title pt-2">Topup Table</h3>
                <div class="row">
                  <div class="col card-tools">
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr >
                      <th>TopupID</th>
                      <th>UserID</th>
                      <th>Topup Amount</th>
                      <th>Image</th>
                      <th>Import Date</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="topup in topups.data" :key="topup.id">
                        <td>{{topup.id}}</td>
                        <td>{{topup.user_id}}</td>
                        <td>{{topup.amount}}</td>
                        <td>
                          <button type="button" class="btn btn-primary" @click="getImage(topup)">
                            Image
                          </button>
                        </td>
                        <td>{{topup.created_at | date}}</td>
                      </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                    <pagination :data="topups" @pagination-change-page="getResults"></pagination>
                    <button class="btn btn-success" @click="loadSuccess()">Topuped Success Record</button>
                    <button class="btn btn-danger" @click="loadRejected()">Rejected Record</button>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!--Image Modal -->
        <div class="modal fade" id="imageModal" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="imageModal">Cheque Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img :src="'/images/cheques/'+image" class="rounded float-left pt-3 mb-3" width="100%" height="400px">

                <div class="form-group mt-2">
                  <label>Transfer Method : </label>{{form.transfer_method}}
                </div>

                <div class="form-group mt-2">
                  <input type="text" class="form-control" v-model="form.reference_id" placeholder="Reference ID" :class="{ 'is-invalid': form.errors.has('reference_id')}">
                  <has-error :form="form" field="reference_id" style="color:red;"></has-error>
                </div>

                <button type="button" class="btn btn-success mt-3" @click="valid()">Top up</button>
                <button type="button" class="btn btn-danger mt-3" @click="unvalid()">Reject</button>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Success Modal -->
        <div class="modal fade" id="successModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Topup Success Table</h5>
                  <div class="form-inline">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input class="form-control form-control-sm ml-3 w-200" type="text" placeholder="Search by user ID" v-model="searchSuccess" @keyup="searchS">
                  </div>   
              </div>
              <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                      <thead>
                        <tr >
                          <th>Topup ID</th>
                          <th>User ID</th>
                          <th>Topup Amount</th>
                          <th>Transfer Method</th>
                          <th>Image</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-for="success in successs.data" :key="success.id">
                            <td>{{success.id}}</td>
                            <td>{{success.user_id}}</td>
                            <td>{{success.amount}}</td>
                            <td>{{success.transfer_method}}</td>
                            <td>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#successImageModal" @click="getSuccessImage(success.id)">
                                Image
                              </button>
                            </td>
                            <td>{{success.created_at | date}}</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="modal-footer">
                <pagination :data="successs" @pagination-change-page="getSuccessResults"></pagination>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!--Success Image Modal -->
        <div class="modal fade" id="successImageModal" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="imageModal">Cheque Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img :src="'/images/cheques/'+image" class="rounded float-left pt-3" width="100%" height="400px">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Rejected Modal -->
        <div class="modal fade" id="rejectedModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Rejected Table</h5>
                <div class="form-inline">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <input class="form-control form-control-sm ml-3 w-200" type="text" placeholder="Search by user ID" v-model="searchRejected" @keyup="searchR">
                </div>   
              </div>
              <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                      <thead>
                        <tr >
                          <th>Topup ID</th>
                          <th>User ID</th>
                          <th>Topup Amount</th>
                          <th>Transfer Method</th>
                          <th>Image</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-for="reject in rejects.data" :key="reject.id">
                            <td>{{reject.id}}</td>
                            <td>{{reject.user_id}}</td>
                            <td>{{reject.amount}}</td>
                            <td>{{reject.transfer_method}}</td>
                            <td>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#rejectedImageModal" @click="getRejectedImage(reject.id)">
                                Image
                              </button>
                            </td>
                            <td>{{reject.created_at | date}}</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
              </div>
              <div class="modal-footer">
                <pagination :data="rejects" @pagination-change-page="getRejectedResults"></pagination>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!--Rejected Image Modal -->
        <div class="modal fade" id="rejectedImageModal" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="imageModal">Cheque Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img :src="'/images/cheques/'+image" class="rounded float-left pt-3" width="100%" height="400px">
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
            successs : {},
            rejects : {},
            topups : {},
            image : null,
            searchSuccess : null,
            searchRejected : null,
            form : new Form({
              id : null,
              user_id : null,
              amount : null,
              transfer_method : null,
              reference_id : null,
            })
        }
    },
    methods:{
        loadTopups(){
            axios.get('/api/topup').then(({data}) => (this.topups = data));
        },
        getResults(page = 1) {
          axios.get('/api/topup?page=' + page)
            .then(response => {
              this.topups = response.data;
            });
        },
        getImage(topup){
          this.form.fill(topup)
          axios.get('/api/topup/' +this.form.id).then(({data}) => (this.image = data));
          $('#imageModal').modal('show')
        },
        getSuccessImage(successID){
          axios.get('/api/topup/' +successID).then(({data}) => (this.image = data));
        },
        getRejectedImage(rejectedID){
          axios.get('/api/topup/' +rejectedID).then(({data}) => (this.image = data));
        },
        valid(){
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Top up!'
            }).then((result) => {
              if (result.value) {
                this.form.post('/api/valid/')
                .then(() =>{
                  Toast.fire({
                    icon: 'success',
                    title: 'Credit Topup Success'
                  })
                  Fire.$emit('refresh');
                  $('#imageModal').modal('hide')
                })
                .catch((error) => {
                  if(error.response.status == 403){
                        Swal.fire({
                        icon: 'error',
                        title: 'Opps',
                        text: 'Already Top up this credit before!',
                        })
                    }else{
                        Swal.fire({
                        icon: 'error',
                        title: 'Opps',
                        text: 'Something wrong, please refresh',
                        })
                  }
                })
              }
            })
        },
        unvalid(){
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Reject!'
            }).then((result) => {
              if (result.value) {
                this.form.post('/api/unvalid/')
                .then(() =>{
                  Toast.fire({
                    icon: 'success',
                    title: 'Reject Successfully'
                  })
                  Fire.$emit('refresh');
                  $('#imageModal').modal('hide')
                })
                .catch(() => {
                  Swal.fire({
                        icon: 'error',
                        title: 'Opps!',
                        text: 'Something went wrong, please refresh',
                  })
                })
              }
            })
        },
        loadSuccess(){
          axios.get('/api/success').then(({data}) => (this.successs = data));
          $('#successModal').modal('show')
        },
        getSuccessResults(page = 1) {
          axios.get('/api/success?page=' + page)
          .then(response => {
            this.successs = response.data;
          });
        },
        loadRejected(){
          axios.get('/api/rejected').then(({data}) => (this.rejects = data));
          $('#rejectedModal').modal('show')
        },
        getRejectedResults(page = 1) {
          axios.get('/api/rejected?page=' + page)
          .then(response => {
            this.rejects = response.data;
          });
        },
        searchS: _.debounce(() => {
            Fire.$emit('searchSuccess')
        },1000),
        searchR: _.debounce(() => {
            Fire.$emit('searchRejected')
        },1000)
    },
    created(){
        this.loadTopups();
        Fire.$on('refresh',() => {
          this.loadTopups();
        })
        Fire.$on('searchSuccess', () =>{
            let query = this.searchSuccess
            axios.get('/api/searchsuccesstopup?q=' + query)
            .then((data) =>{
                this.successs = data.data
            })
            .catch(() =>{
            })
        })
        Fire.$on('searchRejected', () =>{
            let query = this.searchRejected
            axios.get('/api/searchrejectedtopup?q=' + query)
            .then((data) =>{
                this.rejects = data.data
            })
            .catch(() =>{
            })
        })
    }
}
</script>