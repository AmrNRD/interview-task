@include('backend.globals.vue_validation')



<div class="form-group">
    <label for="store_id">Store</label>
    <select class="custom-select rounded-0" v-model="fData.store_id" id="store_id">
        @foreach($stores as $store)
             <option value="{{$store->id}}">{{$store->name}}</option>
        @endforeach

    </select>
</div>

<div class="form-group">
    <label for="price">Price</label>
    <input type="number" v-model="fData.price" class="form-control" id="price" placeholder="Price" step="0.1" min="-99999" max="99999">
</div>


<div class="form-group">
    <label for="vat_included">VatIncluded</label>
    <input type="checkbox" v-model="fData.vat_included" class="form-control" id="vat_included" placeholder="VatIncluded">
</div>



