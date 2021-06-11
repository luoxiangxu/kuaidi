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
                      <th>Amount</th>
                      <th>Image</th>
                      <th>Status</th>
                      <th>Import Date</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="topup in topups.data" :key="topup.id">
                        <td>{{topup.id}}</td>
                        <td>{{topup.amount}}</td>
                        <td>
                          <button type="button" class="btn btn-primary" @click="getImage(topup)">
                            Image
                          </button>
                        </td>
                        <td>{{topup.status}}</td>
                        <td>{{topup.created_at | date}}</td>
                      </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                    <pagination :data="topups" @pagination-change-page="getResults"></pagination>
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
            topups : {},
            image : null,
            form : new Form({
                id : null,
                transfer_method : null,
            })
        }
    },
    methods:{
        loadTopups(){
            axios.get('/api/usertopup').then(({data}) => (this.topups = data));
        },
        getResults(page = 1) {
          axios.get('/api/usertopup?page=' + page)
            .then(response => {
              this.topups = response.data;
            });
        },
        getImage(topup){
          this.form.fill(topup)
          axios.get('/api/topup/' +this.form.id).then(({data}) => (this.image = data));
          $('#imageModal').modal('show')
        },
    },
    created(){
        this.loadTopups()
    }
}
</script>