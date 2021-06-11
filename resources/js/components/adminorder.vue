<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title pt-2">Order Table</h3>
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
                      <th>OrderID</th>
                      <th>UserID</th>
                      <th>ItemName</th>
                      <th>City</th>
                      <th>QR Code</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="order in orders.data" :key="order.id">
                        <td>{{order.id}}</td>
                        <td>{{order.user_id}}</td>
                        <td>{{order.item_name}}</td>
                        <td>{{order.user_city}}</td>
                        <td><button class="btn btn-primary" @click="getQRImage(order.qr_code)">QR Code</button></td>
                        <td><button class="btn btn-primary" @click="getDescriptionImage(order.description_image)">Description</button></td>
                        <td>{{order.quantity}}</td>
                        <td>{{order.make_order_date}}</td>
                        <td>
                            <button class="btn btn-success mb-2" @click="placeOrder(order.id,order.user_id,order.quantity)">
                                Order
                            </button>
                            <button class="btn btn-danger" @click="rejecting(order.id)">
                                Reject
                            </button>
                        </td>
                      </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="orders" @pagination-change-page="getResults"></pagination><br>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Make Order Modal -->
        <div class="modal fade" id="makeOrderModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="makeOrderModal">Place Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Item Price</label>
                        <input type="text" v-model="form.item_price" @keyup="total()" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Shippment amount</label>
                        <input type="text" v-model="form.shippment_amount" @keyup="total()" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Total Amount (quantity x price + shippment amount)</label>
                        <input type="text" v-model="form.total_amount" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>User Credit</label>
                        <input type="text" v-model="credit" class="form-control" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" :disabled="valid(form.total_amount,credit)" @click="makeOrder()">Place Order</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModal">Reject Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h6>Reject Reason</h6>
                    <button type="button" class="btn btn-danger mt-1 mb-1" @click="notEnoughCredit()">Not Enough Credit</button><br>
                    <button type="button" class="btn btn-danger mt-1 mb-2" @click="outOfStock()">Item Out Of Stock</button><br>
                    <textarea class="form-control" rows="3" v-model="form.rejected_reason" placeholder="Another Reason"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="rejectOrder()">Reject</button>
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
                <img :src="'/images/qr_code_images/'+qr_code" class="rounded float-left pt-3" width="100%" height="400px">
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
                <img :src="'/images/description_images/'+description_image" class="rounded float-left pt-3" width="100%" height="400px">
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
            orders : {},
            url : null,
            credit : null,
            qr_code : null,
            description_image : null,
            form : new Form({
                id : null,
                user_id : null,
                item_price : null,
                quantity : null,
                shippment_amount : null,
                total_amount : null,
                rejected_reason : null,
            }),
        }
    },
    methods:{
        loadOrders(){
            axios.get('/api/getuserorders').then(({data}) => (this.orders = data));
        },
        getResults(page = 1) {
          axios.get('/api/getuserorders?page=' + page)
            .then(response => {
              this.orders = response.data;
            });
        },
        getUrl(url){
            this.url = url
            $('#urlModal').modal('show')
        },
        getQRImage(qr_code){
            this.qr_code = qr_code
            $('#qrCodeImageModal').modal('show')
        },
        getDescriptionImage(description_image){
            this.description_image = description_image
            $('#descriptionImageModal').modal('show')
        },
        placeOrder(order_id,user_id,quantity){
            this.form.reset()
            this.form.id = order_id
            this.form.user_id = user_id
            this.form.quantity = quantity
            axios.get('/api/getusercredit?q=' +user_id).then(({data}) => (this.credit = data));
            $('#makeOrderModal').modal('show')
        },
        valid(total_amount,credit){
            if(total_amount > credit){
                return true
            }else{
                return false
            }
        },
        total(){
            return this.form.total_amount = parseInt(this.form.quantity) * parseInt(this.form.item_price) + parseInt(this.form.shippment_amount)
        },
        makeOrder(){
            this.form.post('/api/makeorder')
            .then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Order Placed Success'
                })
                this.form.reset();
                Fire.$emit('refresh');
            })
            .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps!',
                        text: 'Something went wrong, please refresh',
                    })
            })
        },
        rejecting(order_id){
            this.form.reset()
            this.form.id = order_id
            $('#rejectModal').modal('show')
        },
        rejectOrder(){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Reject Order!'
            }).then((result) => {
              if (result.value) {
                this.form.post('/api/rejectOrder/')
                .then(() =>{
                  Toast.fire({
                    icon: 'success',
                    title: 'Reject Successfully'
                  })
                  this.form.reset()
                  Fire.$emit('refresh');
                  $('#rejectModal').modal('hide')
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
        notEnoughCredit(){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Reject Order!'
            }).then((result) => {
              if (result.value) {
                this.form.rejected_reason = "Not Enough Credit Amount"  
                this.form.post('/api/rejectOrder/')
                .then(() =>{
                  Toast.fire({
                    icon: 'success',
                    title: 'Reject Successfully'
                  })
                  this.form.reset()
                  Fire.$emit('refresh');
                  $('#rejectModal').modal('hide')
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
        outOfStock(){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Reject Order!'
            }).then((result) => {
              if (result.value) {
                this.form.rejected_reason = "Item Out Of Stock"
                this.form.post('/api/rejectOrder/')
                .then(() =>{
                  this.form.rejected_reason = "Not Enough Credit Amount"  
                  Toast.fire({
                    icon: 'success',
                    title: 'Reject Successfully'
                  })
                  this.form.reset()
                  Fire.$emit('refresh');
                  $('#rejectModal').modal('hide')
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
    },
    created(){
        this.loadOrders()
        Fire.$on('refresh',() => {
          this.loadOrders();
        })
    }
}
</script>