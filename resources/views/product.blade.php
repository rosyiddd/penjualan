@extends('header')
<div id="regForm">
  <a href="/logout">logout</a>
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
      </div>
    <div class="tab">
      <h1>Product List</h1>
      @foreach ($products as $item)
      <div style="display:flex;margin-bottom:6px;align-items:center">
        <div style="flex:1;">
            <div style="width:70px;height:70px;background-color:aqua"></div>
            </div>
            <div style="flex:2;">
                <div style="display:flex;flex-direction:column">
                    <a href="/product/{{$item->product_code}}">{{$item->product_name}}</a>
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
        @endforeach
    </div>
    <div class="tab">
        <h1>Checkout</h1>
        <div id="checkout"></div>
        <div style="display:flex;justify-content:center;margin-top:20px;">
            <span style="border:1px solid black;padding:10px">Total : Rp<span id="total"></span></span>
        </div>
  </div>
    <div class="tab">
        <h1>Success Transaction</h1>
        <div style="display:flex;justify-content:center;margin-top:20px;">
          <button type="button" id="print" onclick="print()">PRINT</button>
        </div>
  </div>
  <div style="overflow:auto;margin-top:20px">
    <div style="float:right;">
      <button type="button" id="back" onclick="nextPrev(-1)">BACK</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">CONFIRM</button>
    </div>
  </div>
</div>

<script>
var currentTab = 0;
showTab(currentTab);

function showTab(n) {
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == 0) {
    document.getElementById("back").style.display = "none";
  } else {
    document.getElementById("back").style.display = "inline";
  }
  if (n == (x.length - 2)) {
    document.getElementById("nextBtn").innerHTML = "CONFIRM";
  } else {
    document.getElementById("nextBtn").innerHTML = "CHECKOUT";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}
function hitungTotal(){
  let total = document.getElementById('total')
  let subtotal = document.getElementsByClassName('subtotal')
  let temp = 0;
  for(let i = 0; i < subtotal.length; i++){
    temp += parseInt(subtotal[i].innerHTML);
  };
  console.log(temp)
  total.innerHTML = temp;
}
function checkoutPage(){
    let local = localStorage.getItem('store');

    let div = document.getElementById('checkout');
    let localParse = JSON.parse(local);
    let html = "";
    localParse != "null" && localParse.forEach(element => {
      html += `<div style="display:flex;margin-bottom:6px">
              <div style="flex:1;">
                  <div style="width:70px;height:70px;background-color:aqua"></div>
              </div>
              <div style="flex:2;">
                  <div style="display:flex;flex-direction:column;">
                      <span><b>${element.product_name}</b></span>
                      <span><input type="text" value=${element.quantity} style="width:40px;height:20px">PCS</span>
                      <span style="margin-top:10px;">
                        Subtotal : Rp<span class="subtotal">${element.priceAfterDiscount*element.quantity}</span>
                        </span>
                  </div>
              </div>
          </div>`;
    });
    div.innerHTML = html;
    hitungTotal();
  }
  function transaction(){
    let data = {
      total: document.getElementById('total').innerHTML,
      data: JSON.parse(localStorage.getItem('store'))
    }
    localStorage.setItem('store', null);
  fetch(`{{ URL::to('/') }}/transaction`, {
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content'),
        "Content-Type": "application/json",
    },
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(json => console.info(""));
}
function nextPrev(n) {
  var x = document.getElementsByClassName("tab");
  x[currentTab].style.display = "none";
  document.getElementsByClassName("step")[currentTab].className += " finish";
  currentTab = currentTab + n;
  // alert(currentTab);
  if (currentTab == 1 && checkoutPage());
  if (currentTab == 2 && transaction());
  if (currentTab >= x.length) {
    document.getElementById("regForm").submit();
    return false;
  }
  showTab(currentTab);
}

function fixStepIndicator(n) {
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}

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

function print(){
  window.location.href="/transaction/print";
}
</script>

</body>
</html>
