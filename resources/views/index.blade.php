<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>pocipop</title>
    <!-- link font css -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnj.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- link menuju css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
     <!--Alpine js-->
     <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
     <!-- App js-->
      <script src="{{ asset('src/app.js') }}"></script>
    <!-- feather icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <!-- header section mulai -->
    <nav class="navbar" x-data>
      <a href="#" class="navbar-logo">poci<span>pop</span>.</a>

      <div class="navbar-nav">
        <a href="#">Home</a>
        <a href="#about">About</a>
        <a href="#menu">Menu</a>
        <a href="#products">Products</a>
        <a href="#contact">Contacts</a>
      </div>
      
      <div class="icons">
        <a href="#" id="search-button"><i data-feather="search"></i></a>
        <a href="#" id="shopping-cart-button">
          <i data-feather="shopping-cart"></i>
          <span class="quantity-badge" x-show="$store.cart.quantity"
          x-text="$store.cart.quantity"></span>
        </a>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
      <!-- search form start -->
       <div class="search-form">
        <input type="search" id="search-box" placeholder="search here...">
        <label for="search-box"><i data-feather="search"></i></label>
       </div>
        
       <!-- shopping cart start-->
        <div class="shopping-cart">
          <template x-for="item in $store.cart.items" :key="item.id">
            <div class="cart-item">
                <img :src="`/img/products/${item.img}`" :alt="item.name" class="cart-item-image">
                <div class="cart-item-details">
                    <div class="product-info">
                        <h4 class="product-name" x-text="item.name"></h4>
                        <p class="product-price" x-text="rupiah(item.price)"></p>
                    </div>
                </div>
                <div class="cart-item-controls">
                    <button @click="$store.cart.remove(item.id)">-</button>
                    <span x-text="item.quantity"></span>
                    <button @click="$store.cart.add(item)">+</button>
                </div>
            </div>
          </template>
          <h4 x-show="!$store.cart.items.length" style="margin-top: 1rem;">Tidak ada barang</h4>
          <h4 x-show="$store.cart.items.length">Total : <span x-text="rupiah($store.cart.total)"></span></h4>
          
          <div class="form-container" 
               x-show="$store.cart.items.length" 
               x-data="{
                   submitOrder(e) {
                       e.preventDefault();
                       
                       const formData = {
                           name: document.getElementById('name').value,
                           email: document.getElementById('email').value,
                           phone: document.getElementById('phone').value,
                           items: $store.cart.items.map(item => ({
                               id: item.id,
                               name: item.name,
                               quantity: item.quantity,
                               price: parseFloat(item.price),
                               subtotal: parseFloat(item.price) * item.quantity
                           })),
                           total: $store.cart.total
                       };

                       fetch('/orders', {
                           method: 'POST',
                           headers: {
                               'Content-Type': 'application/json',
                               'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                           },
                           body: JSON.stringify(formData)
                       })
                       .then(response => response.json())
                       .then(data => {
                           if (data.success) {
                               alert('Order berhasil dibuat!');
                               $store.cart.items = [];
                               $store.cart.total = 0;
                               $store.cart.quantity = 0;
                               document.getElementById('checkoutform').reset();
                           } else {
                               alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
                           }
                       })
                       .catch(error => {
                           console.error('Error:', error);
                           alert('Terjadi kesalahan saat memproses order');
                       });
                   }
               }">
            <div class="checkout-form">
                <form id="checkoutform" @submit="submitOrder">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>

                    <button type="submit" class="checkout-button">Checkout</button>
                </form>
            </div>
          </div>
        </div>

    </nav>

        <!-- header section akhir -->

    <!-- hero section mulai -->
    <section class="hero" id="home">
      <main class="content">
        <h1>Mari menanangkan fikiran <span> bersama secangkir <span>kopi</span></h1>
        <p>Temukan Kedamaian dalam Setiap Tegukan</p>

        <a href="#" class="cta"> order now</a>
      </main>
    </section>
    <!-- hero section akhir -->
 
    <!-- about awal  -->
    <section id="about" class="about">
      <h2><span>Tentang</span> Kami</h2>

      <div class="row">
        <div class="about-img">
          <img src="img/menu 1.jpg" alt="about us" />
        </div>
        <div class="content">
          <h3>kenapa memilih kopi kami?</h3>
          <p>Terinspirasi dari kekeyaan Indonesia, kami memproduksi kopi yang menggambarkan karakter setiap daerah. kami percaya bahwa setiap tegukan kopi kami membawa cerita dari petani hingga ke tangan anda.</p>
          <p>Setiap cangkir yang anda nikmati adalah bagian dari upaya kami.</p>
        </div>
      </div>
    </section>
    <!-- about akhir -->

    <!-- awal menu -->
    <section id="menu" class="menu">
      <h2><span>Menu</span> Kami</h2>
      <p>kami menyediakan beragam varian menu kopi, banyak pilihan coffe yang dapat anda nikmati. Berikut menu yang di tampikan....</p>
      <div class="row">
        <div class="menu-card">
          <img src="img/menu 1.jpg" alt="latte" class="menu-card-img" />
          <h3 class="menu-card-title">- LATTE -</h3>
          <p class="menu-card-price">IDR. 18K</p>
        </div>
        <div class="menu-card">
          <img src="img/menu 1.jpg" alt="latte" class="menu-card-img" />
          <h3 class="menu-card-title">- LATTE -</h3>
          <p class="menu-card-price">IDR. 18K</p>
        </div>
        <div class="menu-card">
          <img src="img/menu 1.jpg" alt="latte" class="menu-card-img" />
          <h3 class="menu-card-title">- LATTE -</h3>
          <p class="menu-card-price">IDR. 18K</p>
        </div>
        <div class="menu-card">
          <img src="img/menu 1.jpg" alt="latte" class="menu-card-img" />
          <h3 class="menu-card-title">- LATTE -</h3>
          <p class="menu-card-price">IDR. 18K</p>
        </div>
      </div>
    </section> 
    </body>
    <!-- menu section end-->

     <!--product section awal-->
    <section class="products" id="products" x-data="products">
      <h2><span>Produk Jagoan</span> Kami!</h2>
      <p>Produk kami merupakan biji berbahan unggulan,</p>
      <p>yang berkualitas tinggi. nikmati perbedaan rasanya.</p>

      <div class="row">
        <template x-for="(item, index) in items" x-key="index">
          <div class="products-card" :class="{ 'is-flipped': item.isFlipped }">
            <div class="card-inner">
              <!-- Front of card -->
              <div class="card-front">
                <div class="products-icons">
                  <a href="#" @click.prevent="$store.cart.add(item)">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <use href="img/feather-sprite.svg#shopping-cart" />
                    </svg>
                  </a>
                  <a href="#" @click.prevent="item.isFlipped = !item.isFlipped">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <use href="img/feather-sprite.svg#eye" />
                    </svg>
                  </a>
                </div>

                <div class="product-image">
                  <img :src="`img/products/${item.img}`" :alt="item.name">
                </div>
                <div class="product-content">
                  <h3 x-text="item.name"></h3>
                  <div class="product-stars">
                    <svg
                    width="24"
                    height="24"
                    fill="currentColor"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                  <use href="img/feather-sprite.svg#star" />
                  </svg>
                  <svg
                    width="24"
                    height="24"
                    fill="currentColor"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                  <use href="img/feather-sprite.svg#star" />
                  </svg>
                  <svg
                    width="24"
                    height="24"
                    fill="currentColor"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                  <use href="img/feather-sprite.svg#star" />
                  </svg>
                  <svg
                    width="24"
                    height="24"
                    fill="currentColor"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                  <use href="img/feather-sprite.svg#star" />
                  </svg>
                  <svg
                    width="24"
                    height="24"
                    fill="currentColor"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  >
                  <use href="img/feather-sprite.svg#star" />
                  </svg>
                  </div>
                  <div class="product-price"><span x-text="rupiah(item.price)"></span></div>
                </div>
              </div>

              <!-- Back of card -->
              <div class="card-back">
                <h3 x-text="item.name"></h3>
                <p class="coffee-level" x-text="'Level: ' + item.level"></p>
                <p class="description" x-text="item.description"></p>
                <button class="flip-back-btn" @click="item.isFlipped = false">
                  <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <use href="img/feather-sprite.svg#rotate-ccw" />
                  </svg>
                  Kembali
                </button>
              </div>
            </div>
          </div>
        </template>
      </div>
    </section>

    <!--contact section start-->
    <section id="contact" class="contact">
      <h2><span>kontak</span> Kami</h2>
      <p>Anda dapat mengetahui lebih lanjut, dan juga melakukan pemesanan. Dengan cara mendaftar terlebih dahulu. Terima Kasih  </p>

      <div class="row">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15844.515429319996!2d107.56645474475772!3d-6.8751608399767195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e69da95e9089%3A0x61ddc5dae4f8469!2sSarijadi%2C%20Kec.%20Sukasari%2C%20Kota%20Bandung%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1736329970247!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>

        <form action="">
          <div class="input_group">
            <i data-feather="user"></i>
            <input type="text" placeholder="Nama" />
          </div>
          <div class="input_group">
            <i data-feather="mail"></i>
            <input type="text" placeholder="Email" />
          </div>
          <div class="input_group">
            <i data-feather="phone"></i>
            <input type="text" placeholder="No HP" />
          </div>
          <button type="submit" class="btn">Kirim Pesan</button>
        </form>        
          </div>
      </div> 
    </section>      
    <!-- contact section end -->
    
    <!-- foter icons-->
    <footer>
      <div class="socials">
        <a href="#"><i data-feather="instagram"></i></a>
          <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
      </div>

      <div class="links">
        <a href="#">home</a>
        <a href="#about">about</a>
        <a href="#menu">menu</a>
        <a href="#contact">contact</a>
      </div>
