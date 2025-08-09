'use client'
import { useState } from 'react'
import { useRouter } from 'next/navigation'

export default function Footer({ 
  activeTab = 'home',
  leftMargin = 16, 
  rightMargin = 16 
}) {
  const [active, setActive] = useState(activeTab)
  const router = useRouter()

  const navItems = [
    {
      id: 'home',
      label: 'Home',
      path: '/home',
      icon: (isActive) => (
        <svg className={`w-5 h-5 transition-all duration-300 ${isActive ? 'scale-110' : ''}`} fill={isActive ? 'currentColor' : 'none'} stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={isActive ? 0 : 2} d="M3 12l2-2m0 0l7-7 7 7m-9 5v6h4v-6m-6 0h6" />
          {isActive && <path d="M9 21V10.5a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5V21H9z" />}
        </svg>
      )
    },
    {
      id: 'menu',
      label: 'Menu',
      path: '/menu',
      icon: (isActive) => (
        <svg className={`w-5 h-5 transition-all duration-300 ${isActive ? 'scale-110' : ''}`} fill={isActive ? 'currentColor' : 'none'} stroke="currentColor" viewBox="0 0 24 24">
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={isActive ? 0 : 2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
      )
    }
  ]

  const handleNavClick = (item) => {
    setActive(item.id)
    router.push(item.path)
  }

  return (
    <>
      <div className="fixed bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white/80 to-transparent pointer-events-none" />
      
      <footer 
        className="fixed bottom-0 z-50"
        style={{
          left: `${leftMargin}px`,
          right: `${rightMargin}px`
        }}
      >
        <div className="mb-2 max-w-sm mx-auto">
          <div className="bg-white/90 backdrop-blur-xl border border-white/20 shadow-2xl rounded-3xl overflow-hidden">
            <div className="relative h-1 bg-gradient-to-r from-transparent via-orange-400 to-transparent">
              <div 
                className="absolute top-0 h-full w-1/2 bg-gradient-to-r from-orange-400 to-red-400 rounded-full transition-all duration-500 ease-out shadow-lg"
                style={{
                  transform: `translateX(${navItems.findIndex(item => item.id === active) * 100}%)`
                }}
              />
            </div>

            <div className="flex justify-around items-center py-2 px-4 relative">
              {navItems.map((item) => {
                const isActive = active === item.id
                return (
                  <button
                    key={item.id}
                    onClick={() => handleNavClick(item)}
                    className={`relative flex flex-col items-center justify-center p-2 rounded-2xl transition-all duration-300 transform ${
                      isActive 
                        ? 'text-white bg-gradient-to-br from-orange-400 to-red-400 shadow-lg scale-105 -translate-y-1' 
                        : 'text-gray-500 hover:text-orange-500 hover:bg-orange-50 active:scale-95'
                    } min-w-[70px]`}
                  >
                    <div className={`relative transition-all duration-300 ${
                      isActive ? 'drop-shadow-lg' : ''
                    }`}>
                      {item.icon(isActive)}
                    </div>
                    
                    <span className={`text-xs font-semibold mt-1 transition-all duration-300 ${
                      isActive 
                        ? 'text-white drop-shadow-sm' 
                        : 'text-gray-600'
                    }`}>
                      {item.label}
                    </span>

                    <div className={`absolute inset-0 rounded-2xl transition-all duration-300 ${
                      isActive ? 'bg-white/20' : 'bg-transparent'
                    }`} />
                  </button>
                )
              })}
            </div>
          </div>
        </div>

        <div className="h-safe-area-inset-bottom bg-transparent" />
      </footer>
    </>
  )
}