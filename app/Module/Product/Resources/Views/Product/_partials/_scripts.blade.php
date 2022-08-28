<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                name:'{{ isset($product)?getData($product,'name'):null }}', 
store_id:'{{ isset($product)?getData($product,'store_id'):null }}', 
price:'{{ isset($product)?getData($product,'price'):null }}', 
vat_included:'{{ isset($product)?getData($product,'vat_included'):null }}', 

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
                            title:"Product Saved",
                            subtitle:"Product",
                            body:"Product has been  @if ($action == 'edit')'Updated'@else 'inserted' @endif successfully in the system"
                        },
                        fail:{
                            title:"Process Failed",
                            subtitle:"Fail",
                            body:"This process has failed"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ $action == 'edit'?null:route("products.$action") }}'
                }else{
                    request.redirect = '{{ route("products.index") }}'
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
