<?php
include 'config/database.php';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AfriTech — Cart</title>

<style>
:root{
  --magenta:#E6007E;
  --cyan:#55B7E3;
  --yellow:#F2D200;
  --ink:#1A1A1A;
  --bg:#F6F8FB;
  --white:#fff;
  --line:#E4E7EC;
  --muted:#667085;
  --shadow:0 10px 30px rgba(0,0,0,.08);
  --radius:16px;
  font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink)}
a{text-decoration:none;color:inherit}
img{max-width:100%;display:block}
.container{max-width:1200px;margin:auto;padding:0 20px}

/* NAV */
.topbar{background:#fff;border-bottom:1px solid var(--line);position:sticky;top:0;z-index:100}
.nav{display:flex;justify-content:space-between;align-items:center;padding:14px 0;gap:18px}
.brand img{height:40px}
.menu{display:flex;gap:18px;align-items:center;flex-wrap:wrap}
.menu a{font-weight:650}
.menu a:hover{color:var(--magenta)}
.actions{display:flex;gap:10px;align-items:center}
.pill{
  background:#fff;border:1px solid var(--line);
  padding:8px 14px;border-radius:999px;font-weight:800;
}
.btn{
  padding:12px 16px;border-radius:14px;font-weight:900;border:none;cursor:pointer;
  display:inline-flex;align-items:center;justify-content:center;gap:10px;
}
.btn.primary{background:var(--magenta);color:#fff}
.btn.primary:hover{opacity:.92}
.btn.outline{background:#fff;border:1px solid var(--line)}
.btn.outline:hover{border-color:#cfd4dc}
.btn.full{width:100%}

/* PAGE */
.header{padding:18px 0 10px}
.h1{margin:0;font-size:28px}
.small{color:var(--muted);font-size:13px;line-height:1.55}

.row{display:flex;gap:18px;align-items:flex-start}
.col{flex:1}
.sidebar{width:360px;min-width:300px}

.card{
  background:#fff;border:1px solid var(--line);
  border-radius:var(--radius);box-shadow:var(--shadow);
  overflow:hidden;
}
.pad{padding:16px}
.hr{height:1px;background:var(--line);margin:12px 0}

/* TABLE */
.table{
  width:100%;
  border-collapse:separate;
  border-spacing:0;
  overflow:hidden;
}
.table th,.table td{
  padding:12px;
  border-bottom:1px solid var(--line);
  text-align:left;
  vertical-align:middle;
}
.table th{
  font-size:12px;
  letter-spacing:.08em;
  text-transform:uppercase;
  color:#344054;
  background:#F9FAFB;
}
.table tr:last-child td{border-bottom:0}
.itemCell{
  display:flex;gap:10px;align-items:center;
}
.itemImg{
  width:58px;height:58px;
  border-radius:12px;
  border:1px solid var(--line);
  background:#fff;
  padding:6px;
  object-fit:contain;
}
.itemName{font-weight:900}
.itemMeta{font-size:12px;color:var(--muted)}

/* QTY */
.qty{
  display:inline-flex;align-items:center;gap:8px;
  border:1px solid var(--line);border-radius:14px;
  padding:6px;background:#fff;
}
.qty button{
  width:34px;height:34px;border-radius:12px;border:1px solid var(--line);
  background:#fff;cursor:pointer;font-weight:900;
}
.qty span{min-width:22px;text-align:center;font-weight:900}

.iconBtn{
  border:1px solid var(--line);
  background:#fff;
  border-radius:12px;
  padding:8px 10px;
  cursor:pointer;
  font-weight:900;
}
.iconBtn:hover{border-color:#cfd4dc}

/* VAT TOGGLE */
.toggleRow{display:flex;gap:10px;flex-wrap:wrap}
.toggle{
  flex:1;
  border:1px solid var(--line);
  background:#fff;
  border-radius:14px;
  padding:10px 12px;
  cursor:pointer;
  font-weight:950;
}
.toggle.active{
  border-color:rgba(230,0,126,.35);
  box-shadow:0 10px 22px rgba(230,0,126,.10);
}

/* SUMMARY */
.sumLine{display:flex;justify-content:space-between;gap:10px;margin:8px 0}
.sumLine b{font-weight:950}
.notice{
  padding:12px 14px;border-radius:16px;
  border:1px dashed rgba(230,0,126,.28);
  background:rgba(230,0,126,.06);
  color:#3b0a22;
  font-weight:800;
}

/* EMPTY */
.empty{
  text-align:center;
  padding:30px 16px;
}

/* TOAST */
.toast{
  position:fixed;bottom:18px;left:50%;transform:translateX(-50%);
  background:rgba(17,17,17,.92);color:#fff;padding:12px 14px;border-radius:14px;
  box-shadow:0 10px 30px rgba(0,0,0,.25);opacity:0;transition:opacity .2s;
  z-index:999;
}

/* RESPONSIVE */
@media(max-width:1000px){
  .row{flex-direction:column}
  .sidebar{width:100%}
}
</style>
</head>

<body>

<!-- NAV -->
<div class="topbar">
  <div class="container nav">
    <a class="brand" href="index.php"><img src="logo.png" alt="AfriTech"></a>

    <div class="menu">
      <a href="index.php">Home</a>
      <a href="shop.php">Shop</a>
      <a href="contact.php">Contact</a>
    </div>

    <div class="actions">
      <a class="pill" href="cart.php" title="Cart">
        🛒 <span id="cartTotalPill">KSh 0</span> • <span id="cartCount">0</span>
      </a>
      <a class="btn primary" href="checkout.php">Checkout</a>
    </div>
  </div>
</div>

<!-- HEADER -->
<section class="header">
  <div class="container">
    <h1 class="h1">Shopping Cart</h1>
    <p class="small">Review your items. VAT is optional — choose exclusive or inclusive.</p>
  </div>
</section>

<!-- CONTENT -->
<section style="padding: 0 0 40px;">
  <div class="container">
    <div class="row">
      <div class="col" id="cartRoot"></div>

      <div class="sidebar">
        <div class="card">
          <div class="pad">
            <div class="notice">Countrywide delivery — delivery cost confirmed after checkout.</div>

            <div class="hr"></div>

            <h3 style="margin:0 0 10px">VAT Mode</h3>
            <div class="toggleRow">
              <button class="toggle" id="vatExcl" type="button">VAT Exclusive</button>
              <button class="toggle" id="vatIncl" type="button">VAT Inclusive</button>
            </div>
            <p class="small" style="margin:10px 0 0">
              Exclusive = VAT added at checkout summary.<br>
              Inclusive = prices treated as VAT included (breakdown shown).
            </p>

            <div class="hr"></div>

            <h3 style="margin:0 0 10px">Order Summary</h3>
            <div class="sumLine"><span>Subtotal</span> <b id="sumSubtotal">KSh 0</b></div>
            <div class="sumLine"><span>VAT</span> <b id="sumVat">KSh 0</b></div>
            <div class="sumLine"><span>Total</span> <b id="sumTotal">KSh 0</b></div>

            <div class="hr"></div>

            <a class="btn primary full" href="checkout.php">Proceed to Checkout</a>
            <div style="height:10px"></div>
            <a class="btn outline full" href="shop.php">Continue Shopping</a>

            <div style="height:10px"></div>
            <div class="small">
              Need help? <a href="contact.php" style="color:var(--magenta);font-weight:900">Contact sales</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<div class="toast" id="toast"></div>

<script>
/* =========================
   CART STORAGE
========================= */
const VAT_RATE = 0.16;
const CART_KEY = "afritech_cart_v1";
const VAT_MODE_KEY = "afritech_vat_mode_v1"; // 'exclusive' | 'inclusive'

function loadCart(){ try{return JSON.parse(localStorage.getItem(CART_KEY))||[];}catch{return [];} }
function saveCart(items){ localStorage.setItem(CART_KEY, JSON.stringify(items)); render(); }
function cartCount(){ return loadCart().reduce((s,i)=>s+(i.qty||0),0); }
function fmtKES(n){ return "KSh " + Number(n).toLocaleString("en-KE",{maximumFractionDigits:0}); }

function getVatMode(){ return localStorage.getItem(VAT_MODE_KEY) || "exclusive"; }
function setVatMode(mode){ localStorage.setItem(VAT_MODE_KEY, mode); }

function toast(msg){
  const t=document.getElementById("toast");
  t.textContent=msg;
  t.style.opacity="1";
  clearTimeout(window.__toastTimer);
  window.__toastTimer=setTimeout(()=>t.style.opacity="0",1300);
}

function computeTotals(items, mode){
  const subtotal = items.reduce((s,i)=> s + i.unitPrice*i.qty, 0);

  if(mode === "inclusive"){
    const base = subtotal / (1 + VAT_RATE);
    const vat = subtotal - base;
    return { subtotalShown: subtotal, vat, total: subtotal, mode };
  }
  const vat = subtotal * VAT_RATE;
  return { subtotalShown: subtotal, vat, total: subtotal + vat, mode };
}

function updateCartPill(totals){
  document.getElementById("cartCount").textContent = String(cartCount());
  document.getElementById("cartTotalPill").textContent = fmtKES(totals.total || 0);
}

function render(){
  const root = document.getElementById("cartRoot");
  const items = loadCart();
  const mode = getVatMode();
  const totals = computeTotals(items, mode);

  // VAT toggle UI
  const excl = document.getElementById("vatExcl");
  const incl = document.getElementById("vatIncl");
  excl.classList.toggle("active", mode==="exclusive");
  incl.classList.toggle("active", mode==="inclusive");

  // Summary
  document.getElementById("sumSubtotal").textContent = fmtKES(totals.subtotalShown || 0);
  document.getElementById("sumVat").textContent = fmtKES(totals.vat || 0);
  document.getElementById("sumTotal").textContent = fmtKES(totals.total || 0);

  updateCartPill(totals);

  if(items.length === 0){
    root.innerHTML = `
      <div class="card">
        <div class="pad empty">
          <h2 style="margin:0 0 10px">Your cart is empty</h2>
          <p class="small">Browse products and add items to your cart.</p>
          <a class="btn primary" href="shop.php">Go to Shop</a>
        </div>
      </div>
    `;
    return;
  }

  root.innerHTML = `
    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th>Item</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Line Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          ${items.map(i=>`
            <tr>
              <td>
                <div class="itemCell">
                  <img class="itemImg" src="${i.image || ''}" alt="">
                  <div>
                    <div class="itemName">${escapeHtml(i.name)}</div>
                    <div class="itemMeta">${escapeHtml(i.sizeLabel)}</div>
                  </div>
                </div>
              </td>
              <td style="font-weight:950">${fmtKES(i.unitPrice)}</td>
              <td>
                <div class="qty">
                  <button type="button" data-dec="${i.key}">-</button>
                  <span>${i.qty}</span>
                  <button type="button" data-inc="${i.key}">+</button>
                </div>
              </td>
              <td style="font-weight:950">${fmtKES(i.unitPrice * i.qty)}</td>
              <td>
                <button class="iconBtn" type="button" title="Remove" data-remove="${i.key}">✕</button>
              </td>
            </tr>
          `).join("")}
        </tbody>
      </table>
      <div class="pad">
        <div class="small">
          Prices shown • VAT optional • Delivery cost confirmed after checkout
        </div>
      </div>
    </div>
  `;

  // Qty +/-
  root.querySelectorAll("[data-inc]").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      const key = btn.getAttribute("data-inc");
      const cart = loadCart();
      const it = cart.find(x=>x.key===key);
      if(!it) return;
      it.qty += 1;
      saveCart(cart);
    });
  });

  root.querySelectorAll("[data-dec]").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      const key = btn.getAttribute("data-dec");
      const cart = loadCart();
      const it = cart.find(x=>x.key===key);
      if(!it) return;
      it.qty = Math.max(1, it.qty - 1);
      saveCart(cart);
    });
  });

  // Remove
  root.querySelectorAll("[data-remove]").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      const key = btn.getAttribute("data-remove");
      const cart = loadCart().filter(x=>x.key!==key);
      saveCart(cart);
      toast("Removed item");
    });
  });
}

function escapeHtml(str){
  return (str||"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;");
}

/* VAT toggle handlers */
document.getElementById("vatExcl").addEventListener("click", ()=>{
  setVatMode("exclusive");
  render();
});
document.getElementById("vatIncl").addEventListener("click", ()=>{
  setVatMode("inclusive");
  render();
});

render();
</script>

</body>
</html>
