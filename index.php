<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AfriTech — Printing Chemicals (B2B)</title>

<style>
:root{
  --magenta:#E6007E;
  --cyan:black;
  --yellow:#F2D200;
  --black:#1A1A1A;
  --bg:#F6F8FB;
  --white:#ffffff;
  --border:#E4E7EC;
  --radius:16px;
  --shadow:0 10px 30px rgba(0,0,0,.08);
  font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
}

*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--black)}
a{text-decoration:none;color:inherit}
img{max-width:100%;display:block}

.container{
  max-width:1200px;
  margin:auto;
  padding:0 20px;
}

.topbar{
  background:#fff;
  border-bottom:1px solid var(--border);
  position:sticky;
  top:0;
  z-index:100;
}
.nav{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:14px 0;
}
.brand img{height:40px}
.menu{
  display:flex;
  gap:20px;
}
.menu a{
  font-weight:600;
}
.menu a:hover{color:var(--magenta)}

.actions{
  display:flex;
  gap:12px;
  align-items:center;
}
.cart-pill{
  background:#fff;
  border:1px solid var(--border);
  padding:8px 14px;
  border-radius:999px;
  font-weight:700;
}
.btn{
  padding:12px 18px;
  border-radius:14px;
  font-weight:800;
  border:none;
  cursor:pointer;
}
.btn.primary{
  background:var(--magenta);
  color:#fff;
}
.btn.primary:hover{opacity:.9}
.btn.outline{
  background:#fff;
  border:1px solid var(--border);
}

.hero{
  padding:40px 0;
}
.hero-box{
  background:linear-gradient(120deg,
    rgba(85,183,227,.18),
    rgba(230,0,126,.15),
    rgba(242,210,0,.18)
  );
  border-radius:28px;
  padding:40px;
  box-shadow:var(--shadow);
  display:grid;
  grid-template-columns:1.2fr .8fr;
  gap:30px;
}
.hero h1{
  font-size:42px;
  margin:0 0 10px;
}
.hero h1 span{color:var(--blue)}
.hero p{
  color:#555;
  line-height:1.6;
}
.hero-buttons{
  display:flex;
  gap:12px;
  flex-wrap:wrap;
  margin-top:20px;
}

.hero-buttons :hover{
  background-color:#e386b9;
  border-color:#010101;
  transform:translateY(-5px);
}

.badges{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  margin-top:20px;
}
.badge{
  background:#fff;
  border:1px solid var(--border);
  padding:8px 14px;
  border-radius:999px;
  font-weight:700;
  display:flex;
  align-items:center;
  gap:8px;
}
.badge:hover {
  background-color: rgb(248, 143, 248);
  border-color: #020202;     
  transform: translateY(-5px); 
}
.dot{
  width:10px;height:10px;border-radius:50%;
}
.dot.c{background:var(--cyan)}
.dot.m{background:var(--magenta)}
.dot.y{background:var(--yellow)}
.dot.k{background:#000}

/* SECTIONS */
.section{
  padding:40px 0;
  transition:background .3s ease;
}

.container .section hover{
  background:#000000}

.section h2{
  margin-bottom:6px;
}
.section p{
  color:#666;
  margin-bottom:20px;
}


/* GRID & CARDS*/
.grid-3{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:20px;
}
.grid-4{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:20px;
}
.card{
  background:#fff;
  border-radius:var(--radius);
  padding:20px;
  box-shadow:var(--shadow);
  border: 1px solid #ddd; 
  border-radius: 8px;
  border:1px solid var(--border);
}
.card h3{margin-top:1}

.card:hover {
  background-color: #e386b9;
  border-color: #010101;     
  transform: translateY(-5px); 
}

.footer{
  background:#fff;
  border-top:1px solid var(--border);
  padding:40px 0;
}
.footer button:hover {
  color: var(--magenta);
}
.footer-grid{
  display:grid;
  grid-template-columns:2fr 1fr 1fr 2fr;
  gap:20px;
}
.footer small{color:#666}

@media(max-width:900px){
  .hero-box{grid-template-columns:1fr}
  .grid-3,.grid-4{grid-template-columns:1fr}
  .footer-grid{grid-template-columns:1fr}
}
</style>

</head>
<body>

<!-- NAV -->
<div class="topbar">
  <div class="container nav">
    <a class="brand" href="index.php">
      <img src="logo.png" alt="AfriTech">
    </a>

    <div class="menu">
      <a href="index.php">Home</a>
      <a href="shop.php">Shop</a>
      <a href="contact.php">Contact</a>
      <a href="login.php">Login</a>
    </div>

    <div class="actions">
      <a class="cart-pill" href="cart.php">🛒 Cart</a>
      <a class="btn primary" href="shop.php">Shop Now</a>
    </div>
  </div>
</div>

<!-- HERO -->
<section class="hero">
  <div class="container hero-box">
    <div>
      <h1>Afritech Graphics & <span>Press Chemicals Limited. </span></h1>
      <p>
        Plate cleaners, fountain solutions, gum arabic, stationery and Photocopying paper.
      </p>

      <div class="hero-buttons">
        <a class="btn primary" href="shop.php">Browse Products</a>
        <a class="btn outline" href="contact.php">Contact Us</a>
      </div>

      <div class="badges">
        <span class="badge"><span class="dot c"></span> Countrywide Delivery</span>
        <span class="badge"><span class="dot m"></span> SDS Available</span>
        <span class="badge"><span class="dot y"></span> Bulk Pricing</span>
        <span class="badge"><span class="dot k"></span> B2B Ready</span>
      </div>
    </div>

    <div class="card">
      <h3>Why Afritech?</h3>
      <ul>
        <li>Wholesale Prices.</li>
        <li>Industrial-grade formulations.</li>
        <li>Trusted by printing companies. </li>
        <li>Procurement-friendly ordering.</li>
        <li>Delivery across Kenya.</li>
      </ul>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="section">
  <div class="container">
    <h2>Shop by Category</h2>
    <p>Select a product category</p>

    <div class="grid-3">
      <a class="card" href="shop.php?category=plate-cleaners">
        <h3>Plate Cleaners</h3>
        <p>CTP & offset plate cleaning solutions.</p>
      </a>

      <a class="card" href="shop.php?category=fountain-solutions">
        <h3>Fountain Solutions</h3>
        <p>Ink-water balance and dampening control.</p>
      </a>

      <a class="card" href="shop.php?category=gum-finishing">
        <h3>Gum Arabic</h3>
        <p>Plate gumming and protection products.</p>
      </a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="container footer-grid">
    <div>
      <img src="logo.png" style="height:36px">
      <small>Supplying professional printing chemicals across Kenya.</small>
    </div>

    <div>
      <h4>Shop</h4>
      <a href="shop.php">Products</a><br>
      <a href="cart.php">Cart</a>
    </div>

    <div>
      <h4>Company</h4>
      <a href="contact.php">Support</a>
    </div>

    <div>
      <h4>Contact<a href="contact.php"></a></h4>
      <small>📞 +254 123 456 789</small><br>
      <small>✉ info@afritech.co.ke</small><br>
      <small>📍 Kenya</small>
    </div>
  </div>
</footer>

</body>
</html>
