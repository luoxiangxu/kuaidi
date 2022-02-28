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
                            <h6>From Date (Y-M-D)</h6>
                            <input type="Text" class="form-control" v-model="query.from_date"
                            :class="{ 'is-invalid': query.errors.has('from_date') }">
                            <has-error :form="query" field="from_date" style="color:red;"></has-error>
                        </div>
                        <div class="form-group col-md-6">
                            <h6>To Date (Y-M-D)</h6>
                            <input type="Text" class="form-control" v-model="query.to_date"
                            :class="{ 'is-invalid': query.errors.has('to_date') }">
                            <has-error :form="query" field="to_date" style="color:red;"></has-error>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mb-3" @click="getQuery()">Submit</button>
                    <div class="form-group row">
                        <div class="form-group col-md-6">
                            <h6>Total Amount (Order's Total Amount)</h6>
                            <input type="Text" class="form-control" disabled v-model="total_order_amount">
                        </div>
                        <div class="form-group col-md-6">
                            <h6>Total Income (Shippment's Total Amount)</h6>
                            <input type="Text" class="form-control" disabled v-model="total_shippment_amount">
                        </div>
                        <div class="form-group col-md-6">
                            <h6>Number of Order</h6>
                            <input type="Text" class="form-control" disabled v-model="number_of_order">
                        </div>
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
                      <th>Detail</th>
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
                        <td>{{order.ordered_date}}</td>
                        <td>
                            <button class="btn btn-primary" @click="detail(order)">
                                Detail
                            </button>
                        </td>
                      </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="orders" @pagination-change-page="getOrderResult" v-show="!queryed"></pagination>
                  <pagination :data="orders" @pagination-change-page="getQueryResult" v-show="queryed"></pagination>
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
            total_order_amount : null,
            total_shippment_amount : null,
            number_of_order : null,
            orders : {},
            queryed : false,
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
            }),
            query : new Form({
                from_date : null,
                to_date : null,
            })
        }
    },
    methods:{
        loadOrder(){
            axios.get('/api/orderrecord')
            .then((data) => {
                this.orders = data.data[0]
                this.total_order_amount = data.data[1]
                this.total_shippment_amount = data.data[2]
                this.number_of_order = data.data[3]
            });
        },
        getOrderResult(page = 1) {
          axios.get('/api/orderrecord?page=' + page)
            .then(response => {
              this.orders = response.data[0];
            });
        },
        getQuery(){
            this.queryed = true
            this.query.post('/api/getquery')
            .then((data) => {
                this.orders = data.data[0]
                this.total_order_amount = data.data[1]
                this.total_shippment_amount = data.data[2]
                this.number_of_order = data.data[3]
            });
        },
        getQueryResult(page = 1) {
          this.query.post('/api/getquery?page=' + page)
            .then(response => {
              this.orders = response.data[0];
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
    },
    created(){
        this.loadOrder()
    }
}
</script>