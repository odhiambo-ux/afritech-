<?php
include 'config/database.php';
?>
<?php
if (!isset($_GET['id'])) {
    die("Product not found.");
}

$id = (int)$_GET['id'];

$sql = "SELECT p.*, c.category_name
        FROM products p
        LEFT JOIN categories c
        ON p.category_id = c.id
        WHERE p.id = $id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Product not found.");
}


$product = mysqli_fetch_assoc($result);
// Get sizes for this product
$size_sql = "SELECT id, size, price, stock
             FROM product_sizes
             WHERE product_id = $id
             ORDER BY id ASC";

$size_result = mysqli_query($conn, $size_sql);

$sizes = [];

while ($size_row = mysqli_fetch_assoc($size_result)) {
    $sizes[] = [
    "id" => (int)$size_row["id"],
    "label" => $size_row["size"],
    "price" => (int)$size_row["price"],
    "stock" => (int)$size_row["stock"]
];
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AfriTech — Product</title>

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
.btn.cyan{background:var(--cyan);color:#0b2a3a}
.btn.yellow{background:var(--yellow);color:#2a2500}
.btn.outline{background:#fff;border:1px solid var(--line)}
.btn.outline:hover{border-color:#cfd4dc}
.btn.full{width:100%}

/* PAGE */
.header{padding:18px 0 10px}
.breadcrumb{color:var(--muted);font-size:13px}
.page{
  padding:10px 0 40px;
}
.row{display:flex;gap:18px;align-items:flex-start}
.col{flex:1}
.card{
  background:#fff;border:1px solid var(--line);
  border-radius:var(--radius);box-shadow:var(--shadow);
  overflow:hidden;
}
.pad{padding:16px}
.h1{margin:0 0 6px;font-size:26px}
.small{color:var(--muted);font-size:13px;line-height:1.55}
.bigPrice{font-size:24px;font-weight:950;margin:0}
.badges{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px}
.badge{
  background:#fff;border:1px solid var(--line);
  padding:8px 12px;border-radius:999px;font-weight:850;
  display:inline-flex;align-items:center;gap:8px;font-size:12px;
}
.dot{width:10px;height:10px;border-radius:50%}
.dot.c{background:var(--cyan)}
.dot.m{background:var(--magenta)}
.dot.y{background:var(--yellow)}
.dot.k{background:#000}

.productImg{
  height:420px;background:#fff;
  display:flex;align-items:center;justify-content:center;
}
.productImg img{height:360px;object-fit:contain}

.pills{display:flex;gap:6px;flex-wrap:wrap}
.pillMini{
  padding:6px 10px;border-radius:999px;border:1px solid var(--line);
  background:#fff;font-weight:900;font-size:12px;cursor:pointer;
}
.pillMini.active{border-color:rgba(230,0,126,.35);box-shadow:0 8px 18px rgba(230,0,126,.10)}

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

.split{
  display:grid;grid-template-columns:1fr 1fr;gap:12px;
}

.sectionTitle{margin:0 0 10px;font-size:16px}
.hr{height:1px;background:var(--line);margin:12px 0}

.grid4{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.relImg{
  height:140px;background:#fff;border-bottom:1px solid var(--line);
  display:flex;align-items:center;justify-content:center;
}
.relImg img{height:120px;object-fit:contain}
.relTitle{margin:0;font-size:14px}
.note{margin-top:8px;font-size:12px;color:var(--muted)}

.toast{
  position:fixed;bottom:18px;left:50%;transform:translateX(-50%);
  background:rgba(17,17,17,.92);color:#fff;padding:12px 14px;border-radius:14px;
  box-shadow:0 10px 30px rgba(0,0,0,.25);opacity:0;transition:opacity .2s;
  z-index:999;
}

@media(max-width:1000px){
  .row{flex-direction:column}
  .grid4{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:620px){
  .grid4{grid-template-columns:1fr}
  .split{grid-template-columns:1fr}
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

<!-- CONTENT -->
<div class="container header">
  <div class="breadcrumb" id="breadcrumb">Loading…</div>
</div>

<div class="container page" id="root"></div>

<div class="toast" id="toast"></div>

<script>
/* =========================
   PRODUCT DATA (same as shop)
========================= */
const VAT_RATE = 0.16;
const AFRITECH_PHONE = "+254712345678"; // change later

const PRODUCTS = [{

    id: "<?php echo $product['id']; ?>",

    name: "<?php echo addslashes($product['product_name']); ?>",

    category: "<?php echo strtolower(str_replace(' ','-',$product['category_name'])); ?>",

    short: "<?php echo addslashes($product['description']); ?>",

    details: "<?php echo addslashes($product['description']); ?>",

    dilution: "",

    safety: "",

    sizes: <?php echo json_encode($sizes); ?>,

    image:"<?php echo $product['image']; ?>",

    stock: <?php echo ((int)$product['Stock'] > 0) ? 'true' : 'false'; ?>

}];
/* =========================
   CART (localStorage)
========================= */
const CART_KEY = "afritech_cart_v1";
const VAT_MODE_KEY = "afritech_vat_mode_v1"; // 'exclusive' | 'inclusive'
const getVatMode = () => localStorage.getItem(VAT_MODE_KEY) || "exclusive";

function loadCart(){ try{return JSON.parse(localStorage.getItem(CART_KEY))||[];}catch{return [];} }
function saveCart(items){ localStorage.setItem(CART_KEY, JSON.stringify(items)); updateCartUI(); }
function cartCount(){ return loadCart().reduce((s,i)=>s+(i.qty||0),0); }
function fmtKES(n){ return "KSh " + Number(n).toLocaleString("en-KE",{maximumFractionDigits:0}); }
function computeTotals(items){
  const subtotal = items.reduce((s,i)=> s + i.unitPrice*i.qty, 0);
  const mode = getVatMode();
  if(mode==="inclusive"){
    const base = subtotal/(1+VAT_RATE);
    const vat = subtotal-base;
    return { total: subtotal, vat, base };
  }
  const vat = subtotal*VAT_RATE;
  return { total: subtotal+vat, vat, base: subtotal };
}
function toast(msg){
  const t=document.getElementById("toast");
  t.textContent=msg;
  t.style.opacity="1";
  clearTimeout(window.__toastTimer);
  window.__toastTimer=setTimeout(()=>t.style.opacity="0",1300);
}
function addToCart(productId, sizeLabel, qty=1){
    const p = PRODUCTS.find(x => x.id === productId);
    if(!p) return;

    const size = p.sizes.find(s => s.label === sizeLabel) || p.sizes[0];

    const key = productId + "__" + size.id;

    const cart = loadCart();
    const existing = cart.find(i => i.key === key);

    if(existing){
        existing.qty += qty;
    } else {
        cart.push({
            key,
            productId,
            sizeId: size.id,
            name: p.name,
            image: p.image,
            sizeLabel: size.label,
            unitPrice: size.price,
            qty
        });
    }

    saveCart(cart);
    toast("Added to cart");
}
function updateCartUI(){
  document.getElementById("cartCount").textContent = String(cartCount());
  const totals = computeTotals(loadCart());
  document.getElementById("cartTotalPill").textContent = fmtKES(totals.total || 0);
}

/* =========================
   PAGE LOGIC
========================= */
function getQueryParam(name){
  const url = new URL(window.location.href);
  return url.searchParams.get(name);
}
function prettyCat(cat){
  return ({
    "plate-cleaners":"Plate Cleaners",
    "fountain-solutions":"Fountain Solutions",
    "gum-finishing":"Gum Arabic & Finishing"
  })[cat] || "Shop";
}
function escapeHtml(str){
  return (str||"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;");
}
function sanitizePhone(p){
  // wa.me needs digits only
  return (p||"").replace(/[^\d]/g,"");
}

function render(){
  updateCartUI();

  const id = getQueryParam("id");
  const p = PRODUCTS.find(x=>x.id===id);
  const root = document.getElementById("root");

  if(!p){
    document.getElementById("breadcrumb").textContent = "Product not found";
    root.innerHTML = `
      <div class="card">
        <div class="pad">
          <h2 style="margin:0 0 8px">Product not found</h2>
          <p class="small">The product ID is missing or invalid.</p>
          <a class="btn primary" href="shop.php">Back to Shop</a>
        </div>
      </div>`;
    return;
  }

  document.getElementById("breadcrumb").innerHTML =
    `<a href="index.php">Home</a> ›
     <a href="shop.php?category=${encodeURIComponent(p.category)}">${prettyCat(p.category)}</a> ›
     ${escapeHtml(p.name)}`;

  let selected = p.sizes[0];
  let qty = 1;

  const related = PRODUCTS.filter(x=>x.id!==p.id).slice(0,4);

  root.innerHTML = `
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="productImg">
            <img src="${p.image}" alt="${escapeHtml(p.name)}">
          </div>
        </div>
        <div style="height:14px"></div>

        <div class="card">
          <div class="pad">
            <h3 class="sectionTitle">Product Details</h3>
            <div class="small">${escapeHtml(p.details || "")}</div>
            <div class="hr"></div>
            <h3 class="sectionTitle">Dilution & Directions</h3>
            <div class="small">${escapeHtml(p.dilution || "")}</div>
            <div class="hr"></div>
            <h3 class="sectionTitle">Safety & SDS</h3>
            <div class="small">${escapeHtml(p.safety || "")}</div>
            <div style="height:10px"></div>
                     </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <div class="pad">
            <h1 class="h1">${escapeHtml(p.name)}</h1>
            <div class="small">${escapeHtml(p.short)}</div>

            <div class="badges">
              <span class="badge"><span class="dot c"></span> Countrywide Delivery</span>
              <span class="badge"><span class="dot m"></span> SDS Available</span>
              <span class="badge"><span class="dot y"></span> Bulk Pricing</span>
              <span class="badge"><span class="dot k"></span> ${p.stock ? "In stock" : "Out of stock"}</span>
            </div>

            <div class="hr"></div>

            <div style="display:flex;justify-content:space-between;align-items:baseline;gap:10px;flex-wrap:wrap">
              <div>
                <div class="small">Selected size</div>
                <div style="font-weight:950;font-size:16px" id="selSize">${selected.label}</div>
              </div>
              <div style="text-align:right">
                <div class="small">Price</div>
                <p class="bigPrice" id="selPrice">${fmtKES(selected.price)}</p>
              </div>
            </div>

            <div style="height:10px"></div>
            <div class="pills" id="sizePills">
              ${p.sizes.map((s,idx)=>`
                <button class="pillMini ${idx===0?"active":""}" type="button" data-size="${s.label}" data-price="${s.price}">
                  ${s.label}
                </button>`).join("")}
            </div>

            <div style="height:12px"></div>
            <div class="split">
              <div>
                <div class="small">Quantity</div>
                <div style="height:6px"></div>
                <div class="qty">
                  <button type="button" id="minus">-</button>
                  <span id="qty">${qty}</span>
                  <button type="button" id="plus">+</button>
                </div>
                <div class="note">VAT optional at checkout.</div>
              </div>
              <div>
                <div class="small">Action</div>
                <div style="height:6px"></div>
                <button class="btn primary full" type="button" id="addBtn">Add to Cart</button>
              </div>
            </div>

            <div style="height:12px"></div>
            <div class="split">
              <a class="btn cyan full" id="waBtn" href="#" target="_blank" rel="noopener">WhatsApp Order</a>
              <a class="btn outline full" href="contact.php">Talk to Sales</a>
            </div>

            <div style="height:12px"></div>
            <div class="card" style="box-shadow:none">
              <div class="pad">
                <div class="small">
                  <b>Delivery:</b> Countrywide (cost confirmed after checkout).<br>
                  <b>Procurement:</b> We can issue proforma invoice on request.
                </div>
              </div>
            </div>

          </div>
        </div>

        <div style="height:14px"></div>

        <div class="card">
          <div class="pad">
            <h3 class="sectionTitle">Related Products</h3>
            <div class="grid4">
              ${related.map(r=>`
                <div class="card" style="box-shadow:none">
                  <a href="product.html?id=${encodeURIComponent(r.id)}">
                    <div class="relImg"><img src="${r.image}" alt="${escapeHtml(r.name)}"></div>
                  </a>
                  <div class="pad">
                    <a href="product.html?id=${encodeURIComponent(r.id)}">
                      <p class="relTitle"><b>${escapeHtml(r.name)}</b></p>
                      <div class="small">${escapeHtml(r.short)}</div>
                    </a>
                    <div style="height:10px"></div>
                    <a class="btn outline full" href="product.php?id=${encodeURIComponent(r.id)}">View</a>
                  </div>
                </div>
              `).join("")}
            </div>
          </div>
        </div>

      </div>
    </div>
  `;

  // Interactions
  const pills = document.getElementById("sizePills");
  const selSize = document.getElementById("selSize");
  const selPrice = document.getElementById("selPrice");
  const qtyEl = document.getElementById("qty");

  function updateWhatsApp(){
    const msg =
      `Hi AfriTech, I want to order:\n`+
      `${p.name}\n`+
      `Size: ${selected.label}\n`+
      `Qty: ${qty}\n`+
      `Please confirm delivery cost (countrywide) and payment details.`;
    document.getElementById("waBtn").href =
      `https://wa.me/${sanitizePhone(AFRITECH_PHONE)}?text=${encodeURIComponent(msg)}`;
  }

  pills.addEventListener("click", (e)=>{
    const b = e.target.closest("[data-size]");
    if(!b) return;

    // active style
    pills.querySelectorAll(".pillMini").forEach(x=>x.classList.remove("active"));
    b.classList.add("active");

    selected = p.sizes.find(
    s => s.label === b.getAttribute("data-size")
) || p.sizes[0];

selSize.textContent = selected.label;
selPrice.textContent = fmtKES(selected.price);
updateWhatsApp();
    selSize.textContent = selected.label;
    selPrice.textContent = fmtKES(selected.price);
    updateWhatsApp();
  });

  document.getElementById("minus").addEventListener("click", ()=>{
    qty = Math.max(1, qty-1);
    qtyEl.textContent = qty;
    updateWhatsApp();
  });
  document.getElementById("plus").addEventListener("click", ()=>{
    qty = qty + 1;
    qtyEl.textContent = qty;
    updateWhatsApp();
  });
  document.getElementById("addBtn").addEventListener("click", ()=>{
    addToCart(p.id, selected.label, qty);
  });

  updateWhatsApp();
}

render();
</script>

</body>
</html>
