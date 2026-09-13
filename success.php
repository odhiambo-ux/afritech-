<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AfriTech — Order Success</title>

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
.container{max-width:920px;margin:auto;padding:0 20px}

/* NAV */
.topbar{background:#fff;border-bottom:1px solid var(--line);position:sticky;top:0;z-index:100}
.nav{display:flex;justify-content:space-between;align-items:center;padding:14px 0;gap:18px}
.brand img{height:40px}
.menu{display:flex;gap:18px;align-items:center;flex-wrap:wrap}
.menu a{font-weight:650}
.menu a:hover{color:var(--magenta)}

/* BUTTONS */
.btn{
  padding:12px 16px;border-radius:14px;font-weight:900;border:none;cursor:pointer;
  display:inline-flex;align-items:center;justify-content:center;gap:10px;
}
.btn.primary{background:var(--magenta);color:#fff}
.btn.primary:hover{opacity:.92}
.btn.cyan{background:var(--cyan);color:#0b2a3a}
.btn.outline{background:#fff;border:1px solid var(--line)}
.btn.outline:hover{border-color:#cfd4dc}
.btn.full{width:100%}

/* PAGE */
.page{padding:26px 0 40px}
.card{
  background:#fff;border:1px solid var(--line);
  border-radius:24px;box-shadow:var(--shadow);
  overflow:hidden;
}
.pad{padding:18px}
.h1{margin:0 0 8px;font-size:28px}
.small{color:var(--muted);font-size:13px;line-height:1.55}
.hr{height:1px;background:var(--line);margin:12px 0}

.badgeRow{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px}
.badge{
  background:#fff;border:1px solid var(--line);
  padding:8px 12px;border-radius:999px;font-weight:900;
  display:inline-flex;align-items:center;gap:8px;font-size:12px;
}
.dot{width:10px;height:10px;border-radius:50%}
.dot.c{background:var(--cyan)}
.dot.m{background:var(--magenta)}
.dot.y{background:var(--yellow)}
.dot.k{background:#000}

.itemLine{display:flex;justify-content:space-between;gap:10px;margin:10px 0}
.itemLine small{color:var(--muted)}
.sumLine{display:flex;justify-content:space-between;gap:10px;margin:8px 0}
.sumLine b{font-weight:950}

.grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.notice{
  padding:12px 14px;border-radius:16px;
  border:1px dashed rgba(230,0,126,.28);
  background:rgba(230,0,126,.06);
  color:#3b0a22;
  font-weight:900;
}

@media(max-width:680px){
  .grid2{grid-template-columns:1fr}
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
  </div>
</div>

<!-- CONTENT -->
<div class="container page">
  <div class="card">
    <div class="pad" id="root">
      Loading…
    </div>
  </div>
</div>

<script>
const ORDERS_KEY = "afritech_orders_v1";
const AFRITECH_PHONE = "+254712345678"; // <-- change to your WhatsApp number

function getQueryParam(name){
  const url = new URL(window.location.href);
  return url.searchParams.get(name);
}
function sanitizePhone(p){ return (p||"").replace(/[^\d]/g,""); }
function fmtKES(n){ return "KSh " + Number(n).toLocaleString("en-KE",{maximumFractionDigits:0}); }
function escapeHtml(str){
  return (str||"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;");
}
function loadOrders(){
  try{ return JSON.parse(localStorage.getItem(ORDERS_KEY)) || []; }
  catch{ return []; }
}

function render(){
  const orderNumber = getQueryParam("order");
  const root = document.getElementById("root");

  if(!orderNumber){
    root.innerHTML = `
      <h1 class="h1">Order Complete</h1>
      <p class="small">Order number missing. If you need help, contact AfriTech support.</p>
      <div style="height:10px"></div>
      <a class="btn primary" href="shop.html">Continue Shopping</a>
    `;
    return;
  }

  const order = loadOrders().find(o => o.orderNumber === orderNumber);

  if(!order){
    root.innerHTML = `
      <h1 class="h1">Order received</h1>
      <p class="small">
        Your order number is <b>${escapeHtml(orderNumber)}</b>.
        (We couldn’t load the full summary on this device, but you can still confirm on WhatsApp.)
      </p>

      <div class="badgeRow">
        <span class="badge"><span class="dot c"></span> Countrywide Delivery</span>
        <span class="badge"><span class="dot m"></span> SDS Available</span>
        <span class="badge"><span class="dot y"></span> B2B Support</span>
      </div>

      <div class="hr"></div>

      <a class="btn cyan full" target="_blank" rel="noopener"
         href="https://wa.me/${sanitizePhone(AFRITECH_PHONE)}?text=${encodeURIComponent(
           `Hi AfriTech, I placed an order. Order number: ${orderNumber}. Please confirm delivery cost and payment details.`
         )}">
        Confirm on WhatsApp
      </a>

      <div style="height:12px"></div>
      <div class="grid2">
        <a class="btn primary full" href="shop.php">Continue Shopping</a>
        <a class="btn outline full" href="index.php">Back Home</a>
      </div>
    `;
    return;
  }

  const items = order.items || [];
  const totals = order.totals || { subtotal:0, vat:0, total:0 };
  const mode = (order.vatMode || "exclusive").toUpperCase();

  const lines = items.map(i =>
    `- ${i.name} (${i.sizeLabel}) x${i.qty} = ${fmtKES(i.unitPrice*i.qty)}`
  ).join("\n");

  const customer = order.customer || {};
  const msg =
    `Hi AfriTech, please confirm my order:\n` +
    `Order No: ${order.orderNumber}\n` +
    (customer.company ? `Company: ${customer.company}\n` : "") +
    (customer.contact ? `Contact: ${customer.contact}\n` : "") +
    (customer.phone ? `Phone: ${customer.phone}\n` : "") +
    ((customer.town || customer.county) ? `Delivery: ${(customer.town||"")}${customer.town && customer.county ? ", " : ""}${(customer.county||"")}\n` : "") +
    `VAT Mode: ${mode}\n\n` +
    `Items:\n${lines}\n\n` +
    `Total: ${fmtKES(totals.total)}`;

  const waLink = `https://wa.me/${sanitizePhone(AFRITECH_PHONE)}?text=${encodeURIComponent(msg)}`;

  root.innerHTML = `
    <h1 class="h1">Order placed successfully ✅</h1>
    <p class="small">
      Your order number is <b>${escapeHtml(order.orderNumber)}</b>.
      We’ll confirm delivery cost and payment instructions shortly.
    </p>

    <div class="badgeRow">
      <span class="badge"><span class="dot c"></span> Countrywide Delivery</span>
       <span class="badge"><span class="dot y"></span> Bulk Pricing</span>
      <span class="badge"><span class="dot k"></span> VAT ${mode}</span>
    </div>

    <div class="hr"></div>

    <div class="notice">Tip: Use WhatsApp confirm for faster processing (B2B friendly).</div>

    <div style="height:12px"></div>
    <a class="btn cyan full" href="${waLink}" target="_blank" rel="noopener">Confirm on WhatsApp</a>

    <div style="height:12px"></div>
    <div class="grid2">
      <a class="btn primary full" href="shop.php">Continue Shopping</a>
      <a class="btn outline full" href="index.php">Back Home</a>
    </div>

    <div class="hr"></div>

    <h3 style="margin:0 0 10px">Order Summary</h3>
    ${items.map(i=>`
      <div class="itemLine">
        <div>
          <b>${escapeHtml(i.name)}</b><br>
          <small>${escapeHtml(i.sizeLabel)} • Qty ${i.qty}</small>
        </div>
        <div><b>${fmtKES(i.unitPrice*i.qty)}</b></div>
      </div>
    `).join("")}

    <div class="hr"></div>
    <div class="sumLine"><span>Subtotal</span> <b>${fmtKES(totals.subtotal)}</b></div>
    <div class="sumLine"><span>VAT</span> <b>${fmtKES(totals.vat)}</b></div>
    <div class="sumLine"><span>Total</span> <b>${fmtKES(totals.total)}</b></div>

    <div class="hr"></div>
    <p class="small">
      Need SDS for procurement? <a href="sds.html" style="color:var(--magenta);font-weight:950">Request SDS</a>.
    </p>
  `;
}

render();
</script>

</body>
</html>
