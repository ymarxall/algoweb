// app/home/page.js (Main Home Page after landing)
'use client'
import { useState, useEffect } from 'react'
import { useRouter } from 'next/navigation'
import Footer from '../components/Footer'

export default function HomePage() {
  const router = useRouter()
  const [searchQuery, setSearchQuery] = useState('')
  const [favoriteItems, setFavoriteItems] = useState([])
  const [greeting, setGreeting] = useState('')
  const [greetingEmoji, setGreetingEmoji] = useState('')
  const [cartItems, setCartItems] = useState([])
  const [showCart, setShowCart] = useState(false)
  const [selectedItem, setSelectedItem] = useState(null)

  // Set greeting based on current time
  useEffect(() => {
    const now = new Date()
    const hour = now.getHours()
    
    if (hour >= 5 && hour < 12) {
      setGreeting('Selamat pagi')
      setGreetingEmoji('☀️')
    } else if (hour >= 12 && hour < 15) {
      setGreeting('Selamat siang')
      setGreetingEmoji('🌤️')
    } else if (hour >= 15 && hour < 18) {
      setGreeting('Selamat sore')
      setGreetingEmoji('🌅')
    } else {
      setGreeting('Selamat malam')
      setGreetingEmoji('🌙')
    }
  }, [])

  // Data untuk featured items
  const featuredDrinks = [
    {
      id: 1,
      name: 'Palm Sugar Latte',
      price: 'Rp18.000',
      image: '/palm-sugar-coffee.jpg',
      isPopular: true,
      discount: '20%',
      description: 'Kopi latte dengan gula aren asli yang memberikan rasa manis alami'
    },
    {
      id: 2,
      name: 'Taro Milk Tea',
      price: 'Rp15.000',
      image: '/taro.JPG',
      isPopular: true,
      description: 'Minuman taro creamy dengan rasa yang lezat dan menyegarkan'
    },
    {
      id: 3,
      name: 'Thai Tea Original',
      price: 'Rp15.000',
      image: '/thaitea.jpg',
      isNew: true,
      description: 'Thai tea otentik dengan rasa manis dan creamy yang khas'
    },
    {
      id: 4,
      name: 'Vanilla Smoothie',
      price: 'Rp15.000',
      image: '/vanilla.JPG',
      description: 'Smoothie vanilla yang lembut dan menyegarkan'
    }
  ]

  // Categories untuk quick access
  const categories = [
    { name: 'Coffee', icon: '☕', color: 'from-amber-400 to-orange-500' },
    { name: 'Tea', icon: '🍵', color: 'from-green-400 to-emerald-500' },
    { name: 'Special', icon: '⭐', color: 'from-purple-400 to-indigo-500' }
  ]

  const toggleFavorite = (itemId) => {
    setFavoriteItems(prev => 
      prev.includes(itemId) 
        ? prev.filter(id => id !== itemId)
        : [...prev, itemId]
    )
  }

  const addToCart = (item) => {
    setCartItems(prev => {
      const existingItem = prev.find(cartItem => cartItem.id === item.id)
      if (existingItem) {
        return prev.map(cartItem =>
          cartItem.id === item.id 
            ? { ...cartItem, quantity: cartItem.quantity + 1 }
            : cartItem
        )
      } else {
        return [...prev, { ...item, quantity: 1 }]
      }
    })
  }

  const handlePromoClick = () => {
    router.push('/menu')
  }

  const openItemDetail = (item) => {
    setSelectedItem(item)
  }

  const closeItemDetail = () => {
    setSelectedItem(null)
  }

  const updateCartQuantity = (itemId, newQuantity) => {
    if (newQuantity <= 0) {
      setCartItems(prev => prev.filter(item => item.id !== itemId))
    } else {
      setCartItems(prev => 
        prev.map(item => 
          item.id === itemId ? { ...item, quantity: newQuantity } : item
        )
      )
    }
  }

  const removeFromCart = (itemId) => {
    setCartItems(prev => prev.filter(item => item.id !== itemId))
  }

  const getTotalPrice = () => {
    return cartItems.reduce((total, item) => {
      const price = parseInt(item.price.replace('Rp', '').replace('.', ''))
      return total + (price * item.quantity)
    }, 0)
  }

  const formatPrice = (price) => {
    return `Rp${price.toLocaleString('id-ID')}`
  }

  const handleCheckout = () => {
    if (cartItems.length === 0) return
    
    // Store cart data in localStorage for the purchase page
    const checkoutData = {
      items: cartItems,
      total: getTotalPrice(),
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
            className="w-full h-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
            onError={() => setImageError(true)}
            onLoad={() => setImageError(false)}
          />
        ) : (
          <div className="w-full h-full bg-gradient-to-br from-amber-100 to-orange-200 flex items-center justify-center">
            <div className="text-center">
              <div className="w-8 h-8 mx-auto mb-1 bg-white/80 rounded-full flex items-center justify-center">
                <svg className="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
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

      {/* Header dengan greeting */}
      <div className="px-4 pt-8 pb-4">
        <div className="flex justify-between items-center mb-6">
          <div>
            <p className="text-gray-600 text-sm">{greeting} {greetingEmoji}</p>
            <h1 className="text-2xl font-bold text-gray-800">Mau minum apa hari ini?</h1>
          </div>
        </div>

        {/* Search Bar */}
        <div className="relative mb-6">
          <input
            type="text"
            placeholder="Cari minuman favorit kamu..."
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
            className="w-full px-4 py-4 pl-12 bg-white/90 backdrop-blur-sm text-gray-800 rounded-2xl border border-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent placeholder-gray-500 shadow-sm"
          />
          <svg className="absolute left-4 top-4 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
      </div>

      {/* Promo Banner */}
      <div className="px-4 mb-6">
        <div className="bg-gradient-to-r from-orange-400 via-red-400 to-pink-400 rounded-3xl p-6 relative overflow-hidden shadow-xl">
          {/* Background decorations */}
          <div className="absolute -right-8 -top-8 w-32 h-32 bg-white/20 rounded-full"></div>
          <div className="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full"></div>
          <div className="absolute -left-6 top-6 w-16 h-16 bg-white/10 rounded-full"></div>
          
          <div className="relative z-10">
            <div className="flex justify-between items-start">
              <div>
                <div className="bg-white/90 text-orange-600 px-3 py-1 rounded-full text-sm font-bold mb-4 inline-block shadow-sm">
                  🎉 PROMO SPESIAL
                </div>
                <h2 className="text-white text-2xl font-bold mb-2 drop-shadow-lg">
                  Buy 2 Get 1 FREE
                </h2>
                <p className="text-white/90 text-sm mb-4">Berlaku untuk semua minuman favorit!</p>
                <button 
                  onClick={handlePromoClick}
                  className="bg-white text-orange-600 px-6 py-2 rounded-2xl font-bold text-sm shadow-lg hover:bg-orange-50 transition-colors"
                >
                  Pesan Sekarang
                </button>
              </div>
              <div className="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center transform -rotate-6">
                <span className="text-3xl">🎁</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Quick Categories */}
      <div className="px-4 mb-8">
        <h3 className="text-lg font-bold text-gray-800 mb-4">Kategori Populer</h3>
        <div className="grid grid-cols-3 gap-3">
          {categories.map((category, index) => (
            <button 
              key={index}
              className="group p-4 bg-white/90 backdrop-blur-sm rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-white/50"
            >
              <div className={`w-12 h-12 mx-auto mb-2 bg-gradient-to-r ${category.color} rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg`}>
                <span className="text-xl">{category.icon}</span>
              </div>
              <p className="text-sm font-semibold text-gray-700 group-hover:text-orange-600 transition-colors">
                {category.name}
              </p>
            </button>
          ))}
        </div>
      </div>

      {/* Featured Drinks with thin scrollbar */}
      <div className="px-4 pb-32">
        <div className="flex justify-between items-center mb-4">
          <h3 className="text-lg font-bold text-gray-800">Minuman Populer</h3>
          <button className="text-orange-600 font-semibold text-sm hover:text-orange-700 transition-colors">
            Lihat Semua →
          </button>
        </div>

        <div className="space-y-4 thin-scrollbar overflow-y-auto max-h-[400px] pr-2">
          {featuredDrinks.map((item) => (
            <div key={item.id} className="group bg-white/90 backdrop-blur-sm rounded-3xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-white/50">
              <div className="flex items-center space-x-4">
                {/* Product Image - Clickable */}
                <div 
                  className="relative w-20 h-20 flex-shrink-0 overflow-hidden rounded-2xl cursor-pointer"
                  onClick={() => openItemDetail(item)}
                >
                  <ProductImage 
                    src={item.image} 
                    alt={item.name}
                    className="w-full h-full shadow-md"
                  />
                  
                  {/* Badges */}
                  {item.isPopular && (
                    <div className="absolute -top-1 -left-1 bg-orange-500 text-white px-2 py-0.5 rounded-full text-xs font-bold shadow-lg">
                      🔥 Popular
                    </div>
                  )}
                  {item.isNew && (
                    <div className="absolute -top-1 -left-1 bg-green-500 text-white px-2 py-0.5 rounded-full text-xs font-bold shadow-lg">
                      ✨ New
                    </div>
                  )}
                  {item.discount && (
                    <div className="absolute -top-1 -right-1 bg-red-500 text-white px-2 py-0.5 rounded-full text-xs font-bold shadow-lg">
                      -{item.discount}
                    </div>
                  )}
                </div>

                {/* Product Info - Clickable */}
                <div 
                  className="flex-1 cursor-pointer"
                  onClick={() => openItemDetail(item)}
                >
                  <div className="flex justify-between items-start mb-3">
                    <h4 className="font-bold text-gray-800 text-sm group-hover:text-orange-600 transition-colors line-clamp-1">
                      {item.name}
                    </h4>
                    <button 
                      onClick={(e) => {
                        e.stopPropagation()
                        toggleFavorite(item.id)
                      }}
                      className={`p-1 rounded-full transition-colors ${
                        favoriteItems.includes(item.id) 
                          ? 'text-red-500' 
                          : 'text-gray-400 hover:text-red-500'
                      }`}
                    >
                      <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clipRule="evenodd" />
                      </svg>
                    </button>
                  </div>

                  {/* Price and Add Button */}
                  <div className="flex justify-between items-center">
                    <span className="text-lg font-bold text-orange-600">
                      {item.price}
                    </span>
                    <button 
                      onClick={(e) => {
                        e.stopPropagation()
                        addToCart(item)
                      }}
                      className="bg-gradient-to-r from-orange-400 to-red-400 text-white p-2 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200 active:scale-95"
                    >
                      <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

      {/* Footer */}
      <Footer 
        activeTab="home" 
        leftMargin={16} 
        rightMargin={16}
        onCartClick={() => setShowCart(true)}
        cartCount={cartItems.reduce((sum, item) => sum + item.quantity, 0)}
      />

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
              <div className="flex justify-center mb-2">
                {selectedItem.isPopular && (
                  <span className="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold mr-2">
                    🔥 Popular
                  </span>
                )}
                {selectedItem.isNew && (
                  <span className="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold mr-2">
                    ✨ New
                  </span>
                )}
                {selectedItem.discount && (
                  <span className="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                    -{selectedItem.discount}
                  </span>
                )}
              </div>
              
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

      {/* Cart Modal */}
      {showCart && (
        <div className="fixed inset-0 bg-black/50 flex items-end justify-center z-50 backdrop-blur-sm">
          <div className="bg-white rounded-t-3xl p-6 w-full max-w-sm max-h-[70vh] flex flex-col mb-20 animate-slide-up shadow-2xl">
            <div className="flex justify-between items-center mb-6">
              <h2 className="text-xl font-bold text-gray-800">Keranjang</h2>
              <button 
                onClick={() => setShowCart(false)}
                className="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 transition-colors"
              >
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            {cartItems.length === 0 ? (
              <div className="text-center py-12">
                <div className="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                  <svg className="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h12" />
                  </svg>
                </div>
                <p className="text-gray-500">Keranjang masih kosong</p>
                <p className="text-sm text-gray-400 mt-1">Yuk, pilih minuman favorit kamu!</p>
              </div>
            ) : (
              <>
                <div className="flex-1 overflow-y-auto space-y-4 mb-6 thin-scrollbar pr-2">
                  {cartItems.map((item) => (
                    <div key={item.id} className="flex items-center space-x-3 bg-gray-50 rounded-2xl p-3">
                      <div className="w-12 h-12 bg-orange-200 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span className="text-lg">☕</span>
                      </div>
                      
                      <div className="flex-1">
                        <h4 className="font-semibold text-gray-800 text-sm">{item.name}</h4>
                        <p className="text-orange-600 font-bold text-sm">{item.price}</p>
                      </div>

                      <div className="flex items-center space-x-2">
                        <button 
                          onClick={() => updateCartQuantity(item.id, item.quantity - 1)}
                          className="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 hover:bg-orange-200 transition-colors"
                        >
                          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 12H4" />
                          </svg>
                        </button>
                        
                        <span className="w-8 text-center font-semibold text-gray-800">{item.quantity}</span>
                        
                        <button 
                          onClick={() => updateCartQuantity(item.id, item.quantity + 1)}
                          className="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white hover:bg-orange-600 transition-colors"
                        >
                          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                          </svg>
                        </button>
                      </div>

                      <button 
                        onClick={() => removeFromCart(item.id)}
                        className="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50 transition-colors"
                      >
                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  ))}
                </div>

                <div className="border-t pt-4">
                  <div className="flex justify-between items-center mb-4">
                    <span className="text-lg font-bold text-gray-800">Total:</span>
                    <span className="text-xl font-bold text-orange-600">
                      {formatPrice(getTotalPrice())}
                    </span>
                  </div>
                  
                  <button 
                    onClick={handleCheckout}
                    className="w-full bg-gradient-to-r from-orange-400 to-red-400 text-white py-3 rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 active:scale-95"
                  >
                    Checkout ({cartItems.reduce((sum, item) => sum + item.quantity, 0)} items)
                  </button>
                </div>
              </>
            )}
          </div>
        </div>
      )}

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
        
        @keyframes slide-up {
          from {
            transform: translateY(100%);
          }
          to {
            transform: translateY(0);
          }
        }
        
        .animate-scale-up {
          animation: scale-up 0.3s ease-out;
        }
        
        .animate-slide-up {
          animation: slide-up 0.3s ease-out;
        }
      `}</style>
    </div>
  )
}