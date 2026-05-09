<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta name="description" content="Family Tech - Premium IT products: laptops, desktops, monitors, printers, UPS, and all computer accessories. Best deals on tech for home, office, and gaming.">
  <meta name="keywords" content="laptops, desktops, all-in-ones, mini PCs, workstations, monitors, printers, smartboards, UPS, computer accessories, Family Tech">
  <meta name="author" content="Family Tech">
  <meta name="robots" content="index, follow">
  <title>Family Tech | Premium IT Shop – Laptops, Desktops & Accessories</title>
  <!-- Google Fonts & Font Awesome -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f8fafc;
      color: #0a1e2f;
      scroll-behavior: smooth;
    }

    /* modern glassmorphism & gradients */
    :root {
      --primary: #3b3bdb;
      --primary-dark: #2a2ab0;
      --secondary: #f97316;
      --accent: #10b981;
      --dark: #0f172a;
      --light: #ffffff;
      --gray-bg: #f1f5f9;
      --card-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.15);
    }

    /* container */
    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 30px;
    }

    /* header */
    .header {
      background: rgba(255,255,255,0.96);
      backdrop-filter: blur(8px);
      box-shadow: 0 4px 30px rgba(0,0,0,0.03);
      position: sticky;
      top: 0;
      z-index: 100;
      border-bottom: 1px solid rgba(59,59,219,0.1);
    }

    .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      padding: 18px 0;
    }

    .logo h1 {
      font-size: 1.9rem;
      font-weight: 800;
      background: linear-gradient(135deg, #3b3bdb, #f97316);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      letter-spacing: -0.5px;
    }
    .logo span {
      font-size: 0.9rem;
      font-weight: 500;
      color: #4b5563;
      display: block;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }
    .nav-links a {
      text-decoration: none;
      font-weight: 600;
      color: #1e293b;
      transition: 0.2s;
    }
    .nav-links a:hover, .nav-links a.active {
      color: var(--primary);
    }
    .cart-icon {
      position: relative;
      font-size: 1.5rem;
      cursor: pointer;
    }
    .cart-count {
      position: absolute;
      top: -8px;
      right: -12px;
      background: var(--secondary);
      color: white;
      font-size: 0.7rem;
      font-weight: bold;
      border-radius: 30px;
      padding: 2px 6px;
    }

    /* hero section */
    .hero {
      background: linear-gradient(120deg, #eef2ff 0%, #ffffff 100%);
      padding: 70px 0;
      border-radius: 0 0 50px 50px;
      margin-bottom: 40px;
    }
    .hero-grid {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
    }
    .hero-text h2 {
      font-size: 3.2rem;
      font-weight: 800;
      line-height: 1.2;
      background: linear-gradient(to right, #0f172a, #3b3bdb);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .hero-text p {
      font-size: 1.2rem;
      margin: 20px 0;
      color: #334155;
    }
    .btn {
      display: inline-block;
      background: var(--primary);
      color: white;
      padding: 12px 32px;
      border-radius: 40px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
      box-shadow: 0 8px 14px rgba(59,59,219,0.2);
    }
    .btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }
    .btn-outline {
      background: transparent;
      border: 2px solid var(--primary);
      color: var(--primary);
      box-shadow: none;
    }
    .hero-stats {
      display: flex;
      gap: 30px;
      margin-top: 30px;
    }

    /* categories / product grid */
    .section-title {
      font-size: 2rem;
      font-weight: 700;
      margin: 50px 0 25px 0;
      border-left: 5px solid var(--secondary);
      padding-left: 20px;
    }
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 30px;
      margin-bottom: 60px;
    }
    .product-card {
      background: white;
      border-radius: 28px;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
      cursor: pointer;
      position: relative;
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--card-shadow);
    }
    .product-img {
      background: linear-gradient(145deg, #f1f5f9, #e6edf4);
      height: 220px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      color: var(--primary);
    }
    .product-info {
      padding: 1.5rem;
    }
    .product-category {
      font-size: 0.75rem;
      text-transform: uppercase;
      font-weight: 700;
      color: var(--secondary);
      letter-spacing: 1px;
    }
    .product-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin: 8px 0;
    }
    .product-price {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--primary-dark);
      margin: 12px 0;
    }
    .add-to-cart {
      background: #0f172a;
      width: 100%;
      border: none;
      padding: 12px;
      border-radius: 40px;
      color: white;
      font-weight: 600;
      transition: 0.2s;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .add-to-cart:hover {
      background: var(--primary);
    }

    /* cart sidebar */
    .cart-overlay {
      position: fixed;
      top: 0;
      right: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      backdrop-filter: blur(5px);
      z-index: 1000;
      visibility: hidden;
      opacity: 0;
      transition: 0.2s;
    }
    .cart-sidebar {
      position: fixed;
      top: 0;
      right: -450px;
      width: 400px;
      max-width: 90vw;
      height: 100%;
      background: white;
      box-shadow: -10px 0 30px rgba(0,0,0,0.1);
      z-index: 1001;
      transition: 0.3s ease;
      display: flex;
      flex-direction: column;
      padding: 25px;
    }
    .cart-sidebar.open {
      right: 0;
    }
    .cart-overlay.open {
      visibility: visible;
      opacity: 1;
    }
    .cart-header {
      display: flex;
      justify-content: space-between;
      font-weight: 800;
      font-size: 1.5rem;
      border-bottom: 2px solid #eef2ff;
      padding-bottom: 15px;
    }
    .cart-items {
      flex: 1;
      overflow-y: auto;
      margin: 20px 0;
    }
    .cart-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      padding: 10px 0;
      border-bottom: 1px solid #e2e8f0;
    }
    .cart-total {
      font-weight: 800;
      font-size: 1.3rem;
      padding: 15px 0;
      border-top: 2px dashed #cbd5e1;
    }
    .checkout-btn {
      background: var(--accent);
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 40px;
      font-weight: bold;
      color: white;
      font-size: 1rem;
    }

    /* footer */
    .footer {
      background: #0a1e2f;
      color: #cbd5e6;
      padding: 50px 0 30px;
      margin-top: 70px;
    }
    .footer-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 30px;
    }
    .footer-col h4 {
      color: white;
      margin-bottom: 20px;
    }
    .footer-col p, .footer-col a {
      color: #94a3b8;
      text-decoration: none;
    }
    .social i {
      font-size: 1.5rem;
      margin-right: 15px;
      transition: 0.2s;
      color: #cbd5e6;
    }
    .copyright {
      text-align: center;
      padding-top: 40px;
      font-size: 0.8rem;
    }

    @media (max-width: 780px) {
      .nav {
        flex-direction: column;
        gap: 12px;
      }
      .hero-text h2 {
        font-size: 2.3rem;
      }
    }
  </style>
