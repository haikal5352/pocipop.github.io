document.addEventListener('alpine:init' , () => {
Alpine.data('products', () => ({
    items: [{ id: 1, name: 'Hazellnut jerman', img: '1.jpg', price: 18000 },
        { id: 2, name: 'Kopi Nusantara', img: '2.jpg', price: 25000 },
        { id: 3, name: 'Arabica Blend', img: '3.jpg', price: 38000 },
        { id: 4, name: 'Americano Late', img: '4.jpg', price: 45000 }
    ],

}));


Alpine.store('cart', {
    items: [],
    total: 0,
    quantity: 0,
    add(newItem) {
        this.items.push(newItem);
        this.quantity++;
        this.total+= newItem.price
        console.long(this.total)
    }


});

});

//duit
const rupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(number);
}
