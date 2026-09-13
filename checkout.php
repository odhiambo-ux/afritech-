<?php
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $total = $data['totals']['total'] ?? 0;
    $status = "Pending";
    $user_id = $_SESSION['user_id'] ?? null;

    $stmt = $conn->prepare(
        "INSERT INTO orders (user_id, total, status, order_date)
         VALUES (?, ?, ?, NOW())"
    );

    $stmt->bind_param("ids", $user_id, $total, $status);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "order_id" => $stmt->insert_id
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => $stmt->error
        ]);
    }

    $stmt->close();
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AfriTech — Checkout</title>

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

/* BUTTONS */
.btn{
  padding:12px 16px;border-radius:14px;font-weight:900;border:none;cursor:pointer;
  display:inline-flex;align-items:center;justify-content:center;gap:10px;
}
.btn.primary{background:var(--magenta);color:#fff}
.btn.primary:hover{opacity:.92}
.btn.outline{background:#fff;border:1px solid var(--line)}
.btn.outline:hover{border-color:#cfd4dc}
.btn.cyan{background:var(--cyan);color:#0b2a3a}
.btn.full{width:100%}

/* PAGE */
.header{padding:18px 0 10px}
.h1{margin:0;font-size:28px}
.small{color:var(--muted);font-size:13px;line-height:1.55}

.row{display:flex;gap:18px;align-items:flex-start}
.col{flex:1}
.sidebar{width:380px;min-width:320px}

.card{
  background:#fff;border:1px solid var(--line);
  border-radius:var(--radius);box-shadow:var(--shadow);
  overflow:hidden;
}
.pad{padding:16px}
.hr{height:1px;background:var(--line);margin:12px 0}

.input, select, textarea{
  width:100%;
  padding:12px 12px;
  border-radius:14px;
  border:1px solid var(--line);
  background:#fff;
  outline:none;
  font-size:14px;
}
textarea{min-height:110px;resize:vertical}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.grid1{display:grid;grid-template-columns:1fr;gap:12px}

.notice{
  padding:12px 14px;border-radius:16px;
  border:1px dashed rgba(230,0,126,.28);
  background:rgba(230,0,126,.06);
  color:#3b0a22;
  font-weight:850;
}

.sumLine{display:flex;justify-content:space-between;gap:10px;margin:8px 0}
.sumLine b{font-weight:950}
.itemLine{display:flex;justify-content:space-between;gap:10px}
.itemLine small{color:var(--muted)}

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

.toast{
  position:fixed;bottom:18px;left:50%;transform:translateX(-50%);
  background:rgba(17,17,17,.92);color:#fff;padding:12px 14px;border-radius:14px;
  box-shadow:0 10px 30px rgba(0,0,0,.25);opacity:0;transition:opacity .2s;
  z-index:999;
}

@media(max-width:1000px){
  .row{flex-direction:column}
  .sidebar{width:100%}
  .grid2{grid-template-columns:1fr}
}
</style>
</head>

<body>

<!-- NAV -->
<div class="topbar">
  <div class="container nav">
    <a class="brand" href="index.html"><img src="logo.png" alt="AfriTech"></a>

    <div class="menu">
      <a href="index.php">Home</a>
      <a href="shop.php">Shop</a>
      <a href="cart.php">Cart</a>
      <a href="contact.php">Contact</a>
    </div>

    <div class="actions">
      <a class="pill" href="cart.php" title="Cart">
        🛒 <span id="cartTotalPill">KSh 0</span> • <span id="cartCount">0</span>
      </a>
    </div>
  </div>
</div>

<!-- HEADER -->
<section class="header">
  <div class="container">
    <h1 class="h1">Checkout</h1>
    <p class="small">Enter delivery details. We’ll confirm delivery cost and payment instructions after you place the order.</p>
  </div>
</section>

<section style="padding: 0 0 40px;">
  <div class="container">
    <div class="row">

      <!-- FORM -->
      <div class="col" id="leftCol">
        <div class="card">
          <div class="pad">
            <div class="notice">Countrywide delivery • Delivery cost confirmed after checkout</div>

            <div class="hr"></div>
            <h3 style="margin:0 0 10px">Company & Contact</h3>

            <form id="checkoutForm">
              <div class="grid2">
                <div>
                  <label class="small">Company Name</label>
                  <input class="input" name="company" placeholder="e.g., ABC Printers Ltd" required>
                </div>
                <div>
                  <label class="small">Contact Person</label>
                  <input class="input" name="contact" placeholder="Full name" required>
                </div>
              </div>

              <div style="height:10px"></div>

              <div class="grid2">
                <div>
                  <label class="small">Phone</label>
                  <input class="input" name="phone" placeholder="+2547..." required>
                </div>
                <div>
                  <label class="small">Email (optional)</label>
                  <input class="input" name="email" placeholder="procurement@company.com">
                </div>
              </div>

              <div class="hr"></div>

              <h3 style="margin:0 0 10px">Delivery Address</h3>

              <div class="grid2">
                <div>
                  <label class="small">County</label>
                  <input class="input" name="county" placeholder="e.g., Nairobi" required>
                </div>
                <div>
                  <label class="small">Town</label>
                  <input class="input" name="town" placeholder="e.g., Industrial Area" required>
                </div>
              </div>

              <div style="height:10px"></div>

              <div class="grid1">
                <div>
                  <label class="small">Delivery Address / Landmark</label>
                  <textarea class="input" name="address" placeholder="Street / Building / Landmark" required></textarea>
                </div>
              </div>

              <div class="hr"></div>

              <h3 style="margin:0 0 10px">VAT (Optional)</h3>
              <div class="toggleRow">
                <button class="toggle" id="vatExcl" type="button">VAT Exclusive</button>
                <button class="toggle" id="vatIncl" type="button">VAT Inclusive</button>
              </div>

              <div style="height:10px"></div>

              <div class="grid2">
                <div>
                  <label class="small">VAT PIN (optional)</label>
                  <input class="input" name="vatpin" placeholder="Pxxxxxxx">
                </div>
                <div>
                  <label class="small">Order Notes (optional)</label>
                  <input class="input" name="notes" placeholder="e.g., Need proforma invoice">
                </div>
              </div>

              <div class="hr"></div>

              <button class="btn primary full" type="submit">Place Order</button>
              <div style="height:10px"></div>
              <a class="btn outline full" href="cart.html">Back to Cart</a>
            </form>
          </div>
        </div>
      </div>

      <!-- SUMMARY -->
      <div class="sidebar" id="summaryCol">
        <div class="card">
          <div class="pad">
            <h3 style="margin:0 0 10px">Order Summary</h3>
            <div id="items"></div>

            <div class="hr"></div>

            <div class="sumLine"><span>Subtotal</span> <b id="sumSubtotal">KSh 0</b></div>
            <div class="sumLine"><span>VAT</span> <b id="sumVat">KSh 0</b></div>
            <div class="sumLine"><span>Total</span> <b id="sumTotal">KSh 0</b></div>

            <div class="hr"></div>

            <a class="btn cyan full" id="waConfirm" href="#" target="_blank" rel="noopener">WhatsApp Confirm</a>
            <div style="height:10px"></div>
            <div class="small">This sends your order summary to AfriTech on WhatsApp for faster confirmation.</div>
          </div>
        </div>

        <div style="height:14px"></div>

        <div class="card">
          <div class="pad">
            <div class="small">
              <b>Payment:</b> Confirmed after order (M-Pesa / bank).<br>
              <b>Delivery:</b> Countrywide (fee confirmed after checkout).<br>
              <b>SDS:</b> Available on request.
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
   CONFIG
========================= */
const VAT_RATE = 0.16;
const CART_KEY = "afritech_cart_v1";
const VAT_MODE_KEY = "afritech_vat_mode_v1";
const ORDERS_KEY = "afritech_orders_v1";
const AFRITECH_PHONE = "+254712345678"; // <-- change to your WhatsApp number

/* =========================
   HELPERS
========================= */
function loadCart(){ try{return JSON.parse(localStorage.getItem(CART_KEY))||[];}catch{return [];} }
function saveCart(items){ localStorage.setItem(CART_KEY, JSON.stringify(items)); }
function clearCart(){ localStorage.removeItem(CART_KEY); }

function cartCount(){ return loadCart().reduce((s,i)=>s+(i.qty||0),0); }
function fmtKES(n){ return "KSh " + Number(n).toLocaleString("en-KE",{maximumFractionDigits:0}); }

function getVatMode(){ return localStorage.getItem(VAT_MODE_KEY) || "exclusive"; }
function setVatMode(mode){ localStorage.setItem(VAT_MODE_KEY, mode); render(); }

function toast(msg){
  const t=document.getElementById("toast");
  t.textContent=msg;
  t.style.opacity="1";
  clearTimeout(window.__toastTimer);
  window.__toastTimer=setTimeout(()=>t.style.opacity="0",1300);
}
function sanitizePhone(p){ return (p||"").replace(/[^\d]/g,""); }

function computeTotals(items, mode){
  const subtotal = items.reduce((s,i)=> s + i.unitPrice*i.qty, 0);

  if(mode === "inclusive"){
    const base = subtotal/(1+VAT_RATE);
    const vat = subtotal - base;
    return { subtotalShown: subtotal, vat, total: subtotal, mode };
  }
  const vat = subtotal*VAT_RATE;
  return { subtotalShown: subtotal, vat, total: subtotal+vat, mode };
}

function makeOrderNumber(){
  // e.g. AF-240219-8392
  const d = new Date();
  const y = String(d.getFullYear()).slice(-2);
  const m = String(d.getMonth()+1).padStart(2,"0");
  const day = String(d.getDate()).padStart(2,"0");
  const rnd = Math.floor(1000 + Math.random()*9000);
  return `AF-${y}${m}${day}-${rnd}`;
}

async function saveOrder(order) {

    const response = await fetch("checkout.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(order)
    });

    const result = await response.json();

    if (!result.success) {
        throw new Error(result.message || "Failed to save order");
    }

    return result;
}
/* =========================
   RENDER
========================= */
function render(){
  const items = loadCart();
  if(items.length === 0){
    document.getElementById("leftCol").innerHTML = `
      <div class="card"><div class="pad">
        <h2 style="margin:0 0 10px">Cart is empty</h2>
        <p class="small">Add items to cart before checkout.</p>
        <a class="btn primary" href="shop.html">Go to Shop</a>
      </div></div>
    `;
    document.getElementById("summaryCol").style.display = "none";
    return;
  }

  // VAT toggle UI
  const mode = getVatMode();
  const excl = document.getElementById("vatExcl");
  const incl = document.getElementById("vatIncl");
  excl.classList.toggle("active", mode==="exclusive");
  incl.classList.toggle("active", mode==="inclusive");

  // Cart pill
  const totals = computeTotals(items, mode);
  document.getElementById("cartCount").textContent = String(cartCount());
  document.getElementById("cartTotalPill").textContent = fmtKES(totals.total || 0);

  // Items summary
  const itemsWrap = document.getElementById("items");
  itemsWrap.innerHTML = items.map(i => `
    <div class="itemLine" style="margin:8px 0">
      <div>
        <b>${escapeHtml(i.name)}</b><br>
        <small>${escapeHtml(i.sizeLabel)} • Qty ${i.qty}</small>
      </div>
      <div><b>${fmtKES(i.unitPrice*i.qty)}</b></div>
    </div>
  `).join("");

  // Totals
  document.getElementById("sumSubtotal").textContent = fmtKES(totals.subtotalShown || 0);
  document.getElementById("sumVat").textContent = fmtKES(totals.vat || 0);
  document.getElementById("sumTotal").textContent = fmtKES(totals.total || 0);

  // WhatsApp confirm link (updated after typing form too)
  updateWhatsAppConfirm();
}

function escapeHtml(str){
  return (str||"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;");
}

/* =========================
   WhatsApp confirm
========================= */
function updateWhatsAppConfirm(){
  const form = document.getElementById("checkoutForm");
  if(!form) return;

  const fd = new FormData(form);
  const company = (fd.get("company")||"").toString().trim();
  const contact = (fd.get("contact")||"").toString().trim();
  const phone = (fd.get("phone")||"").toString().trim();
  const county = (fd.get("county")||"").toString().trim();
  const town = (fd.get("town")||"").toString().trim();

  const mode = getVatMode();
  const items = loadCart();
  const totals = computeTotals(items, mode);

  const lines = items.map(i => `- ${i.name} (${i.sizeLabel}) x${i.qty} = ${fmtKES(i.unitPrice*i.qty)}`).join("\n");

  const msg =
    `Hi AfriTech, please confirm my order:\n` +
    `${company ? "Company: " + company + "\n" : ""}` +
    `${contact ? "Contact: " + contact + "\n" : ""}` +
    `${phone ? "Phone: " + phone + "\n" : ""}` +
    `${county || town ? "Delivery: " + [town, county].filter(Boolean).join(", ") + "\n" : ""}` +
    `VAT Mode: ${mode.toUpperCase()}\n\n` +
    `Items:\n${lines}\n\n` +
    `Total: ${fmtKES(totals.total)}`;

  document.getElementById("waConfirm").href =
    `https://wa.me/${sanitizePhone(AFRITECH_PHONE)}?text=${encodeURIComponent(msg)}`;
}

/* =========================
   Events
========================= */
document.getElementById("vatExcl").addEventListener("click", ()=> setVatMode("exclusive"));
document.getElementById("vatIncl").addEventListener("click", ()=> setVatMode("inclusive"));

document.getElementById("checkoutForm").addEventListener("input", ()=>{
  updateWhatsAppConfirm();
});

document.getElementById("checkoutForm").addEventListener("submit", (e)=>{
  e.preventDefault();

  const items = loadCart();
  if(items.length === 0){
    toast("Cart is empty");
    return;
  }

  const mode = getVatMode();
  const totals = computeTotals(items, mode);
  const fd = new FormData(e.target);
  const data = Object.fromEntries(fd.entries());

  // Basic validation already handled by required fields
  const orderNumber = makeOrderNumber();

  const order = {
    orderNumber,
    createdAt: new Date().toISOString(),
    vatMode: mode,
    vatRate: VAT_RATE,
    customer: {
      company: data.company,
      contact: data.contact,
      phone: data.phone,
      email: data.email || "",
      county: data.county,
      town: data.town,
      address: data.address,
      vatpin: data.vatpin || "",
      notes: data.notes || ""
    },
    items,
    totals: {
      subtotal: totals.subtotalShown,
      vat: totals.vat,
      total: totals.total
    }
  };

saveOrder(order)
  .then(() => {
    clearCart();
  })
  .catch(error => {
    console.error(error);
    alert("Failed to save order: " + error.message);
  });
  toast("Order placedsave!");

  // redirect to success
  window.location.href = `success.php?order=${encodeURIComponent(orderNumber)}`;
});

render();
</script>

</body>
</html>
