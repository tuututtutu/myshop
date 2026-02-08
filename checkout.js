const express = require("express");
const Stripe = require("stripe");
const cors = require("cors");

const app = express();
const stripe = new Stripe("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"); // 🔴 TA CLÉ SECRÈTE LIVE

app.use(cors());
app.use(express.json());

app.post("/create-checkout-session", async (req, res) => {
  try {
    const session = await stripe.checkout.sessions.create({
      mode: "payment",
      line_items: req.body.items.map(item => ({
        price_data: {
          currency: "eur",
          product_data: {
            name: item.name,
            description: `Couleur: ${item.color} | Taille: ${item.size || "N/A"}`
          },
          unit_amount: Math.round(item.price * 100)
        },
        quantity: 1
      })),
      success_url: "https://my-shop.shop/success.html",
      cancel_url: "https://my-shop.shop/panier.html"
    });

    res.json({ url: session.url });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

app.listen(4242, () => console.log("Stripe Checkout OK"));