</head>
<body>

<div class="header">
  <div class="container">
    <div class="nav">
      <div class="logo">
        <h1>Family Tech</h1>
        <span>⚡ Power your digital life</span>
      </div>
      <div class="nav-links">
        <a href="#" class="active">Home</a>
        <a href="#">Shop</a>
        <a href="#">Deals</a>
        <a href="#">Support</a>
        <div class="cart-icon" id="cartIcon">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-count" id="cartCount">0</span>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="hero">
  <div class="container hero-grid">
    <div class="hero-text">
      <h2>Next-Gen IT Gear<br>for Home & Business</h2>
      <p>Laptops · Desktops · Workstations · Monitors · Printers · Smartboards · UPS & Accessories</p>
      <a href="#products" class="btn">Shop Now →</a>
      <div class="hero-stats">
        <div><strong>⭐ 4.9/5</strong><br>Trusted reviews</div>
        <div><strong>🚚 Free shipping</strong><br>on orders $500+</div>
        <div><strong>💎 2Y warranty</strong><br>on premium gear</div>
      </div>
    </div>
    <div class="hero-img">
      <i class="fas fa-laptop-code" style="font-size: 10rem; color: #3b3bdb80;"></i>
    </div>
  </div>
</section>

<div class="container" id="products">
  <div class="section-title">🔥 Bestsellers & New Arrivals</div>
  <div class="products-grid" id="productsGrid"></div>
</div>

<!-- Cart Sidebar -->
<div class="cart-overlay" id="cartOverlay"></div>
<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-header">
    <span>🛒 Your Cart</span>
    <i class="fas fa-times" id="closeCart" style="cursor:pointer;"></i>
  </div>
  <div class="cart-items" id="cartItemsList">
    <p style="color:#94a3b8;">Your cart is empty</p>
  </div>
  <div class="cart-total" id="cartTotal">Total: $0</div>
  <button class="checkout-btn" id="checkoutBtn">Proceed to Checkout 🚀</button>
