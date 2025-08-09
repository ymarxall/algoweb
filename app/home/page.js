// app/home/page.js (Main Home Page after landing)
'use client'
import { useState } from 'react'
import Footer from '../components/Footer'

export default function HomePage() {
  const [searchQuery, setSearchQuery] = useState('')
  const [favoriteItems, setFavoriteItems] = useState([])

  // Data untuk featured items
  const featuredDrinks = [
    {
      id: 1,
      name: 'Palm Sugar Latte',
      price: 'Rp18.000',
      rating: 4.8,
      image: '/palm-sugar-coffee.jpg',
      isPopular: true,
      discount: '20%'
    },
    {
      id: 2,
      name: 'Taro Milk Tea',
      price: 'Rp15.000',
      rating: 4.7,
      image: '/taro.JPG',
      isPopular: true
    },
    {
      id: 3,
      name: 'Thai Tea Original',
      price: 'Rp15.000',
      rating: 4.6,
      image: '/thaitea.jpg',
      isNew: true
    },
    {
      id: 4,
      name: 'Vanilla Smoothie',
      price: 'Rp15.000',
      rating: 4.5,
      image: '/vanilla.JPG'
    }
  ]

  // Categories untuk quick access
  const categories = [
    { name: 'Coffee', icon: '☕', color: 'from-amber-400 to-orange-500' },
    { name: 'Tea', icon: '🍵', color: 'from-green-400 to-emerald-500' },
    { name: 'Smoothie', icon: '🥤', color: 'from-pink-400 to-rose-500' },
    { name: 'Special', icon: '⭐', color: 'from-purple-400 to-indigo-500' }
  ]

  const toggleFavorite = (itemId) => {
    setFavoriteItems(prev => 
      prev.includes(itemId) 
        ? prev.filter(id => id !== itemId)
        : [...prev, itemId]
    )
  }

  // Component untuk menampilkan gambar dengan fallback (diperbaiki agar lebih responsif)
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
      {/* Header dengan greeting */}
      <div className="px-4 pt-8 pb-4">
        <div className="flex justify-between items-center mb-6">
          <div>
            <p className="text-gray-600 text-sm">Selamat pagi ☀️</p>
            <h1 className="text-2xl font-bold text-gray-800">Mau minum apa hari ini?</h1>
          </div>
          <div className="relative">
            <button className="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg flex items-center justify-center border border-white/50">
              <svg className="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 17h5l-5 5v-5z" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10.375 17L9.5 21l-.875-4" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2 12h20" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 8l4-4m0 0l4 4m-4-4v12" />
              </svg>
            </button>
            {/* Notification dot */}
            <div className="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center animate-pulse">
              <span className="text-xs text-white font-bold">3</span>
            </div>
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
          <button className="absolute right-4 top-4 text-orange-500">
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
            </svg>
          </button>
        </div>
      </div>

      {/* Promo Banner (diperbaiki agar lebih responsif) */}
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
                <button className="bg-white text-orange-600 px-6 py-2 rounded-2xl font-bold text-sm shadow-lg hover:bg-orange-50 transition-colors">
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

      {/* Quick Categories (diperbaiki spacing) */}
      <div className="px-4 mb-8">
        <h3 className="text-lg font-bold text-gray-800 mb-4">Kategori Populer</h3>
        <div className="grid grid-cols-4 gap-3">
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

      {/* Featured Drinks (diperbaiki hover dan image scaling) */}
      <div className="px-4 pb-32">
        <div className="flex justify-between items-center mb-4">
          <h3 className="text-lg font-bold text-gray-800">Minuman Populer</h3>
          <button className="text-orange-600 font-semibold text-sm hover:text-orange-700 transition-colors">
            Lihat Semua →
          </button>
        </div>

        <div className="space-y-4">
          {featuredDrinks.map((item) => (
            <div key={item.id} className="group bg-white/90 backdrop-blur-sm rounded-3xl p-4 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-white/50">
              <div className="flex items-center space-x-4">
                {/* Product Image */}
                <div className="relative w-20 h-20 flex-shrink-0 overflow-hidden rounded-2xl">
                  <ProductImage 
                    src={item.image} 
                    alt={item.name}
                    className="w-full h-full shadow-md"
                  />
                  
                  {/* Badges (diperbaiki position) */}
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

                {/* Product Info */}
                <div className="flex-1">
                  <div className="flex justify-between items-start mb-1">
                    <h4 className="font-bold text-gray-800 text-sm group-hover:text-orange-600 transition-colors line-clamp-1">
                      {item.name}
                    </h4>
                    <button 
                      onClick={() => toggleFavorite(item.id)}
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

                  {/* Rating */}
                  <div className="flex items-center mb-2">
                    <div className="flex items-center">
                      <svg className="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                      </svg>
                      <span className="text-sm text-gray-600 ml-1">{item.rating}</span>
                      <span className="text-xs text-gray-400 ml-1">(125+)</span>
                    </div>
                  </div>

                  {/* Price and Add Button */}
                  <div className="flex justify-between items-center">
                    <span className="text-lg font-bold text-orange-600">
                      {item.price}
                    </span>
                    <button className="bg-gradient-to-r from-orange-400 to-red-400 text-white p-2 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200 active:scale-95">
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

        {/* Quick Stats (diperbaiki alignment) */}
        <div className="grid grid-cols-2 gap-4 mt-8">
          <div className="bg-gradient-to-r from-blue-400 to-cyan-400 rounded-3xl p-4 text-white shadow-md">
            <div className="text-2xl font-bold">150+</div>
            <div className="text-sm text-white/90">Happy Customers</div>
          </div>
          <div className="bg-gradient-to-r from-purple-400 to-pink-400 rounded-3xl p-4 text-white shadow-md">
            <div className="text-2xl font-bold">4.8⭐</div>
            <div className="text-sm text-white/90">Average Rating</div>
          </div>
        </div>
      </div>

      {/* Footer */}
      <Footer activeTab="home" leftMargin={16} rightMargin={16} />
    </div>
  )
}