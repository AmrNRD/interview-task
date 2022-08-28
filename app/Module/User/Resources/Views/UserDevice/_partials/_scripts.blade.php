<script>

    var vue = new Vue({
        el: '#kt_page_portlet',
        data: {
            fData: {
                fcm_token:'{{ isset($userDevice)?getData($userDevice,'fcm_token'):null }}', 
type:'{{ isset($userDevice)?getData($userDevice,'type'):null }}', 
user_id:'{{ isset($userDevice)?getData($userDevice,'user_id'):null }}', 

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
                            title:"UserDevice Saved",
                            subtitle:"UserDevice",
                            body:"UserDevice has been  @if ($action == 'edit')'Updated'@else 'inserted' @endif successfully in the system"
                        },
                        fail:{
                            title:"Process Failed",
                            subtitle:"Fail",
                            body:"This process has failed"
                        }
                    }
                }
                if(option == 'continue'){
                    request.redirect = '{{ $action == 'edit'?null:route("user-devices.$action") }}'
                }else{
                    request.redirect = '{{ route("user-devices.index") }}'
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
