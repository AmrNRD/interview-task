<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                cart_id:'{{ isset($cartItem)?getData($cartItem,'cart_id'):null }}', 
product_id:'{{ isset($cartItem)?getData($cartItem,'product_id'):null }}', 

                /**/
                @if ($action == 'edit')
                    _method: 'put',
                @endif
            },
            isLoading: false,
            validation_errors: [],
        },
        mounted () {

        },
        methods: {
            submit (option = 'create') {

                let request = {

                    method: @if ($action == 'edit')'put'@else 'post' @endif,

                    url:'{{ $submitUrl }}',

                    data:this.fData,

                    toaster:{
                        success:{
                            title:"CartItem Saved",
                            subtitle:"CartItem",
                            body:"CartItem has been  @if ($action == 'edit')'Updated'@else 'inserted' @endif successfully in the system"
                        },
                        fail:{
                            title:"Process Failed",
                            subtitle:"Fail",
                            body:"This process has failed"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ $action == 'edit'?null:route("cart-items.$action") }}'
                }else{
                    request.redirect = '{{ route("cart-items.index") }}'
                }

                this.isLoading = true

                this.submitForm(
                    request,
                    (res)=>{
                        this.isLoading = false
                    },(err)=>{
                        this.isLoading = false
                    });

            },
        },
    });
</script>
