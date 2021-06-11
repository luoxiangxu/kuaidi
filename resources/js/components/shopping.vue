<template>
<div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col card-tools">
                      <button class="btn btn-success" @click="addNew"><i class="fa fa-cart-plus mr-2"></i>Shopping</button>
                  </div>
                    <div class="form-inline">
                      <i class="fa fa-search" aria-hidden="true"></i>
                      <input class="form-control form-control-sm ml-3 w-200" type="text" placeholder="Search by item name" v-model="searchAddToCart" @keyup="searchit">
                    </div>                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr >
                      <th>Item Name</th>
                      <th>Date</th>
                      <th>Motify</th>
                      <th>Order</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="item in items.data" :key="item.id">
                        <td>{{item.item_name}}</td>
                        <td>{{item.created_at | date}}</td>
                        <td>
                            <a href="#" @click="editItem(item)">
                                <span style="font-size: 20px; color: purple;">
                                  <i class="fa fa-edit"></i>
                                </span>
                            </a>
                            /
                            <a href="#" @click="deleteItem(item.id)">
                                <span style="font-size: 20px; color: red;">
                                  <i class="fa fa-trash"></i>
                                </span>
                            </a>
                        </td>
                        <td><button class="btn btn-success" @click="order(item.id)">Order</button></td>
                      </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="items" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!--Shopping Modal -->
        <div class="modal fade" id="shoppingModal" data-backdrop="false" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 v-show="editMode" class="modal-title" id="addNew">Edit Item</h5>
                <h5 v-show="!editMode" class="modal-title" id="addNew">Shopping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updateItem() : shopping()">
                <div class="modal-body">
                    <div class="form-group pb-2" v-show="!editMode">
                        <label>QR Code</label><br>
                        <input type="file" id="qr_code" @change="qrCodeImage"
                          :class="{ 'is-invalid': form.errors.has('qr_code') }">
                        <has-error :form="form" field="qr_code" style="color:red;"></has-error>
                    </div>
                    <div class="form-group pb-2" v-show="!editMode">
                        <label>Description Image</label><br>
                        <input type="file" id="description_image" @change="descriptionImage"
                          :class="{ 'is-invalid': form.errors.has('description_image') }">
                        <has-error :form="form" field="description_image" style="color:red;"></has-error>
                    </div>
                    <div class="form-group pb-2" v-show="editMode">
                        <button class="btn btn-primary" @click.prevent="getQRImage">View QR Code Image</button>
                    </div>
                    <div class="form-group pb-2" v-show="editMode">
                        <button class="btn btn-primary" @click.prevent="getDescriptionImage">View Description Image</button>
                    </div>
                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" v-model="form.item_name" class="form-control" 
                        :class="{ 'is-invalid': form.errors.has('item_name')}" placeholder="Item Name">
                        <has-error :form="form" field="item_name" style="color:red;"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" v-model="form.quantity" class="form-control" 
                        :class="{ 'is-invalid': form.errors.has('quantity')}" placeholder="Item Quantity">
                        <has-error :form="form" field="quantity" style="color:red;"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Remarks (Optional)</label>
                        <input type="text" v-model="form.remark" class="form-control" 
                        :class="{ 'is-invalid': form.errors.has('remark')}" placeholder="Remark">
                        <has-error :form="form" field="remark"></has-error>
                    </div>
                    <button type="submit" class="btn btn-primary" v-show="!editMode">Add to Cart</button>
                    <button type="submit" class="btn btn-primary" v-show="editMode">Edit</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
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
          return {
            items : {},
            editMode : false,
            searchAddToCart : null,
            form : new Form({
                id : null,
                qr_code : null,
                description_image:null,
                item_name : null,
                quantity : null,
                remark : null,
            })
          }
        },
        methods:{
            getResults(page = 1) {
                axios.get('/api/cart?page=' + page)
                .then(response => {
                    this.items = response.data;
                });
            },
            loadItems(){
                axios.get('/api/cart/').then(({data}) => (this.items = data));
            },
            addNew(){
                this.form.reset()
                this.editMode = false
                $('#shoppingModal').modal('show')
            },
            qrCodeImage(element){
                this.form.qr_code = null
                let file = element.target.files[0];
                let reader = new FileReader();
                reader.onloadend = (file)=> {
                    this.form.qr_code = reader.result;
                }
                reader.readAsDataURL(file);  
            },
            descriptionImage(element){
                this.form.description_image = null
                let file = element.target.files[0];
                let reader = new FileReader();
                reader.onloadend = (file)=> {
                    this.form.description_image = reader.result;
                }
                reader.readAsDataURL(file);  
            },
            editItem(item){
                this.editMode = true
                $('#shoppingModal').modal('show')
                this.form.fill(item)
            },
            getQRImage(){
                $('#qrCodeImageModal').modal('show')
            },
            getDescriptionImage(){
                $('#descriptionImageModal').modal('show')
            },
            shopping(){
                 this.form.post('/api/cart/')
                .then(() => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Item add to cart successfully!'
                    })
                    this.form.reset()
                    $("#qr_code").val('');
                    $("#description_image").val('');
                    Fire.$emit('refresh')
                }).catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps!',
                        text: 'Something went wrong',
                    })
                })
            },
            updateItem(){
                this.form.put('/api/cart/' +this.form.id)
                .then(()=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'Order edit successfully'
                    })
                    Fire.$emit('refresh')
                })
                .catch(()=>{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                })
            },
            deleteItem(id){
                Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure to delete this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/cart/'+ id)
                        .then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Order has been deleted.',
                                'success'
                            )
                            Fire.$emit('refresh')
                        })
                        .catch(()=>{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })
                        })  
                    }
                })
            },
            order(order_id){
                Swal.fire({
                title: 'You wount be able to revert this?',
                text: "Are you sure to place this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Order it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.reset()
                        axios.get('/api/placeorder?q=' +order_id)
                        .then(() => {
                            Toast.fire({
                                icon: 'success',
                                title: 'Order placed successfully'
                            })
                            Fire.$emit('refresh')
                        })
                        .catch((error) => {
                            if(error.response.status == 403){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Order place has full! (Only 3 orders slot available for each user)',
                                    text: 'Please wait untill admin proccess your 3 previous orders first!',
                                })
                            }else if(error.response.status = 400){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Insufficient Credit Amount',
                                    text: 'Current credit amount is 0, please top up credit in order to get shopping',
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Opps!',
                                    text: 'Something went wrong',
                                })
                            }
                        })
                    }
                })
                
            },
            searchit: _.debounce(() => {
                Fire.$emit('searching')
            },1000)
        },
        created(){
            this.loadItems()
            Fire.$on('refresh',() => {
                this.loadItems();
            })
            Fire.$on('searching', () =>{
                let query = this.searchAddToCart
                axios.get('/api/searchaddtocart?q=' + query)
                .then((data) =>{
                    this.items = data.data
                })
                .catch(() =>{
                })
            })
        }
    }
</script>