@extends('header')

@section('content')
    <div id="regForm">
            <h1>Product</h1>
            <div style="display:flex;margin-bottom:6px;align-items:center">
              <div style="flex:1;">
                  <div style="width:70px;height:70px;background-color:aqua"></div>
                  </div>
                  <div style="flex:2;">
                      <div style="display:flex;flex-direction:column">
                          <span>{{$item->product_name}}</span>
                          <span @if ($item->discount > 0) style="text-decoration:line-through;" @endif>
                              Rp{{$item->price}}
                          </span>
                          @if ($item->discount > 0)
                          <span>Rp{{$item->priceAfterDiscount}}</span>
                          @endif
                      </div>
                  </div>
                  <a onclick="buyProduct('{{$item->product_code}}')" style="background-color:aqua;
                      padding:8px 15px;border-radius:27%;
                      color:white;text-decoration:none;
                      cursor:pointer">BUY</a>
              </div>
              <a href="/product">Product List</a>
        </div>
@endsection

<script>
function buyProduct(productCode){
  fetch(`{{ URL::to('/') }}/api/product/${productCode}`, {method: "GET"})
  .then(res => res.json())
  .then(json => {
    let local = localStorage.getItem('store');
    if(local != "null"){
      let localParse = JSON.parse(local);
      let exist = false;
      localParse != null && localParse.forEach(value=>{
        if(value.product_code == json.product_code){
          value.quantity += 1;
          exist = true;
        }
      });
      if(!exist){
        json.quantity = 1;
        localParse.push(json)
      }
      localStorage.setItem('store', JSON.stringify(localParse));
    }else{
      json.quantity = 1;
      localStorage.setItem('store', JSON.stringify([json]));
    }
  });
}
</script>
</body>
</html>