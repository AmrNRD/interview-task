@include('backend.globals.vue_validation')



<div class="form-group">
    <label for="fcm_token">FcmToken</label>
    <textarea v-model="fData.fcm_token" class="form-control" id="fcm_token" placeholder="FcmToken"></textarea>
</div>



<div class="form-group">
    <label for="type">Type</label>
    <select class="custom-select rounded-0" v-model="fData.type" id="type">
             <option value="ios">IOS</option>

             <option value="android">Android</option>

             <option value="web">Web</option>


    </select>
</div>



<div class="form-group">
    <label for="user_id">User</label>
    <select class="custom-select rounded-0" v-model="fData.user_id" id="user_id">
        @foreach($users as $user)
             <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach

    </select>
</div>


