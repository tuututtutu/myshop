let cart = JSON.parse(localStorage.getItem("cart")) || [];

function addToCart(name, price) {
  cart.push({name, price});
  localStorage.setItem("cart", JSON.stringify(cart));
  alert("Produit ajouté !");
}

function loadCart() {
  const div = document.getElementById("cart");
  if (!div) return;

  div.innerHTML = "";
  let total = 0;

  cart.forEach((item, i) => {
    total += item.price;
    div.innerHTML += `
      <p>${item.name} - ${item.price}€
      <button onclick="removeItem(${i})">❌</button></p>`;
  });

  div.innerHTML += `<h3>Total : ${total}€</h3>`;
}

function removeItem(i) {
  cart.splice(i,1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function checkout() {
  window.location.href = "success.html";
}

loadCart();
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function addToCart(name, price) {
  cart.push({ name, price });
  localStorage.setItem("cart", JSON.stringify(cart));
  alert(name + " ajouté au panier");
}

