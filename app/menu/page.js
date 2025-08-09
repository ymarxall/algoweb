// app/menu/page.js
'use client'
import { useState } from 'react'
import { useRouter } from 'next/navigation'
import Footer from '../components/Footer'

export default function MenuPage() {
  const router = useRouter()
  const [activeCategory, setActiveCategory] = useState('Drink')
  const [searchQuery, setSearchQuery] = useState('')
  const [cart, setCart] = useState([])
  const [selectedItem, setSelectedItem] = useState(null)

  const menuItems = [
    {
      id: 1,
      name: 'Palm Sugar Milk Coffee',
      price: 'Rp18.000',
      image: '/palm-sugar-coffee.jpg',
      category: 'Coffee',
      isPromo: false,
      description: 'Rich coffee with palm sugar sweetness'
    },
    {
      id: 2,
      name: 'Taro',
      price: 'Rp15.000',
      image: '/taro.JPG',
      category: 'Coffee',
      isPromo: false,
      description: 'Creamy taro flavored drink'
    },
    {
      id: 3,
      name: 'Coffee Milk',
      price: 'Rp15.000',
      image: '/coffee-milk.jpg',
      category: 'Drink',
      isPromo: false,
      description: 'Perfect blend of coffee and milk'
    },
    {
      id: 4,
      name: 'Green Tea',
      price: 'Rp15.000',
      image: '/green-tea.jpg',
      category: 'Drink',
      isPromo: false,
      description: 'Refreshing green tea'
    },
    {
      id: 5,
      name: 'Red Velvet',
      price: 'Rp15.000',
      image: '/red-velvet.jpg',
      category: 'Drink',
      isPromo: false,
      description: 'Rich and creamy red velvet'
    },
    {
      id: 6,
      name: 'Vanilla',
      price: 'Rp15.000',
      image: '/vanilla.JPG',
      category: 'Drink',
      isPromo: false,
      description: 'Classic vanilla flavor'
    },
    {
      id: 7,
      name: 'Thai Tea',
      price: 'Rp15.000',
      image: '/thaitea.jpg',
      category: 'Drink',
      isPromo: false,
      description: 'Authentic Thai tea'
    }
  ]

  const categories = ['Drink', 'Coffee', 'Fruity', 'Go']

  const filteredItems = activeCategory === 'Drink'
    ? menuItems.filter(item => item.name.toLowerCase().includes(searchQuery.toLowerCase()))
    : menuItems.filter(item => item.category === activeCategory && item.name.toLowerCase().includes(searchQuery.toLowerCase()))

  // Cart management functions
  const addToCart = (item) => {
    setCart(prevCart => {
      const existingItem = prevCart.find(cartItem => cartItem.id === item.id)
      if (existingItem) {
        return prevCart.map(cartItem =>
          cartItem.id === item.id ? { ...cartItem, quantity: cartItem.quantity + 1 } : cartItem
        )
      }
      return [...prevCart, { ...item, quantity: 1 }]
    })
  }

  const removeFromCart = (id) => {
    setCart(prevCart => {
      const existingItem = prevCart.find(cartItem => cartItem.id === id)
      if (existingItem && existingItem.quantity > 1) {
        return prevCart.map(cartItem =>
          cartItem.id === id ? { ...cartItem, quantity: cartItem.quantity - 1 } : cartItem
        )
      }
      return prevCart.filter(cartItem => cartItem.id !== id)
    })
  }

  const clearCart = () => {
    setCart([])
  }

  const openItemDetail = (item) => {
    setSelectedItem(item)
  }

  const closeItemDetail = () => {
    setSelectedItem(null)
  }

  const handleCheckout = () => {
    if (cart.length === 0) return
    
    // Calculate total
    const total = cart.reduce((sum, cartItem) => {
      const price = parseInt(cartItem.price.replace('Rp', '').replace('.', ''))
      return sum + (price * cartItem.quantity)
    }, 0)
    
    // Store cart data in localStorage for the purchase page
    const checkoutData = {
      items: cart,
      total: total,
      timestamp: new Date().toISOString()
    }
    
    localStorage.setItem('checkoutData', JSON.stringify(checkoutData))
    router.push('/beli')
  }

  // Component untuk menampilkan gambar dengan fallback
  const ProductImage = ({ src, alt, className }) => {
    const [imageError, setImageError] = useState(false)
    
    return (
      <div className={`relative overflow-hidden ${className}`}>
        {!imageError ? (
          <img 
            src={src} 
            alt={alt}
            className="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
            onError={() => setImageError(true)}
            onLoad={() => setImageError(false)}
          />
        ) : (
          <div className="w-full h-full bg-gradient-to-br from-amber-100 to-orange-200 flex items-center justify-center">
            <div className="text-center">
              <div className="w-12 h-12 mx-auto mb-2 bg-white/80 rounded-full flex items-center justify-center">
                <svg className="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fillRule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clipRule="evenodd" />
                </svg>
              </div>
              <p className="text-xs text-orange-700 font-medium">{alt}</p>
            </div>
          </div>
        )}
      </div>
    )
  }

  // Cart Component
  const Cart = ({ cart, onAddItem, onRemoveItem, onClearCart, onCheckout }) => {
    const parsePrice = (priceStr) => {
      return parseInt(priceStr.replace('Rp', '').replace('.', ''), 10)
    }
  
    const totalPrice = cart.reduce((sum, cartItem) => sum + (parsePrice(cartItem.price) * cartItem.quantity), 0)
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0)
  
    if (cart.length === 0) return null
  
    return (
      <div className="fixed bottom-24 left-0 right-0 z-20 px-4">
        <div className="max-w-[380px] mx-auto">
          <div className="bg-white/95 backdrop-blur-lg rounded-2xl p-4 shadow-xl border border-white/50">
            {/* Header - More Compact */}
            <div className="flex items-center justify-between mb-3">
              <h2 className="text-sm font-bold text-gray-800 flex items-center">
                <svg className="w-4 h-4 mr-1.5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4m2.6 8L7 13m0 0L5.4 5M7 13l-.6 3.2M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cart ({totalItems})
              </h2>
              <div className="flex items-center gap-2">
                <span className="text-lg font-bold text-orange-600">
                  Rp{totalPrice.toLocaleString()}
                </span>
                {/* Clear Cart Button - Smaller */}
                <button 
                  onClick={onClearCart}
                  className="w-7 h-7 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors"
                  title="Kosongkan keranjang"
                >
                  <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
            </div>
            
            {/* Cart Items - Reduced Height with thin scrollbar */}
            <div className="space-y-2 max-h-24 overflow-y-auto pr-2 thin-scrollbar">
              {cart.map((cartItem) => (
                <div key={cartItem.id} className="flex justify-between items-center bg-orange-50 rounded-xl p-2.5">
                  <div className="flex-1 min-w-0">
                    <span className="text-xs font-medium text-gray-800 block truncate">
                      {cartItem.name}
                    </span>
                    <span className="text-xs text-gray-500">
                      {cartItem.price} x {cartItem.quantity}
                    </span>
                  </div>
                  <div className="flex items-center gap-1.5">
                    {/* Remove Button - Smaller */}
                    <button 
                      onClick={() => onRemoveItem(cartItem.id)}
                      className="w-5 h-5 bg-red-100 text-red-600 rounded-md flex items-center justify-center hover:bg-red-200 transition-colors"
                    >
                      <svg className="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 12H4" />
                      </svg>
                    </button>
                    
                    {/* Item Total Price - Smaller */}
                    <span className="text-xs font-bold text-orange-600 min-w-[50px] text-center">
                      Rp{(parsePrice(cartItem.price) * cartItem.quantity).toLocaleString()}
                    </span>
                    
                    {/* Add Button - Smaller */}
                    <button 
                      onClick={() => onAddItem(cartItem)}
                      className="w-5 h-5 bg-orange-100 text-orange-600 rounded-md flex items-center justify-center hover:bg-orange-200 transition-colors"
                    >
                      <svg className="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                      </svg>
                    </button>
                  </div>
                </div>
              ))}
            </div>
            
            {/* Checkout Button - Smaller */}
            <button 
              onClick={onCheckout}
              className="w-full mt-3 bg-gradient-to-r from-orange-400 to-red-400 text-white font-bold py-2.5 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 text-sm"
            >
              Checkout Sekarang
            </button>
          </div>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-red-50 relative">
      {/* Custom scrollbar styles - Thin scrollbar */}
      <style jsx global>{`
        .thin-scrollbar::-webkit-scrollbar {
          width: 3px;
          height: 3px;
        }
        .thin-scrollbar::-webkit-scrollbar-track {
          background: rgba(0, 0, 0, 0.05);
          border-radius: 10px;
        }
        .thin-scrollbar::-webkit-scrollbar-thumb {
          background: rgba(251, 146, 60, 0.4);
          border-radius: 10px;
        }
        .thin-scrollbar::-webkit-scrollbar-thumb:hover {
          background: rgba(251, 146, 60, 0.6);
        }
        
        /* For Firefox */
        .thin-scrollbar {
          scrollbar-width: thin;
          scrollbar-color: rgba(251, 146, 60, 0.4) rgba(0, 0, 0, 0.05);
        }
      `}</style>

      {/* Header */}
      <div className="bg-white/80 backdrop-blur-lg border-b border-orange-100 sticky top-0 z-10">
        <div className="px-4 py-4">
          <h1 className="text-2xl font-bold text-gray-800 text-center">Our Menu</h1>
        </div>
      </div>

      {/* Search Bar */}
      <div className="px-4 pt-6 mb-6">
        <div className="relative">
          <input
            type="text"
            placeholder="Cari menu favorit kamu..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            className="w-full px-4 py-3 pl-12 bg-white/90 backdrop-blur-sm text-gray-800 rounded-2xl border border-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent placeholder-gray-500 shadow-sm"
          />
          <svg className="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
      </div>

      {/* Promo Banner */}
      <div className="px-4 mb-6">
        <div className="bg-gradient-to-r from-orange-400 to-red-400 rounded-3xl p-6 relative overflow-hidden shadow-lg">
          <div className="absolute top-4 left-4">
            <span className="bg-white/90 text-orange-600 px-3 py-1 rounded-full text-sm font-bold shadow-sm">
              🔥 HOT PROMO
            </span>
          </div>
          <div className="pt-8">
            <h2 className="text-white text-3xl font-bold mb-2 drop-shadow-lg">
              Buy One<br />Get One FREE
            </h2>
            <p className="text-white/90 text-sm">Berlaku untuk semua minuman</p>
          </div>
          <div className="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
          <div className="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
        </div>
      </div>

      {/* Category Tabs with thin scrollbar */}
      <div className="px-4 mb-8">
        <div className="flex gap-3 overflow-x-auto thin-scrollbar pb-2">
          {categories.map((category) => (
            <button
              key={category}
              onClick={() => setActiveCategory(category)}
              className={`px-6 py-3 rounded-2xl whitespace-nowrap transition-all duration-300 text-sm font-bold shadow-sm flex-shrink-0 ${
                activeCategory === category
                  ? 'bg-gradient-to-r from-orange-400 to-red-400 text-white shadow-md transform scale-105'
                  : 'bg-white/80 text-gray-600 hover:bg-white hover:text-orange-600 hover:shadow-md'
              }`}
            >
              {category}
            </button>
          ))}
        </div>
      </div>

      {/* Menu Items Grid */}
      <div className="px-4 pb-32">
        <div className="grid grid-cols-2 gap-4">
          {filteredItems.map((item) => (
            <div key={item.id} className="group">
              <div 
                className="bg-white/90 backdrop-blur-sm rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-white/50 cursor-pointer"
                onClick={() => openItemDetail(item)}
              >
                {/* Image Container */}
                <div className="relative h-40 bg-gradient-to-br from-orange-100 to-red-100">
                  <ProductImage 
                    src={item.image} 
                    alt={item.name}
                    className="rounded-t-3xl h-full"
                  />
                  
                  {/* Favorite Button */}
                  <button 
                    onClick={(e) => e.stopPropagation()}
                    className="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center shadow-md hover:bg-white transition-colors hover:scale-110"
                  >
                    <svg className="w-4 h-4 text-red-400 hover:text-red-500 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                      <path fillRule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clipRule="evenodd" />
                    </svg>
                  </button>

                  {/* Promo Badge */}
                  {item.isPromo && (
                    <div className="absolute top-3 left-3">
                      <span className="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold shadow-sm">
                        PROMO
                      </span>
                    </div>
                  )}
                </div>

                {/* Product Info */}
                <div className="p-4">
                  <h3 className="font-bold text-gray-800 mb-1 text-sm leading-tight group-hover:text-orange-600 transition-colors">
                    {item.name}
                  </h3>
                  <p className="text-xs text-gray-500 mb-3 line-clamp-2">
                    {item.description}
                  </p>
                  
                  {/* Price and Add Button */}
                  <div className="flex items-center justify-between">
                    <div>
                      <span className="text-lg font-bold text-orange-600">
                        {item.price}
                      </span>
                    </div>
                    <button 
                      onClick={(e) => {
                        e.stopPropagation()
                        addToCart(item)
                      }}
                      className="w-10 h-10 bg-gradient-to-r from-orange-400 to-red-400 rounded-2xl flex items-center justify-center shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200 active:scale-95"
                    >
                      <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={3} d="M12 4v16m8-8H4" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Item Detail Modal/Popup */}
      {selectedItem && (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
          <div className="bg-white rounded-3xl p-6 w-full max-w-sm relative animate-scale-up shadow-2xl">
            {/* Close Button */}
            <button 
              onClick={closeItemDetail}
              className="absolute top-4 right-4 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors z-10"
            >
              <svg className="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>

            {/* Product Image */}
            <div className="w-48 h-48 mx-auto mb-6 rounded-3xl overflow-hidden shadow-lg">
              <ProductImage 
                src={selectedItem.image} 
                alt={selectedItem.name}
                className="w-full h-full"
              />
            </div>

            {/* Product Info */}
            <div className="text-center">
              {selectedItem.isPromo && (
                <div className="flex justify-center mb-2">
                  <span className="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                    PROMO
                  </span>
                </div>
              )}
              
              <h2 className="text-2xl font-bold text-gray-800 mb-2">{selectedItem.name}</h2>
              <p className="text-gray-600 text-sm mb-4 px-4">{selectedItem.description}</p>
              <p className="text-3xl font-bold text-orange-600 mb-6">{selectedItem.price}</p>
              
              {/* Add to Cart Button */}
              <button 
                onClick={() => {
                  addToCart(selectedItem)
                  closeItemDetail()
                }}
                className="w-full bg-gradient-to-r from-orange-400 to-red-400 text-white py-4 px-6 rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 active:scale-95"
              >
                Tambah ke Keranjang
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Cart Component */}
      <Cart 
        cart={cart}
        onAddItem={addToCart}
        onRemoveItem={removeFromCart}
        onClearCart={clearCart}
        onCheckout={handleCheckout}
      />

      {/* Footer Component */}
      <Footer activeTab="menu" leftMargin={16} rightMargin={16} />

      {/* Add animations */}
      <style jsx>{`
        @keyframes scale-up {
          from {
            transform: scale(0.9);
            opacity: 0;
          }
          to {
            transform: scale(1);
            opacity: 1;
          }
        }
        
        .animate-scale-up {
          animation: scale-up 0.3s ease-out;
        }
      `}</style>
    </div>
  )
}