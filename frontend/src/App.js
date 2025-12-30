import React, { useState, useEffect } from 'react';
import * as api from './services/api'; 
import './App.css';

const IMAGE_BASE_URL = "http://localhost/mini_mvc/backend/public/assets/images/products/";

function App() {
  const [products, setProducts] = useState([]);
  const [cart, setCart] = useState([]);
  const [orders, setOrders] = useState([]); 
  const [user, setUser] = useState(null); 
  const [view, setView] = useState('shop'); 
  const [selectedProduct, setSelectedProduct] = useState(null);
  const [loading, setLoading] = useState(false);

  useEffect(() => { loadProducts(); }, []);

  const loadProducts = async () => {
    setLoading(true);
    try {
      const data = await api.getProducts();
      setProducts(data);
    } catch (err) { console.error(err); }
    setLoading(false);
  };

  const refreshCart = async () => {
    if (user) {
      const data = await api.getCart(user.id);
      setCart(data);
    }
  };

  const loadOrders = async () => {
    if (user) {
      try {
        const data = await api.getOrders(user.id);
        setOrders(data);
        setView('orders');
      } catch (err) { alert("Erreur historique"); }
    }
  };

  const handleLogout = () => {
    setUser(null);
    setCart([]);
    setOrders([]);
    setView('shop');
    alert("Déconnecté !");
  };

  const handleViewDetail = async (id) => {
    const product = await api.getProductById(id);
    setSelectedProduct(product);
    setView('detail');
  };

  const handleAddToCart = async (product, context = 'list') => {
    if (!user) { setView('login'); return; }
    const inputId = context === 'detail' ? 'qty-detail' : `qty-${product.id}`;
    const qtyInput = document.getElementById(inputId);
    let quantity = qtyInput ? parseInt(qtyInput.value) : 1;
    if (quantity < 1) { alert("Quantité invalide"); return; }

    await api.addToCart({ 
        user_id: user.id, 
        product_id: product.id, 
        quantite: quantity 
    });
    refreshCart();
    alert(`Ajouté au panier : ${product.nom} (x${quantity})`);
  };

  const handleRemoveFromCart = async (cartId) => {
    await api.removeFromCart({ cart_id: cartId });
    refreshCart();
  };

  const handleCheckout = async () => {
    const res = await api.placeOrder({ user_id: user.id });
    if (res.success) {
      alert("Commande passée avec succès !");
      setCart([]);
      loadOrders(); 
    } else {
      alert("Erreur : " + (res.message || "Impossible de commander"));
    }
  };

  const handleLogin = async (e) => {
    e.preventDefault();
    const res = await api.login({ email: e.target.email.value, password: e.target.password.value });
    if (res.success) { 
        setUser(res.user); 
        setView('shop'); 
        // Rafraîchir le panier immédiatement
        const cartData = await api.getCart(res.user.id);
        setCart(cartData);
    }
    else { alert("Erreur de connexion"); }
  };

  const handleRegister = async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const res = await api.register(data);
        if (res.success) {
            alert("Compte créé ! Veuillez vous connecter.");
            setView('login');
        } else {
            alert("Erreur : " + res.message);
        }
    } catch (err) {
        console.error(err);
        alert("Erreur réseau");
    }
  };

  // --- FONCTION UTILITAIRE POUR L'AFFICHAGE DES IMAGES ---
  const getImageUrl = (image) => {
    if (!image) return null;
    // Si c'est une URL complète (https://...) ou du base64, on l'utilise telle quelle
    if (image.startsWith('http') || image.startsWith('data:image')) {
        return image;
    }
    // Sinon, on ajoute le chemin local
    return `${IMAGE_BASE_URL}${image}`;
  };

  return (
    <div className="App">
      <header className="App-header">
        <h1>Ma Boutique E-Efrei</h1>
        <nav>
          <button onClick={() => setView('shop')}>Boutique</button>
          <button onClick={() => { setView('cart'); refreshCart(); }}>Panier ({cart.length})</button>
          {user && <button onClick={loadOrders}>Mes Commandes</button>}
          
          {user ? (
            <div style={{display: 'flex', alignItems: 'center', gap: '10px', marginLeft: '10px'}}>
              <span>👤 {user.nom}</span>
              <button onClick={handleLogout} style={{background: '#c0392b', fontSize: '12px'}}>Déconnexion</button>
            </div>
          ) : (
            <button onClick={() => setView('login')}>Connexion</button>
          )}
        </nav>
      </header>

      <div className="container">
        {/* VUE BOUTIQUE */}
        {view === 'shop' && (
          <div className="users-section">
            <h2>Nos Produits</h2>
            <div className="users-grid">
              {products.map(product => (
                <div key={product.id} className="user-card">
                  <div className="product-image-container">
                    {product.image ? (
                        <img src={getImageUrl(product.image)} alt={product.nom} className="product-thumb" />
                    ) : (
                        <div className="no-image">Pas d'image</div>
                    )}
                  </div>
                  <h3>{product.nom}</h3>
                  <p><strong>{product.prix} €</strong></p>
                  <div className="card-buttons" style={{display:'flex', alignItems:'center', justifyContent:'center', gap:'5px'}}>
                    <input type="number" id={`qty-${product.id}`} defaultValue="1" min="1" style={{width: '50px', padding: '5px', textAlign:'center'}} />
                    <button onClick={() => handleAddToCart(product, 'list')}>Acheter</button>
                    <button onClick={() => handleViewDetail(product.id)} className="btn-detail">Détails</button>
                  </div>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* VUE DETAIL */}
        {view === 'detail' && selectedProduct && (
          <div className="form-section">
            <button onClick={() => setView('shop')} className="btn-back">← Retour</button>
            <div className="product-detail-layout">
              <div className="detail-image">
                {selectedProduct.image ? (
                    <img src={getImageUrl(selectedProduct.image)} alt={selectedProduct.nom} />
                ) : (
                    <div className="no-image-large">Pas d'image</div>
                )}
              </div>
              <div className="detail-info">
                <h2>{selectedProduct.nom}</h2>
                <p className="price">{selectedProduct.prix} €</p>
                <p className="description">{selectedProduct.description}</p>
                <div style={{display:'flex', gap:'10px', marginTop:'20px'}}>
                    <input type="number" id="qty-detail" defaultValue="1" min="1" style={{width: '60px', padding: '10px', fontSize:'16px'}} />
                    <button onClick={() => handleAddToCart(selectedProduct, 'detail')} className="btn-add">Ajouter au panier</button>
                </div>
              </div>
            </div>
          </div>
        )}

        {/* VUE CART */}
        {view === 'cart' && (
          <div className="form-section">
            <h2>Mon Panier</h2>
            {cart.length === 0 ? <p>Panier vide.</p> : (
              <div>
                {cart.map((item, idx) => (
                  <div key={item.cart_id || idx} className="cart-item">
                    <span>{item.nom} (x1)</span>
                    <span>{parseFloat(item.prix).toFixed(2)} € 
                      <button onClick={() => handleRemoveFromCart(item.cart_id)} className="btn-delete">X</button>
                    </span>
                  </div>
                ))}
                <h3 className="total">Total : {cart.reduce((t, i) => t + parseFloat(i.prix), 0).toFixed(2)} €</h3>
                <button onClick={handleCheckout} style={{width:'100%', background: '#27ae60'}}>Payer la commande</button>
              </div>
            )}
          </div>
        )}

        {/* VUE ORDERS */}
        {view === 'orders' && (
          <div className="form-section">
            <h2>Historique de mes commandes</h2>
            {orders.length === 0 ? <p>Aucune commande passée.</p> : (
              <table style={{width: '100%', borderCollapse: 'collapse', marginTop: '20px'}}>
                <thead>
                  <tr style={{borderBottom: '2px solid #333', textAlign: 'left'}}>
                    <th style={{padding: '10px'}}>N° Commande</th>
                    <th style={{padding: '10px'}}>Date</th>
                    <th style={{padding: '10px'}}>Total</th>
                    <th style={{padding: '10px'}}>Statut</th>
                  </tr>
                </thead>
                <tbody>
                  {orders.map(order => (
                    <tr key={order.id} style={{borderBottom: '1px solid #ddd'}}>
                      <td style={{padding: '10px'}}><strong>{order.numero_commande}</strong></td>
                      <td style={{padding: '10px'}}>{order.created_at}</td>
                      <td style={{padding: '10px'}}><strong>{parseFloat(order.total).toFixed(2)} €</strong></td>
                      <td style={{padding: '10px'}}>{order.statut}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            )}
            <button onClick={() => setView('shop')} style={{marginTop: '20px'}}>Retour boutique</button>
          </div>
        )}

        {/* VUE LOGIN */}
        {view === 'login' && (
          <div className="form-section">
            <h2>Connexion</h2>
            <form onSubmit={handleLogin}>
              <div className="form-group"><label>Email</label><input name="email" type="email" required /></div>
              <div className="form-group"><label>Mot de passe</label><input name="password" type="password" required /></div>
              <button type="submit">Se connecter</button>
            </form>
            <p style={{marginTop:'15px'}}>
                Pas encore de compte ? <button onClick={() => setView('register')} style={{background:'none', border:'none', color:'#3498db', cursor:'pointer', textDecoration:'underline'}}>Créer un compte</button>
            </p>
          </div>
        )}

        {/* VUE REGISTER */}
        {view === 'register' && (
          <div className="form-section">
            <h2>Créer un compte</h2>
            <form onSubmit={handleRegister}>
              <div className="form-group"><label>Nom</label><input name="nom" required /></div>
              <div className="form-group"><label>Prénom</label><input name="prenom" required /></div>
              <div className="form-group"><label>Email</label><input name="email" type="email" required /></div>
              <div className="form-group"><label>Mot de passe</label><input name="password" type="password" required /></div>
              
              <h3 style={{fontSize:'16px', marginTop:'20px'}}>Adresse de livraison</h3>
              <div className="form-group"><label>Adresse</label><input name="adresse" placeholder="10 rue de la paix" required /></div>
              <div className="form-group"><label>Ville</label><input name="ville" required /></div>
              <div className="form-group"><label>Code Postal</label><input name="code_postal" required /></div>

              <button type="submit" style={{background:'#27ae60'}}>S'inscrire</button>
            </form>
            <p style={{marginTop:'15px'}}>
                Déjà un compte ? <button onClick={() => setView('login')} style={{background:'none', border:'none', color:'#3498db', cursor:'pointer', textDecoration:'underline'}}>Se connecter</button>
            </p>
          </div>
        )}

      </div>
    </div>
  );
}

export default App;