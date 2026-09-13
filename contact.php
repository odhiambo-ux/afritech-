<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | AfriTech</title>

<style>
:root{
  --magenta:#E6007E;
  --cyan:#55B7E3;
  --yellow:#F2D200;
  --black:#1A1A1A;
  --bg:#F6F8FB;
  --white:#fff;
  --border:#E4E7EC;
  --radius:16px;
  --shadow:0 10px 30px rgba(0,0,0,.08);
  font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
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

/* ============ NAVBAR ============ */
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
.menu a:hover,
.menu .active{
  color:var(--magenta);
}
.actions{
  display:flex;
  gap:12px;
  align-items:center;
}
.cart-pill{
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
  transition:all .3s ease;
}
.primary{
  background:var(--magenta);
  color:white;
}
.primary:hover{
  opacity:.9;
  transform:translateY(-2px);
  box-shadow:0 6px 20px rgba(230,0,126,.35);
}

/* ============ HERO ============ */
.hero{
  padding:40px 0;
}
.hero-box{
  background:linear-gradient(135deg,
    rgba(85,183,227,.15),
    rgba(230,0,126,.12),
    rgba(242,210,0,.15)
  );
  border-radius:28px;
  padding:50px 40px;
  box-shadow:var(--shadow);
  text-align:center;
}
.hero h1{
  font-size:3rem;
  margin:0 0 10px;
}
.hero h1 span{
  color:var(--magenta);
}
.hero p{
  color:#555;
  line-height:1.6;
  max-width:600px;
  margin:0 auto 25px;
  font-size:1.1rem;
}
.hero-badges{
  display:flex;
  gap:12px;
  flex-wrap:wrap;
  justify-content:center;
}
.hero-badge{
  background:#fff;
  border:1px solid var(--border);
  padding:8px 16px;
  border-radius:999px;
  font-weight:700;
  font-size:.9rem;
  display:flex;
  align-items:center;
  gap:8px;
  transition:all .3s ease;
}
.hero-badge:hover{
  transform:translateY(-4px);
  box-shadow:0 6px 20px rgba(0,0,0,.1);
}
.dot{
  width:10px;height:10px;border-radius:50%;display:inline-block;
}
.dot.c{background:var(--cyan)}
.dot.m{background:var(--magenta)}
.dot.y{background:var(--yellow)}
.dot.k{background:#000}

/* ============ CONTACT GRID ============ */
.contact-grid{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:30px;
  margin-bottom:50px;
}

/* ---------- CARD BASE ---------- */
.card{
  background:white;
  padding:30px;
  border-radius:20px;
  box-shadow:var(--shadow);
  transition:all .3s ease;
  border:1px solid var(--border);
}
.card:hover{
  transform:translateY(-4px);
  box-shadow:0 16px 40px rgba(0,0,0,.1);
}
.card h2{
  margin-top:0;
  color:var(--magenta);
  font-size:1.6rem;
  display:flex;
  align-items:center;
  gap:10px;
}

/* ---------- INFO TILES ---------- */
.info-grid{
  display:grid;
  gap:16px;
}
.info-tile{
  display:flex;
  align-items:flex-start;
  gap:16px;
  padding:16px;
  border-radius:14px;
  background:var(--bg);
  border:1px solid var(--border);
  transition:all .3s ease;
}
.info-tile:hover{
  transform:translateX(6px);
  border-color:var(--magenta);
  background:#fff;
}
.info-icon{
  width:44px;
  height:44px;
  border-radius:12px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:1.3rem;
  flex-shrink:0;
}
.info-icon.magenta{background:rgba(0, 230, 50, 0.12);}
.info-icon.cyan{background:rgba(85,183,227,.12);}
.info-icon.yellow{background:rgba(242,210,0,.2);}
.info-icon.dark{background:rgba(26,26,26,.08);}
.info-tile-content{}
.info-tile-content strong{
  display:block;
  font-size:.85rem;
  color:#888;
  text-transform:uppercase;
  letter-spacing:.5px;
  margin-bottom:4px;
}
.info-tile-content span{
  font-size:1rem;
  line-height:1.6;
}

/* ---------- FORM ---------- */
form{
  display:flex;
  flex-direction:column;
  gap:16px;
}
.form-group{}
.form-group label{
  display:block;
  font-weight:600;
  font-size:.85rem;
  color:blue;
  margin-bottom:6px;
}
.form-group input,
.form-group textarea{
  width:100%;
  padding:14px 16px;
  border:2px solid var(--border);
  border-radius:12px;
  font-size:15px;
  font-family:inherit;
  outline:none;
  transition:all .3s ease;
  background:var(--bg);
}
.form-group input:focus,
.form-group textarea:focus{
  border-color:var(--magenta);
  box-shadow:0 0 0 4px rgba(230,0,126,.1);
  background:pink ;
}
.form-group textarea{
  resize:vertical;
  min-height:130px;
}
form .btn.primary{
  padding:16px;
  font-size:1.05rem;
  letter-spacing:.3px;
}

/* ============ SECTION TITLE ============ */
.section-title{
  text-align:center;
  margin:50px 0 30px;
}
.section-title h2{
  font-size:2rem;
  margin:0 0 8px;
}
.section-title p{
  color:#666;
  max-width:500px;
  margin:0 auto;
}

/* ============ INFO BANNER ============ */
.info-banner{
  background:#fff;
  border:1px solid var(--border);
  border-radius:20px;
  padding:40px;
  box-shadow:var(--shadow);
  text-align:center;
  margin-bottom:50px;
}
.info-banner-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:20px;
}
.info-banner-item{}
.info-banner-item .icon{
  font-size:2rem;
  margin-bottom:8px;
}
.info-banner-item strong{
  display:block;
  font-size:.95rem;
}
.info-banner-item small{
  color:#888;
  font-size:.8rem;
}

/* ============ FOOTER ============ */
.footer{
  background:#fff;
  border-top:1px solid var(--border);
  padding:40px 0;
}
.footer-grid{
  display:grid;
  grid-template-columns:2fr 1fr 1fr 2fr;
  gap:30px;
}
.footer small{color:#666}
.footer h4{margin:0 0 12px;}
.footer a{display:inline-block;margin-bottom:6px;color:#555;}
.footer a:hover{color:var(--magenta);}

/* ============ RESPONSIVE ============ */
@media(max-width:900px){
  .contact-grid{
    grid-template-columns:1fr;
  }
  .hero-box{
    padding:30px 20px;
  }
  .hero h1{
    font-size:2rem;
  }
  .info-banner-grid{
    grid-template-columns:repeat(2,1fr);
  }
  .footer-grid{
    grid-template-columns:1fr 1fr;
  }
  .nav{
    flex-direction:column;
    gap:12px;
  }
  .menu{
    flex-wrap:wrap;
    justify-content:center;
  }
}

@media(max-width:500px){
  .info-banner-grid{
    grid-template-columns:1fr;
  }
  .footer-grid{
    grid-template-columns:1fr;
  }
  .hero-badges{
    flex-direction:column;
    align-items:center;
  }
}
</style>
</head>

<body>

<!-- ============ NAVBAR ============ -->
<div class="topbar">
  <div class="container nav">

    <a class="brand" href="index.php">
      <img src="logo.png" alt="AfriTech">
    </a>

    <div class="menu">
      <a href="index.php">Home</a>
      <a href="shop.php">Shop</a>
      <a href="contact.php" class="active">Contact</a>
    </div>

    <div class="actions">
      <a class="cart-pill" href="cart.php">🛒 Cart</a>
      <a class="btn primary" href="shop.php">Shop Now</a>
    </div>

  </div>
</div>

<!-- ============ HERO ============ -->
<section class="hero">
  <div class="container hero-box">
    <h1>Get In <span>Touch</span></h1>
    <p>We're here to help with product inquiries, quotations, SDS requests, and orders. Reach out and our team will respond promptly.</p>

    <div class="hero-badges">
      <span class="hero-badge"><span class="dot m"></span> Quick Response</span>
      <span class="hero-badge"><span class="dot c"></span> Bulk Pricing</span>
      <span class="hero-badge"><span class="dot y"></span> SDS Available</span>
      <span class="hero-badge"><span class="dot k"></span> Countrywide Delivery</span>
    </div>
  </div>
</section>

<!-- ============ CONTACT SECTION ============ -->
<div class="container">

  <div class="contact-grid">

    <!-- LEFT: CONTACT INFO -->
    <div class="card">
      <h2>📬 Contact Information</h2>

      <div class="info-grid">

        <div class="info-tile">
          <div class="info-icon magenta">📞</div>
          <div class="info-tile-content">
            <strong>Phone</strong>
            <span>+254 712 345 678</span>
          </div>
        </div>

        <div class="info-tile">
          <div class="info-icon cyan">✉️</div>
          <div class="info-tile-content">
            <strong>Email</strong>
            <span>info@afritechgraphics.co.ke</span>
          </div>
        </div>

        <div class="info-tile">
          <div class="info-icon yellow">📮</div>
          <div class="info-tile-content">
            <strong>Address</strong>
            <span>P.O. Box 123-00007<br>Nairobi, Kenya</span>
          </div>
        </div>

        <div class="info-tile">
          <div class="info-icon dark">🕒</div>
          <div class="info-tile-content">
            <strong>Business Hours</strong>
            <span>Monday – Friday: 8:00 AM – 5:00 PM<br>Saturday: 9:00 AM – 1:00 PM</span>
          </div>
        </div>

      </div>
    </div>

    <!-- RIGHT: CONTACT FORM -->
    <div class="card">
      <h2>💬 Send Us a Message</h2>

      <form action="https://formsubmit.co/odhiamboe784@gmail.com" method="POST">

  <input type="hidden" name="_subject" value="New Message from AfriTech Website">
  <input type="hidden" name="_captcha" value="false">
  <input type="hidden" name="_template" value="table">

  <div class="form-group">
    <label for="name">Full Name</label>
    <input
      type="text"
      id="name"
      name="name"
      placeholder="e.g. Jane Muthoni"
      required
    >
  </div>

  <div class="form-group">
    <label for="email">Email Address</label>
    <input
      type="email"
      id="email"
      name="email"
      placeholder="you@company.co.ke"
      required
    >
  </div>

  <div class="form-group">
    <label for="company">Company Name (optional)</label>
    <input
      type="text"
      id="company"
      name="company"
      placeholder="Your company"
    >
  </div>

  <div class="form-group">
    <label for="message">Message</label>
    <textarea
      id="message"
      name="message"
      placeholder="How can we help you? Tell us about your requirements, quantities, or any questions…"
      required
    ></textarea>
  </div>

  <button class="btn primary" type="submit">
    Send Message →
  </button>

</form>
    </div>

  </div>

</div>

<!-- ============ QUICK INFO BANNER ============ -->
<div class="container">
  <div class="info-banner">
    <div class="info-banner-grid">
      <div class="info-banner-item">
        <div class="icon">📞</div>
        <strong>Call Us</strong>
        <small>+254 735 088 780</small>
      </div>
      <div class="info-banner-item">
        <div class="icon">✉️</div>
        <strong>Email Us</strong>
        <small>info@afritechgraphics.co.ke</small>
      </div>
      <div class="info-banner-item">
        <div class="icon">📍</div>
        <strong>Visit</strong>
        <small>Athi River, Kenya</small>
      </div>
      <div class="info-banner-item">
        <div class="icon">🕒</div>
        <strong>Mon – Fri</strong>
        <small>8:00 AM – 5:00 PM</small>
      </div>
    </div>
  </div>
</div>

<!-- ============ FOOTER ============ -->
<footer class="footer">
  <div class="container footer-grid">
    <div>
      <img src="logo.png" style="height:36px" alt="AfriTech">
      <small>Supplying professional printing chemicals across Kenya.</small>
    </div>

    <div>
      <h4>Shop</h4>
      <a href="shop.php">Products</a><br>
      <a href="cart.php">Cart</a>
    </div>

    <div>
      <h4>Company</h4>
      <a href="contact.php">Support</a><br>
      <a href="contact.php">Contact</a>
    </div>

    <div>
      <h4>Contact</h4>
      <small>📞 +254 735 088 780</small><br>
      <small>✉ info@afritechgraphics.co.ke</small><br>
      <small>📍 P.O. Box 741-00204, Athi River</small>
    </div>
  </div>
  <div class="container" style="text-align:center;padding-top:30px;border-top:1px solid var(--border);margin-top:30px">
    <small>© 2026 AfriTech Graphics & Press Chemicals Ltd. All Rights Reserved.</small>
  </div>
</footer>

</body>
</html>

