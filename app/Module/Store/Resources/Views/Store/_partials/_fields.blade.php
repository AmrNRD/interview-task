@include('backend.globals.vue_validation')


<div class="form-group">
    <label for="name">Name</label>
    <input type="text" v-model="fData.name" class="form-control" id="name" placeholder="Name">
</div>



<div class="form-group">
    <label for="user_id">User</label>
    <select class="custom-select rounded-0" v-model="fData.user_id" id="user_id">
        @foreach($users as $user)
             <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach

    </select>
</div>

<div class="form-group">
    <label for="shipping_cost">ShippingCost</label>
    <input type="number" v-model="fData.shipping_cost" class="form-control" id="shipping_cost" placeholder="ShippingCost" step="0.1" min="-99999" max="99999">
</div>

<div class="form-group">
    <label for="vat_cost">VatCost</label>
    <input type="number" v-model="fData.vat_cost" class="form-control" id="vat_cost" placeholder="VatCost" step="0.1" min="-99999" max="99999">
</div>