</div>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <h4>Family Tech</h4>
        <p>Your trusted IT partner since 2024. Premium computers, monitors, UPS, accessories & expert support.</p>
      </div>
      <div class="footer-col">
        <h4>Quick links</h4>
        <p><a href="#">Laptops</a></p>
        <p><a href="#">Desktops & Workstations</a></p>
        <p><a href="#">Monitors & Smartboards</a></p>
        <p><a href="#">Printers & UPS</a></p>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <p><i class="fas fa-envelope"></i> hello@familytech.com</p>
        <p><i class="fas fa-phone-alt"></i> +1 (800) 234-9876</p>
        <div class="social">
          <i class="fab fa-instagram"></i>
          <i class="fab fa-facebook"></i>
          <i class="fab fa-x-twitter"></i>
        </div>
      </div>
    </div>
    <div class="copyright">
      © 2025 Family Tech — Elevating Digital Experiences. All trademarks reserved.
    </div>
  </div>
</footer>

<script>
  // PRODUCT CATALOG (IT products: laptops, desktops, all in ones, mini pcs, workstations, monitors, printers, smartboards, ups, accessories)
  const products = [
    { id: 1, name: "ZenBook Pro 15", category: "Laptop", price: 1499, icon: "fas fa-laptop" },
    { id: 2, name: "WorkStation X9", category: "Workstation", price: 2899, icon: "fas fa-server" },
    { id: 3, name: "All-in-One 27\"", category: "All-in-One", price: 1299, icon: "fas fa-tv" },
    { id: 4, name: "Mini PC Ultra", category: "Mini PC", price: 599, icon: "fas fa-microchip" },
    { id: 5, name: "Desktops Power G5", category: "Desktop", price: 1099, icon: "fas fa-desktop" },
    { id: 6, name: "ProArt 32\" 4K Monitor", category: "Monitor", price: 849, icon: "fas fa-tv" },
    { id: 7, name: "Laser Printer MFP", category: "Printer", price: 379, icon: "fas fa-print" },
    { id: 8, name: "SmartBoard Touch 75\"", category: "Smartboard", price: 2499, icon: "fas fa-chalkboard" },
    { id: 9, name: "UPS 1500VA Backup", category: "UPS", price: 219, icon: "fas fa-battery-full" },
    { id: 10, name: "Wireless Mouse+Keyboard", category: "Accessory", price: 49, icon: "fas fa-keyboard" },
    { id: 11, name: "Gaming Laptop Helios", category: "Laptop", price: 1899, icon: "fas fa-gamepad" },
    { id: 12, name: "USB-C Hub 10-in-1", category: "Accessory", price: 79, icon: "fas fa-plug" },
    { id: 13, name: "Ergonomic Monitor Arm", category: "Accessory", price: 89, icon: "fas fa-cogs" },
    { id: 14, name: "Workstation Z Tower", category: "Workstation", price: 3699, icon: "fas fa-database" },
    { id: 15, name: "Smart Interactive Board", category: "Smartboard", price: 3199, icon: "fas fa-chalkboard-teacher" }
  ];

  // Cart array
  let cart = [];

  // Render all products
  function renderProducts() {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;
    grid.innerHTML = '';
    products.forEach(prod => {
      const card = document.createElement('div');
      card.className = 'product-card';
      card.innerHTML = `
        <div class="product-img">
          <i class="${prod.icon}" style="font-size: 3.8rem;"></i>
        </div>
        <div class="product-info">
          <div class="product-category">${prod.category}</div>
          <div class="product-title">${prod.name}</div>
          <div class="product-price">$${prod.price.toLocaleString()}</div>
          <button class="add-to-cart" data-id="${prod.id}"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </div>
      `;
      grid.appendChild(card);
    });
    // attach add-to-cart events after rendering
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const id = parseInt(btn.getAttribute('data-id'));
        addToCart(id);
      });
    });
  }

  function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;
    const existingItem = cart.find(item => item.id === productId);
    if (existingItem) {
      existingItem.qty += 1;
    } else {
      cart.push({ ...product, qty: 1 });
    }
    updateCartUI();
    animateCartIcon();
  }

  function removeFromCart(productId) {
    const index = cart.findIndex(item => item.id === productId);
    if (index !== -1) {
      if (cart[index].qty > 1) {
        cart[index].qty -= 1;
      } else {
        cart.splice(index, 1);
      }
    }
    updateCartUI();
  }

  function updateCartUI() {
    const cartCountSpan = document.getElementById('cartCount');
    const cartItemsDiv = document.getElementById('cartItemsList');
    const cartTotalSpan = document.getElementById('cartTotal');
    let totalItems = 0;
    let totalPrice = 0;
    cart.forEach(item => {
      totalItems += item.qty;
      totalPrice += item.price * item.qty;
    });
    if (cartCountSpan) cartCountSpan.innerText = totalItems;
    if (cartItemsDiv) {
      if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p style="color:#94a3b8;">🛍️ Your cart is empty. Add some tech!</p>';
      } else {
        cartItemsDiv.innerHTML = '';
        cart.forEach(item => {
          const div = document.createElement('div');
          div.className = 'cart-item';
          div.innerHTML = `
            <div><strong>${item.name}</strong><br>$${item.price} x ${item.qty}</div>
            <div><button class="remove-item" data-id="${item.id}" style="background: #fee2e2; border: none; border-radius: 30px; padding: 5px 12px; cursor:pointer;">Remove</button></div>
          `;
          cartItemsDiv.appendChild(div);
        });
        document.querySelectorAll('.remove-item').forEach(btn => {
          btn.addEventListener('click', (e) => {
            const id = parseInt(btn.getAttribute('data-id'));
            removeFromCart(id);
          });
        });
      }
    }
    if (cartTotalSpan) cartTotalSpan.innerText = `Total: $${totalPrice.toLocaleString()}`;
  }

  function animateCartIcon() {
    const icon = document.querySelector('.cart-icon i');
    if (icon) {
      icon.style.transform = 'scale(1.2)';
      setTimeout(() => { icon.style.transform = 'scale(1)'; }, 200);
    }
  }

  // cart sidebar logic
  const cartIconBtn = document.getElementById('cartIcon');
  const cartOverlay = document.getElementById('cartOverlay');
  const cartSidebar = document.getElementById('cartSidebar');
  const closeCartBtn = document.getElementById('closeCart');

  function openCart() {
    cartOverlay.classList.add('open');
    cartSidebar.classList.add('open');
  }
  function closeCartFn() {
    cartOverlay.classList.remove('open');
    cartSidebar.classList.remove('open');
  }
  if (cartIconBtn) cartIconBtn.addEventListener('click', openCart);
  if (closeCartBtn) closeCartBtn.addEventListener('click', closeCartFn);
  if (cartOverlay) cartOverlay.addEventListener('click', closeCartFn);

  // checkout alert + reset (demo)
  const checkoutBtn = document.getElementById('checkoutBtn');
  if (checkoutBtn) {
    checkoutBtn.addEventListener('click', () => {
      if (cart.length === 0) {
        alert("Your cart is empty. Add amazing IT products first!");
      } else {
        alert(`✅ Thank you for shopping at Family Tech! Total: $${cart.reduce((sum, i) => sum + (i.price * i.qty), 0).toLocaleString()}\n\nOur team will contact you shortly.`);
        // optional: reset cart for demo after "purchase"
        cart = [];
        updateCartUI();
        closeCartFn();
      }
    });
  }

  // smooth scroll to products; add extra SEO schema-like meta (dynamic)
  document.querySelector('.btn').addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
  });

  // Load product data and attach category filtering? but full grid with all products.
  renderProducts();
  updateCartUI();

  // optional additional rich snippet structured data for Google (basic)
  (function addLDJson() {
    const script = document.createElement('script');
    script.type = 'application/ld+json';
    script.textContent = JSON.stringify({
      "@context": "https://schema.org",
      "@type": "ElectronicsStore",
      "name": "Family Tech",
      "image": "https://familytech.example/logo.png",
      "description": "Best IT products store: laptops, desktops, workstations, monitors, printers, UPS, smartboards, and computer accessories.",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "San Francisco",
        "addressRegion": "CA"
      },
      "priceRange": "$$",
      "telephone": "+18002349876"
    });
    document.head.appendChild(script);
  })();

  // Make nav links smooth and interactive
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', (e) => {
      if(link.getAttribute('href') === '#') e.preventDefault();
      if(link.innerText === 'Shop') document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
      if(link.innerText === 'Home') window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });
</script>

<!-- Extra elegant toast effect for added charm but not required -->
<style>
  .remove-item:hover {
    background: #fecaca !important;
  }
  button, .add-to-cart {
    cursor: pointer;
  }
  ::-webkit-scrollbar {
    width: 6px;
  }
  ::-webkit-scrollbar-track {
    background: #e2e8f0;
  }
  ::-webkit-scrollbar-thumb {
    background: #3b3bdb;
    border-radius: 10px;
  }
</style>
</body>
</html>