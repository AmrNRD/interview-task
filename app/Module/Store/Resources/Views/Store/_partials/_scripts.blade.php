<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                name:'{{ isset($store)?getData($store,'name'):null }}', 
user_id:'{{ isset($store)?getData($store,'user_id'):null }}', 
shipping_cost:'{{ isset($store)?getData($store,'shipping_cost'):null }}', 
vat_cost:'{{ isset($store)?getData($store,'vat_cost'):null }}', 

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
                            title:"Store Saved",
                            subtitle:"Store",
                            body:"Store has been  @if ($action == 'edit')'Updated'@else 'inserted' @endif successfully in the system"
                        },
                        fail:{
                            title:"Process Failed",
                            subtitle:"Fail",
                            body:"This process has failed"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ $action == 'edit'?null:route("stores.$action") }}'
                }else{
                    request.redirect = '{{ route("stores.index") }}'
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
