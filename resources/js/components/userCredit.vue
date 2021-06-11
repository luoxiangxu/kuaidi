<template>
          <!-- Modal -->
        <div class="modal fade" id="creditModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="creditModal">Currently have <u>{{credit}}</u> kyat in account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="topup()">
                <div class="modal-body">
                    <div style="background-color:lightgrey;" class="pr-3 pt-3 pl-3 pb-3">
                        <h4>Credit Topup</h4>

                        <div class="from-group">
                        <h6>Cheque Image</h6>
                        <input type="file" id="image" @change="handleImage"
                            class="form-control-file" :class="{ 'is-invalid': form.errors.has('image')}">
                        <has-error :form="form" field="image" style="color:red;"></has-error>
                        </div>

                        <div class="form-group mt-3">
                            <h6>Transfer methods</h6>
                            <select class="form-control" v-model="form.transfer_method" :class="{ 'is-invalid': form.errors.has('transfer_method')}">
                            <option disabled>Transfer Methods</option>
                            <option>KBZ Pay</option>
                            <option>KBZ Mobile Banking</option>
                            <option>CB Pay</option>
                            </select>
                            <has-error :form="form" field="transfer_method" style="color:red;"></has-error>
                        </div>
                        
                        <div class="form-group mt-3">
                        <h6>Amount</h6>
                        <input v-model="form.amount" type="text" name="amount"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                        <has-error :form="form" field="amount" style="color:red;"></has-error>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Topup</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <img src="/images/payments/kbzpay.png" class="img-fluid" alt="Responsive image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
        </div>
</template>

<script>
  import axios from 'axios'
    export default {
        data(){
          return {
            credit : null,
            form : new Form({
                image : null,
                amount : null,
                transfer_method : null,
            })
          }
        },
        methods:{
            handleImage(element){
                let file = element.target.files[0];
                let reader = new FileReader();
                reader.onloadend = (file)=> {
                    this.form.image = reader.result;
                }
                reader.readAsDataURL(file); 
            },
            topup(){
                this.form.post('/api/topup/')
                .then(() => {
                    Swal.fire(
                        'Topup success!',
                        'we need to confirm your submmited cheque, please wait 15 mins for it',
                        'success'
                    )
                    this.form.reset();
                    $("#image").val('');
                }).catch((error) => {
                    if(error.response.status == 403){
                        Swal.fire({
                        icon: 'error',
                        title: 'Opps',
                        text: 'Please wait untill admin confirm your previous check request!',
                        })
                    }else{
                        Swal.fire({
                        icon: 'error',
                        title: 'Opps',
                        text: 'Something wrong, please refresh',
                        })
                    }
                })
            },
            getCredit(){
                axios.get('/api/getcredit')
                .then((response) => {
                    this.credit = response.data
                })
            }
        },
        created(){
            this.getCredit()
            setInterval(() =>this.getCredit(), 60000);
        }
    }
</script>