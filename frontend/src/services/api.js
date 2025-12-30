const API_BASE_URL = "http://localhost/mini_mvc/backend/public";

export const login = async (credentials) => {
    const response = await fetch(`${API_BASE_URL}/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(credentials)
    });
    return await response.json();
};

export const register = async (userData) => {
    const response = await fetch(`${API_BASE_URL}/register`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userData)
    });
    return await response.json();
};

export const getProducts = async () => {
    const response = await fetch(`${API_BASE_URL}/products`);
    if (!response.ok) throw new Error('Erreur lors de la récupération des produits');
    return await response.json();
};

export const getProductById = async (id) => {
    const response = await fetch(`${API_BASE_URL}/product?id=${id}`);
    return await response.json();
};

export const getCart = async (userId) => {
    const response = await fetch(`${API_BASE_URL}/cart?user_id=${userId}`);
    return await response.json();
};

export const addToCart = async (cartData) => {
    const response = await fetch(`${API_BASE_URL}/cart/add`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(cartData) 
    });
    return await response.json();
};

export const removeFromCart = async (cartData) => {
    const response = await fetch(`${API_BASE_URL}/cart/remove`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(cartData) 
    });
    return await response.json();
};

export const placeOrder = async (orderData) => {
    const response = await fetch(`${API_BASE_URL}/order/create`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderData) 
    });
    return await response.json();
};

export const getOrders = async (userId) => {
    const response = await fetch(`${API_BASE_URL}/orders?user_id=${userId}`);
    return await response.json();
};
