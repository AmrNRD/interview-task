@include('backend.globals.vue_validation')


<div class="form-group">
    <label for="cart_id">Cart</label>
    <select class="custom-select rounded-0" v-model="fData.cart_id" id="cart_id">
        @foreach($carts as $cart)
             <option value="{{$cart->id}}">{{$cart->id}}</option>
        @endforeach

    </select>
</div>


<div class="form-group">
    <label for="product_id">Product</label>
    <select class="custom-select rounded-0" v-model="fData.product_id" id="product_id">
        @foreach($products as $product)
             <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach

    </select>
</div>


