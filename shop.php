<?php
include 'config/database.php';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AfriTech — Shop</title>

<style>
:root{
  --magenta:#E6007E;
  --cyan:#55B7E3;
  --yellow:#F2D200;
  --ink:#1A1A1A;
  --bg:#fff;
  --white:#fff;
  --line:#E4E7EC;
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
.topbar{background:white;border-bottom:1px solid var(--line);position:sticky;top:0;z-index:100}
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
}
.btn.primary{background:var(--magenta);color:#fff}
.btn.primary:hover{opacity:.92}
.btn.outline{background:#fff;border:1px solid var(--line)}
.btn.outline:hover{border-color:#cfd4dc}
.btn.full{width:100%}

/* PAGE HEADER */
.header{
  padding:22px 0 10px;
}
.headerBox{
  background:linear-gradient(120deg,
    rgba(85,183,227,.16),
    rgba(230,0,126,.12),
    rgba(242,210,0,.14)
  );
  border:1px solid var(--line);
  border-radius:24px;
  box-shadow:var(--shadow);
  padding:18px;
  display:flex;
  gap:14px;
  flex-wrap:wrap;
  align-items:center;
  justify-content:space-between;
}
.titleWrap h1{margin:0;font-size:28px}
.titleWrap p{margin:6px 0 0;color:#666}

/* FILTERS */
.filters{
  display:flex;gap:10px;flex-wrap:wrap;align-items:center;
}
.input{
  padding:12px 12px;border-radius:14px;border:1px solid var(--line);
  background:#fff;min-width:240px;outline:none;
}
select.input{min-width:220px}

/* GRID */
.section{padding:18px 0 40px}
.grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:18px;
}
.card{
  background:#fff;border:1px solid var(--line);border-radius:var(--radius);
  box-shadow:var(--shadow);overflow:hidden;
}
.productImg{
  height:170px;background:#fff;
  display:flex;align-items:center;justify-content:center;
  border-bottom:1px solid var(--line);
}
.productImg img{height:150px;object-fit:contain}
.pad{padding:16px}
.h3{margin:0 0 8px;font-size:16px}
.small{color:#667085;font-size:13px;line-height:1.5}
.priceRow{display:flex;justify-content:space-between;align-items:baseline;margin:12px 0 10px}
.price{font-weight:950;font-size:18px}
.stock{font-size:12px;color:#667085;font-weight:800}
.pills{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px}
.pillMini{
  padding:6px 10px;border-radius:999px;border:1px solid var(--line);
  background:#fff;font-weight:900;font-size:12px;cursor:pointer;
}
.pillMini.active{border-color:rgba(230,0,126,.35);box-shadow:0 8px 18px rgba(230,0,126,.10)}
.note{
  margin-top:8px;font-size:12px;color:#667085
}

/* FOOTER */
.footer{background:#fff;border-top:1px solid var(--line);padding:30px 0}
.footerGrid{display:grid;grid-template-columns:2fr 1fr 1fr 2fr;gap:18px}
.footer small{color:#667085}
.footer a:hover{text-decoration:underline}

/* TOAST */
.toast{
  position:fixed;bottom:18px;left:50%;transform:translateX(-50%);
  background:rgba(17,17,17,.92);color:#fff;padding:12px 14px;border-radius:14px;
  box-shadow:0 10px 30px rgba(0,0,0,.25);opacity:0;transition:opacity .2s;
  z-index:999;
}

/* RESPONSIVE */
@media(max-width:1000px){ .grid{grid-template-columns:repeat(2,1fr)} .footerGrid{grid-template-columns:1fr 1fr} }
@media(max-width:620px){ .grid{grid-template-columns:1fr} .input{min-width:100%} .footerGrid{grid-template-columns:1fr} }
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
      <a href="email.php">Email</a>
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

<!-- HEADER + FILTERS -->
<section class="header">
  <div class="container">
    <div class="headerBox">
      <div class="titleWrap">
        <h1 id="pageTitle">Shop</h1>
        <p>Industrial printing chemicals • Prices shown • VAT optional at checkout • Countrywide delivery</p>
      </div>

      <div class="filters">
        <select id="categorySelect" class="input" aria-label="Category">
          <option value="">All Categories</option>
          <option value="plate-cleaners">Plate Cleaners</option>
          <option value="fountain-solutions">Fountain Solutions</option>
          <option value="gum-finishing">Gum Arabic</option>
          <option value="photo-copy">Photocopying</option>
        </select>

        <input id="searchInput" class="input" placeholder="Search products (e.g., plate cleaner, fountain...)" />
        <button id="searchBtn" class="btn outline">Search</button>
        <button id="clearBtn" class="btn outline">Clear</button>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCTS -->
<section class="section">
  <div class="container">
    <div id="grid" class="grid"></div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container footerGrid">
    <div>
      <img src="logo.png" style="height:36px" alt="AfriTech">
      <div style="height:8px"></div>
      <small>Supplying professional printing chemicals across Kenya.</small>
    </div>

    <div>
      <h4>Shop</h4>
      <a href="shop.php"><small>Products</small></a><br>
      <a href="cart.php"><small>Cart</small></a><br>
      <a href="checkout.php"><small>Checkout</small></a>
    </div>

    <div>
      <h4>Safety</h4>
       <a href="contact.php"><small>Support</small></a>
    </div>

    <div>
      <h4>Contact</h4>
      <small>📞 +254 717 088 780</small><br>
      <small>✉ info@afritech.co.ke</small><br>
      <small>📍 Kenya (Countrywide Delivery)</small>
    </div>
  </div>
</footer>

<div class="toast" id="toast"></div>

<script>
/* =========================
   PRODUCT DATA (MVP)
   Later we will load this from SQL/backend.
========================= */
const VAT_RATE = 0.16;

const PRODUCTS = <?php

$products = [];

$sql = "SELECT p.*, c.category_name
        FROM products p
        LEFT JOIN categories c
        ON p.category_id = c.id";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){

$size_sql = "SELECT size, price, stock
             FROM product_sizes
             WHERE product_id = " . (int)$row["id"] . "
             ORDER BY id ASC";

$size_result = mysqli_query($conn, $size_sql);

$sizes = [];

while ($size_row = mysqli_fetch_assoc($size_result)) {
    $sizes[] = [
        "label" => $size_row["size"],
        "price" => (int)$size_row["price"],
        "stock" => (int)$size_row["stock"]
    ];
}

    $products[] = [
        "id" => $row["id"],
        "name" => $row["product_name"],

        "category" => strtolower(str_replace(" ", "-", $row["category_name"])),

        "short" => $row["description"],

        "sizes" => $sizes,

        "image" => $row["image"],

        "stock" => ((int)$row["Stock"] > 0)
    ];
}

echo json_encode($products, JSON_UNESCAPED_SLASHES);

?>;

/* =========================
   CART (localStorage)
========================= */
const CART_KEY = "afritech_cart_v1";
const VAT_MODE_KEY = "afritech_vat_mode_v1"; // 'exclusive' | 'inclusive'
const getVatMode = () => localStorage.getItem(VAT_MODE_KEY) || "exclusive";

function loadCart(){
  try{ return JSON.parse(localStorage.getItem(CART_KEY)) || []; }
  catch{ return []; }
}
function saveCart(items){
  localStorage.setItem(CART_KEY, JSON.stringify(items));
  updateCartUI();
}
function cartCount(){
  return loadCart().reduce((s,i)=>s + (i.qty||0), 0);
}
function fmtKES(n){
  return "KSh " + Number(n).toLocaleString("en-KE", {maximumFractionDigits:0});
}
function computeTotals(items){
  const subtotal = items.reduce((s,i)=> s + i.unitPrice*i.qty, 0);
  const mode = getVatMode();
  if(mode === "inclusive"){
    const base = subtotal / (1 + VAT_RATE);
    const vat = subtotal - base;
    return { total: subtotal, vat, base };
  } else {
    const vat = subtotal * VAT_RATE;
    return { total: subtotal + vat, vat, base: subtotal };
  }
}
function toast(msg){
  const t = document.getElementById("toast");
  t.textContent = msg;
  t.style.opacity = "1";
  clearTimeout(window.__toastTimer);
  window.__toastTimer = setTimeout(()=> t.style.opacity="0", 1300);
}

function addToCart(productId, sizeLabel, qty=1){
  const p = PRODUCTS.find(x=>x.id===productId);
  if(!p) return;
  const size = p.sizes.find(s=>s.label===sizeLabel) || p.sizes[0];
  const key = productId + "__" + size.label;

  const cart = loadCart();
  const existing = cart.find(i=>i.key===key);
  if(existing) existing.qty += qty;
  else cart.push({
    key,
    productId,
    name:p.name,
    image:p.image,
    sizeLabel:size.label,
    unitPrice:size.price,
    qty
  });
  saveCart(cart);
  toast("Added to cart");
}

/* =========================
   FILTERS + RENDER
========================= */
function getQueryParam(name){
  const url = new URL(window.location.href);
  return url.searchParams.get(name);
}
function setQuery(params){
  const url = new URL(window.location.href);
  Object.entries(params).forEach(([k,v])=>{
    if(v===null || v==="") url.searchParams.delete(k);
    else url.searchParams.set(k,v);
  });
  window.location.href = url.toString();
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

function productCardHTML(p){
  const defaultSize = p.sizes[0];
  return `
    <div class="card">
      <a href="product.php?id=${encodeURIComponent(p.id)}">
        <div class="productImg">
          <img src="${p.image}" alt="${escapeHtml(p.name)}">
        </div>
      </a>
      <div class="pad">
        <a href="product.php?id=${encodeURIComponent(p.id)}">
          <div class="h3">${escapeHtml(p.name)}</div>
          <div class="small">${escapeHtml(p.short)}</div>
        </a>

        <div class="priceRow">
          <div class="price">${fmtKES(defaultSize.price)}</div>
          <div class="stock">${p.stock ? "In stock" : "Out of stock"}</div>
        </div>

        <div class="pills" data-pills="${p.id}">
          ${p.sizes.map((s,idx)=>`
            <button class="pillMini ${idx===0?"active":""}" type="button"
              data-size="${s.label}" data-price="${s.price}" data-p="${p.id}">
              ${s.label}
            </button>`).join("")}
        </div>

        <button class="btn primary full" type="button"
          data-add="${p.id}" data-size="${defaultSize.label}">
          Add to Cart
        </button>

        <div class="note">Prices shown. VAT optional at checkout.</div>
      </div>
    </div>
  `;
}

function render(){
  const grid = document.getElementById("grid");
  const category = getQueryParam("category") || "";
  const q = (getQueryParam("q") || "").toLowerCase();

  // update controls
  document.getElementById("categorySelect").value = category;
  document.getElementById("searchInput").value = getQueryParam("q") || "";

  // update title
  document.getElementById("pageTitle").textContent = category ? prettyCat(category) : "Shop";

  let list = PRODUCTS.slice();
  if(category) list = list.filter(p=>p.category===category);
  if(q) list = list.filter(p => (p.name + " " + p.short).toLowerCase().includes(q));

  grid.innerHTML = list.map(productCardHTML).join("");

  // events: size pills
  grid.querySelectorAll("[data-p]").forEach(btn=>{
    btn.addEventListener("click", (e)=>{
      const pId = btn.getAttribute("data-p");
      const size = btn.getAttribute("data-size");
      const price = Number(btn.getAttribute("data-price"));

      // highlight active
      const wrap = grid.querySelector(`[data-pills="${pId}"]`);
      wrap.querySelectorAll(".pillMini").forEach(x=>x.classList.remove("active"));
      btn.classList.add("active");

      // change card displayed price
      const card = btn.closest(".card");
      const priceEl = card.querySelector(".price");
      priceEl.textContent = fmtKES(price);

      // make add-to-cart use this size
      const addBtn = card.querySelector(`[data-add="${pId}"]`);
      addBtn.setAttribute("data-size", size);
    });
  });

  // events: add to cart
  grid.querySelectorAll("[data-add]").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      addToCart(btn.getAttribute("data-add"), btn.getAttribute("data-size"), 1);
    });
  });

  updateCartUI();
}

function updateCartUI(){
  document.getElementById("cartCount").textContent = String(cartCount());
  const totals = computeTotals(loadCart());
  document.getElementById("cartTotalPill").textContent = fmtKES(totals.total || 0);
}

/* =========================
   INIT
========================= */
document.getElementById("categorySelect").addEventListener("change", (e)=>{
  setQuery({ category: e.target.value || null });
});

document.getElementById("searchBtn").addEventListener("click", ()=>{
  const q = document.getElementById("searchInput").value.trim();
  setQuery({ q: q || null });
});

document.getElementById("clearBtn").addEventListener("click", ()=>{
  setQuery({ q: null, category: null });
});

render();
</script>
</body>
</html>
