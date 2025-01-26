document.addEventListener("alpine:init", () => {
  Alpine.data("products", () => ({
    items: [
      { id: 1, name: "Hazellnut jerman", img: "1.jpg", price: 18000 },
      { id: 2, name: "Kopi Nusantara", img: "2.jpg", price: 25000 },
      { id: 3, name: "Arabica Blend", img: "3.jpg", price: 38000 },
      { id: 4, name: "Americano Late", img: "4.jpg", price: 45000 },
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
