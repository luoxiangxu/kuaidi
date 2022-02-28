<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title pt-2">Arrived Order Table</h3>
                <div class="row">
                  <div class="col card-tools">
                       <div class="form-inline">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input class="form-control form-control-sm ml-3 w-200" type="text" placeholder="Search by order id" v-model="searchOrder" @keyup="searchit">
                        </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr >
                      <th>OrderID</th>
                      <th>UserID</th>
                      <th>ItemName</th>
                      <th>City</th>
                      <th>QR Code</th>
                      <th>Description</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="arrivedOrder in arrivedOrders.data" :key="arrivedOrder.id">
                        <td>{{arrivedOrder.id}}</td>
                        <td>{{arrivedOrder.user_id}}</td>
                        <td>{{arrivedOrder.item_name}}</td>
                        <td>{{arrivedOrder.user_city}}</td>
                        <td><button class="btn btn-primary" @click="getQRImage(arrivedOrder.qr_code)">QR Code</button></td>
                        <td><button class="btn btn-primary" @click="getDescriptionImage(arrivedOrder.description_image)">Description</button></td>
                        <td>{{arrivedOrder.make_order_date}}</td>
                        <td>
                            <button class="btn btn-primary" @click="detail(arrivedOrder)">
                                Detail
                            </button>
                            /
                            <button class="btn btn-success" @click="makeOrderArrived(arrivedOrder.id)">
                                Arrived
                            </button>
                        </td>
                      </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="arrivedOrders" @pagination-change-page="getArrivedOrderResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModal">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Item quantity</label>
                    <input type="text" v-model="form.quantity" class="form-control" disabled>
                </div>
                <div class="form-group" v-show="form.rejected_reason == null">
                    <label>Item price</label>
                    <input type="text" v-model="form.item_price" class="form-control" disabled>
                </div>
                <div class="form-group" v-show="form.rejected_reason == null">
                    <label>Shippment Fee</label>
                    <input type="text" v-model="form.shippment_amount" class="form-control" disabled>
                </div>
                <div class="form-group" v-show="form.rejected_reason == null">
                    <label>Total Amount(Include Shippment fee)</label>
                    <input type="text" v-model="form.total_amount" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Order Date Time (User)</label>
                    <input type="text" v-model="form.make_order_date" class="form-control" disabled>
                </div>
                <div class="form-group" v-show="form.rejected_reason == null">
                    <label>Order Date Time (Admin)</label>
                    <input type="text" v-model="form.ordered_date" class="form-control" disabled>
                </div>
                <div class="form-group" v-show="form.rejected_reason == null">
                    <label>Order Arrived Date</label>
                    <input type="text" v-model="form.order_arrived_date" class="form-control" disabled>
                </div>
                <div class="form-group" v-show="form.rejected_reason != null">
                    <label>Rejected date</label>
                    <input type="text" v-model="form.rejected_date" class="form-control" disabled>
                </div>
                <div class="form-group" v-show="form.rejected_reason != null">
                    <label>Rejected Reason</label>
                    <textarea class="form-control" rows="3" v-model="form.rejected_reason" disabled></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

        <!--QR Code Image Modal -->
        <div class="modal fade" id="qrCodeImageModal" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="qrCodeImageModal">QR Code Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img :src="'/images/qr_code_images/'+form.qr_code" class="rounded float-left pt-3" width="100%" height="400px">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!--Description Image Modal -->
        <div class="modal fade" id="descriptionImageModal" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="descriptionImageModal">Description Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img :src="'/images/description_images/'+form.description_image" class="rounded float-left pt-3" width="100%" height="400px">
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
            arrivedOrders : {},
            searchOrder : null,
            form : new Form({
                qr_code : null,
                description_image : null,
                quantity : null,
                item_price : null,
                shippment_amount : null,
                total_amount : null,
                make_order_date : null,
                ordered_date : null,
                order_arrived_date : null,
                rejected_reason : null,
            })
        }
    },
    methods:{
        arrivedOrder(){
            axios.get('/api/arrivedorder')
            .then(({data}) => {
                this.arrivedOrders = data
            })
        },
        getArrivedOrderResults(page = 1) {
          axios.get('/api/arrivedorder?page=' + page)
            .then(response => {
              this.arrivedOrders = response.data;
            });
        },
        detail(order){
            this.form.fill(order)
            $('#detailModal').modal('show')
        },
        getQRImage(qr_code){
            this.form.qr_code = qr_code
            $('#qrCodeImageModal').modal('show')
        },
        getDescriptionImage(description_image){
            this.form.description_image = description_image
            $('#descriptionImageModal').modal('show')
        },
        makeOrderArrived(id){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Order Arrived!'
            }).then((result) => {
              if (result.value) {
                this.form.get('/api/makeorderarrived?q=' +id)
                .then(() =>{
                  Toast.fire({
                    icon: 'success',
                    title: 'Order Success'
                  })
                  Fire.$emit('refreshArrivedOrder');
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
        searchit: _.debounce(() => {
            Fire.$emit('searching')
        },1000)
    },
    created(){
        this.arrivedOrder()
        Fire.$on('refreshArrivedOrder',() => {
          this.arrivedOrder();
        })
        Fire.$on('searching', () =>{
            let query = this.searchOrder
            axios.get('/api/searcharrivedorder?q=' + query)
            .then((data) =>{
                this.arrivedOrders = data.data
            })
            .catch(() =>{
            })
        })
    }
}
</script>