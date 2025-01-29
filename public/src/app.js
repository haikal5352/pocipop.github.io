document.addEventListener("alpine:init", () => {
  Alpine.data("products", () => ({
    items: [
      { 
        id: 1, 
        name: "Hazelnut Jerman", 
        img: "1.jpg", 
        price: 18000,
        level: "Medium",
        description: "Kopi dengan aroma kacang hazelnut khas Jerman yang lembut. Perpaduan sempurna antara biji kopi pilihan dan essence hazelnut premium menghasilkan cita rasa yang unik dan memikat.",
        isFlipped: false
      },
      { 
        id: 2, 
        name: "Kopi Nusantara", 
        img: "2.jpg", 
        price: 25000,
        level: "Strong",
        description: "Racikan kopi lokal terbaik dari berbagai penjuru Nusantara. Memiliki karakter kuat dengan sentuhan rempah tradisional Indonesia.",
        isFlipped: false
      },
      { 
        id: 3, 
        name: "Arabica Blend", 
        img: "3.jpg", 
        price: 38000,
        level: "Medium-Strong",
        description: "Perpaduan biji arabika berkualitas tinggi yang menghasilkan cita rasa seimbang dengan tingkat keasaman yang pas dan aroma yang menggoda.",
        isFlipped: false
      },
      { 
        id: 4, 
        name: "Americano Late", 
        img: "4.jpg", 
        price: 45000,
        level: "Medium",
        description: "Espresso yang dipadukan dengan air panas, menghasilkan kopi yang ringan namun tetap kaya akan cita rasa. Cocok untuk pecinta kopi yang menginginkan caffeine boost.",
        isFlipped: false
      },
    ],
  }));
  Alpine.store("cart", {
    items: [],
    total: 0,
    quantity: 0,
    add(newItem) {
      const cariItem = this.items.find((item) => item.id === newItem.id);

      if (!cariItem) {
        // Menambahkan item baru jika belum ada
        this.items.push({ ...newItem, quantity: 1, total: newItem.price });
        this.quantity++;
        this.total += newItem.price;
      } else {
        // Jika item sudah ada, update quantity dan total
        this.items.forEach((item) => {
          if (item.id === newItem.id) {
            item.quantity++;
            item.total = item.price * item.quantity; // Memperbarui total
            this.quantity++;
            this.total += item.price;
          }
        });
      }
    },
    remove(id) {
      //ambil id yg mau di remove
      const cariItem = this.items.find((item) => item.id === id);

      // jika item lebih dri 1
      if (cariItem.quantity > 1) {
        // Telusuri 1 per 1
        this.items = this.items.map((item) => {
          // Jika barang bukan yang di-klik
          if (item.id !== id) {
            return item;
          } else {
            item.quantity--;
            item.total = item.price * item.quantity;
            this.quantity--;
            this.total -= item.price;
            return item;
          }
        });
      } else if (cariItem.quantity === 1) {
        //jika barangnya sisa 1
        this.items = this.items.filter((item) => item.id !== id);
        this.quantity--;
        his.total -= item.price;
      }
    },
  });
});

//duit
const rupiah = (number) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(number);
};

document.getElementById('checkoutform').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        items: Alpine.store('cart').items,
        total: Alpine.store('cart').total
    };

    try {
        const response = await fetch('/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (data.success) {
            // Reset cart
            Alpine.store('cart').items = [];
            Alpine.store('cart').total = 0;
            Alpine.store('cart').quantity = 0;
            
            // Show success message
            alert('Order berhasil dibuat!');
            
            // Reset form
            this.reset();
        } else {
            alert('Terjadi kesalahan: ' + data.message);
        }
    } catch (error) {
        alert('Terjadi kesalahan saat memproses order');
        console.error('Error:', error);
    }
});