<div class="credit">
  <p>Createdby<span>Aidahmarchtiana</span>haikalputra</p>
</div> 
    </footer>

    <!-- modal box detail start -->
     <div class="modal" id="item-detail-modal">
      <div class="modal-container">
        <a href="#" class="close-icon"><i data-feather="x"></i></a>
        <div class="modal-content">
          <div class="modal-content">
          <img src="img/biji kopi.jpg" alt="product 1">
          <div class="product-content">
          <h3>product 1</h3>
          <p> kopi yang berkualitas tinggi, di olah menggunakan bahan terpercaya. pastinya berpengaruh pada rasa yang otentic</p>
          <div>
            <div class="product-stars">
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star"></i>
            <div class="product-price">IDR 35K <span>IDR 50K</span></div>
            <a href="#"><i data-feather="shopping-cart"></i> <span>add to cart</span></a>
        </div >
      </div>
     </div>
    </div>
    <script>
      feather.replace();
    </script>

    <!-- my js --> 
    <script src="js/script.js"></script>
    <script>
        window.addEventListener('alpine:init', () => {
            Alpine.data('products', () => ({
                items: <?php echo json_encode($products); ?>
            }))
        });

        // Deklarasikan fungsi rupiah di awal
        function rupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(number);
        }

        window.addEventListener('alpine:init', () => {
            Alpine.store('cart', {
                items: [],
                total: 0,
                quantity: 0,
                
                add(product) {
                    const item = this.items.find((i) => i.id === product.id);
                    
                    if (item) {
                        item.quantity++;
                        item.total = parseFloat(item.price) * item.quantity;
                    } else {
                        this.items.push({
                            ...product,
                            quantity: 1,
                            total: parseFloat(product.price)
                        });
                    }
                    
                    this.updateTotals();
                },
                
                remove(productId) {
                    const item = this.items.find((i) => i.id === productId);
                    
                    if (item) {
                        if (item.quantity > 1) {
                            item.quantity--;
                            item.total = parseFloat(item.price) * item.quantity;
                        } else {
                            this.items = this.items.filter((i) => i.id !== productId);
                        }
                    }
                    
                    this.updateTotals();
                },
                
                updateTotals() {
                    this.quantity = this.items.reduce((sum, item) => sum + item.quantity, 0);
                    this.total = this.items.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
                }
            });
        });
    </script>

    <style>
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        .cart-item-details {
            flex: 1;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .product-name {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }

        .product-price {
            margin: 0;
            color: #666;
            padding-left: 2px;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
  </body>
  
</html>
  