<script>

    var vue = new Vue({
        el: '#table',
        data: {
       },
        mounted () {

        },
        methods: {

            onChange(id,event) {
                let request = {

                    method: "post",

                    url:'{{ route("stores.activate","") }}'+'/'+id,

                    data:{'state':event.value===true?"active":"inactive"},

                    toaster:{
                        success:{
                            title:"Store "+(event.value===true?"Activated":"Deactivated"),
                            subtitle:"Store",
                            body:"Store has been "+(event.value===true?"Activated":"Deactivated")+" successfully in the system"
                        },
                        fail:{
                            title:"Failed",
                            subtitle:"Fail",
                            body:"Failed to take this action"
                        }
                    }
                }
                request.redirect =null;


                this.isLoading = true;
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
