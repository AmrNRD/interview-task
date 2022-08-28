<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                user_id:'{{ isset($cart)?getData($cart,'user_id'):null }}', 

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
                            title:"Cart Saved",
                            subtitle:"Cart",
                            body:"Cart has been  @if ($action == 'edit')'Updated'@else 'inserted' @endif successfully in the system"
                        },
                        fail:{
                            title:"Process Failed",
                            subtitle:"Fail",
                            body:"This process has failed"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ $action == 'edit'?null:route("carts.$action") }}'
                }else{
                    request.redirect = '{{ route("carts.index") }}'
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
