@include('backend.globals.vue_validation')


<div class="form-group">
    <label for="user_id">User</label>
    <select class="custom-select rounded-0" v-model="fData.user_id" id="user_id">
        @foreach($users as $user)
             <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach

    </select>
</div>


