// app/page.js (Landing Page)
'use client'
import { useRouter } from 'next/navigation'
import Image from 'next/image'
import Footer from './components/Footer'

export default function LandingPage() {
  const router = useRouter()

  const handleMenuClick = () => {
    router.push('/menu')
  }

  return (
    <div className="h-screen bg-white flex flex-col relative overflow-hidden">
      {/* Gradient Layer */}
      <div className="absolute inset-x-0 bottom-0 h-3/4 bg-gradient-to-t from-[#C67C4E] to-transparent"></div>

      {/* Header dengan Logo */}
      <div className="flex justify-center pt-8 md:pt-12 pb-4">
        <div className="flex items-center">
          {/* Logo Image */}
          <div className="w-[120px] h-[120px] md:w-[150px] md:h-[150px]">
            <Image
              src="/algo.png"
              alt="Algo Logo"
              width={150}
              height={150}
              className="w-full h-full object-contain"
            />
          </div>
        </div>
      </div>

      {/* Main Content */}
      <div className="flex-1 flex flex-col justify-center px-8 pb-8">
        <div className="text-center relative z-10">
          <h1 className="text-[2rem] md:text-[2.5rem] font-bold text-white leading-[2.2rem] md:leading-[2.75rem] mb-3 md:mb-4 font-playfair">
            Coffee so good,<br />
            your taste buds<br />
            will love it.
          </h1>
          
          <p className="text-white text-[0.8rem] md:text-[0.85rem] leading-[1.1rem] md:leading-[1.2rem] mb-6 md:mb-8 font-normal font-open-sans">
            The best grain, the finest roast, the<br />
            powerful flavor.
          </p>
          
          {/* Menu Button */}
          <button
            onClick={handleMenuClick}
            className="bg-white text-[#C67C4E] px-12 md:px-16 py-3 rounded-none text-base md:text-lg font-medium uppercase tracking-wider hover:bg-gray-100 transition duration-300"
          >
            Lihat Menu
          </button>
        </div>
      </div>

    </div>
  )
}