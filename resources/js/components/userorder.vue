<template>
    <div class="container">
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <div class="row">
                    <div class="col card-tools">
                        <div class="form-inline">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input class="form-control form-control-sm ml-3 w-200" type="text" placeholder="Search by item name" v-model="searchOrder" @keyup="searchit">
                        </div>                

                    </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>OrderID</th>
                                <th>Item Name</th>
                                <th>Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody v-for="order in orders.data" :key="order.id">
                            <tr>
                                <td>{{order.id}}</td>
                                <td>{{order.item_name}}</td>
                                <td>{{order.status}}</td>
                                <td><button class="btn btn-secondary" @click="detail(order)">Detail</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="orders" @pagination-change-page="getResults"></pagination>
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
                <div class="form-group pb-2">
                        <button class="btn btn-primary" @click="getQRImage">View QR Code Image</button>
                </div>
                <div class="form-group pb-2">
                    <button class="btn btn-primary" @click="getDescriptionImage">View Description Image</button>
                </div>
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
            searchOrder : null,
            orders : {},
            class : null,
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
                rejected_date : null,
            })
        }
    },
    methods:{
        getResults(page = 1) {
            axios.get('/api/getorders?page=' + page)
            .then(response => {
                this.orders = response.data;
            });
        },
        loadOrders(){
            axios.get('/api/getorders/').then(({data}) => (this.orders = data));
        },
        getQRImage(){
            $('#qrCodeImageModal').modal('show')
        },
        getDescriptionImage(){
            $('#descriptionImageModal').modal('show')
        },
        getClass(ordered,arrived,reject){
            if(ordered == null && arrived == null && reject == null){
                this.class="bg-warning"
                return this.class
            }else if(ordered == true && arrived == null && reject == null){
                this.class="bg-primary"
                return this.class
            }else if(ordered == true && arrived == true && reject == null){
                this.class="bg-success"
                return this.class
            }else if(ordered == null && arrived == null && reject == true){
                this.class="bg-danger"
                return this.class
            }
        },
        detail(order){
            this.form.fill(order)
            $('#detailModal').modal('show')
        },
        searchit: _.debounce(() => {
            Fire.$emit('searching')
        },1000),
    },
    created(){
        this.loadOrders()
        Fire.$on('searching', () =>{
            let query = this.searchOrder
            axios.get('/api/searchuserorder?q=' + query)
            .then((data) =>{
                this.orders = data.data
            })
        })
    }
}
</script>