// app/beli/page.js
'use client'
import { useState, useEffect } from 'react'
import { useRouter } from 'next/navigation'

export default function BeliPage() {
  const router = useRouter()
  const [orderData, setOrderData] = useState(null)
  const [paymentMethod, setPaymentMethod] = useState('cash')
  const [customerInfo, setCustomerInfo] = useState({
    name: '',
    phone: '',
    notes: ''
  })
  const [isProcessing, setIsProcessing] = useState(false)
  const [orderComplete, setOrderComplete] = useState(false)
  const [receiptData, setReceiptData] = useState(null)

  useEffect(() => {
    // Load order data from localStorage
    const checkoutData = localStorage.getItem('checkoutData')
    if (checkoutData) {
      const data = JSON.parse(checkoutData)
      setOrderData(data)
    } else {
      // Redirect back to home if no order data
      router.push('/home')
    }
  }, [router])

  const paymentMethods = [
    { id: 'cash', name: 'Tunai', icon: '💵', fee: 0 },
    { id: 'qris', name: 'QRIS', icon: '📱', fee: 0 },
    { id: 'gopay', name: 'GoPay', icon: '💳', fee: 0 },
    { id: 'dana', name: 'DANA', icon: '🏦', fee: 0 }
  ]

  const formatPrice = (price) => {
    return `Rp${price.toLocaleString('id-ID')}`
  }

  const calculateTotal = () => {
    if (!orderData) return 0
    const subtotal = orderData.total
    const selectedPayment = paymentMethods.find(method => method.id === paymentMethod)
    const fee = selectedPayment ? selectedPayment.fee : 0
    return subtotal + fee
  }

  const handleProcessOrder = async () => {
    if (!customerInfo.name || !customerInfo.phone) {
      alert('Mohon lengkapi nama dan nomor telepon')
      return
    }

    setIsProcessing(true)
    
    // Simulate payment processing
    setTimeout(() => {
      const receipt = {
        orderId: 'ORD' + Date.now(),
        customerName: customerInfo.name,
        customerPhone: customerInfo.phone,
        items: orderData.items,
        subtotal: orderData.total,
        paymentMethod: paymentMethods.find(method => method.id === paymentMethod).name,
        total: calculateTotal(),
        timestamp: new Date(),
        notes: customerInfo.notes
      }
      
      setReceiptData(receipt)
      setOrderComplete(true)
      setIsProcessing(false)
      
      // Clear checkout data
      localStorage.removeItem('checkoutData')
    }, 2000)
  }

  const downloadReceipt = () => {
    if (!receiptData) return

    const receiptContent = `
=================================
         COFFEE SHOP
      Struk Pembelian
=================================
Order ID: ${receiptData.orderId}
Tanggal: ${receiptData.timestamp.toLocaleDateString('id-ID')}
Waktu: ${receiptData.timestamp.toLocaleTimeString('id-ID')}

Customer: ${receiptData.customerName}
Phone: ${receiptData.customerPhone}

---------------------------------
DETAIL PESANAN:
---------------------------------
${receiptData.items.map(item => 
  `${item.name}\n${item.price} x ${item.quantity} = ${formatPrice(parseInt(item.price.replace('Rp', '').replace('.', '')) * item.quantity)}`
).join('\n\n')}

---------------------------------
Subtotal: ${formatPrice(receiptData.subtotal)}
Metode Bayar: ${receiptData.paymentMethod}
TOTAL: ${formatPrice(receiptData.total)}
---------------------------------

${receiptData.notes ? `Catatan: ${receiptData.notes}\n` : ''}
Terima kasih atas pesanan Anda!
=================================
    `

    const blob = new Blob([receiptContent], { type: 'text/plain' })
    const url = window.URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = `struk-${receiptData.orderId}.txt`
    document.body.appendChild(a)
    a.click()
    document.body.removeChild(a)
    window.URL.revokeObjectURL(url)
  }

  const handleBackToHome = () => {
    router.push('/home')
  }

  if (!orderData) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-red-50 flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-orange-500 mx-auto mb-4"></div>
          <p className="text-gray-600">Memuat data pesanan...</p>
        </div>
      </div>
    )
  }

  if (orderComplete && receiptData) {
    return (
      <div className="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-red-50 p-4">
        <div className="max-w-md mx-auto">
          {/* Success Header */}
          <div className="text-center mb-8 pt-8">
            <div className="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
              <svg className="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h1 className="text-2xl font-bold text-gray-800 mb-2">Pesanan Berhasil!</h1>
            <p className="text-gray-600">Terima kasih atas pesanan Anda</p>
          </div>

          {/* Receipt */}
          <div className="bg-white rounded-3xl shadow-xl p-6 mb-6">
            <div className="text-center border-b pb-4 mb-4">
              <h2 className="text-lg font-bold text-gray-800">COFFEE SHOP</h2>
              <p className="text-sm text-gray-600">Struk Pembelian</p>
            </div>

            <div className="space-y-3 text-sm">
              <div className="flex justify-between">
                <span className="text-gray-600">Order ID:</span>
                <span className="font-mono font-bold">{receiptData.orderId}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-gray-600">Tanggal:</span>
                <span>{receiptData.timestamp.toLocaleDateString('id-ID')}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-gray-600">Waktu:</span>
                <span>{receiptData.timestamp.toLocaleTimeString('id-ID')}</span>
              </div>
            </div>

            <div className="border-t mt-4 pt-4">
              <p className="text-sm text-gray-600 mb-1">Customer:</p>
              <p className="font-semibold">{receiptData.customerName}</p>
              <p className="text-sm text-gray-600">{receiptData.customerPhone}</p>
            </div>

            <div className="border-t mt-4 pt-4">
              <h3 className="font-bold text-gray-800 mb-3">Detail Pesanan:</h3>
              <div className="space-y-2">
                {receiptData.items.map((item, index) => (
                  <div key={index} className="flex justify-between items-center">
                    <div className="flex-1">
                      <p className="font-semibold text-sm">{item.name}</p>
                      <p className="text-xs text-gray-600">{item.price} x {item.quantity}</p>
                    </div>
                    <p className="font-bold text-orange-600">
                      {formatPrice(parseInt(item.price.replace('Rp', '').replace('.', '')) * item.quantity)}
                    </p>
                  </div>
                ))}
              </div>
            </div>

            <div className="border-t mt-4 pt-4 space-y-2">
              <div className="flex justify-between">
                <span className="text-gray-600">Subtotal:</span>
                <span className="font-semibold">{formatPrice(receiptData.subtotal)}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-gray-600">Metode Bayar:</span>
                <span className="font-semibold">{receiptData.paymentMethod}</span>
              </div>
              <div className="flex justify-between text-lg font-bold text-orange-600 border-t pt-2">
                <span>TOTAL:</span>
                <span>{formatPrice(receiptData.total)}</span>
              </div>
            </div>

            {receiptData.notes && (
              <div className="border-t mt-4 pt-4">
                <p className="text-sm text-gray-600 mb-1">Catatan:</p>
                <p className="text-sm">{receiptData.notes}</p>
              </div>
            )}
          </div>

          {/* Action Buttons */}
          <div className="space-y-3">
            <button
              onClick={downloadReceipt}
              className="w-full bg-green-500 text-white py-3 rounded-2xl font-bold shadow-lg hover:bg-green-600 transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center"
            >
              <svg className="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              Download Struk
            </button>
            
            <button
              onClick={handleBackToHome}
              className="w-full bg-gradient-to-r from-orange-400 to-red-400 text-white py-3 rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:scale-105 active:scale-95"
            >
              Kembali ke Beranda
            </button>
          </div>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-red-50">
      {/* Header */}
      <div className="bg-white/80 backdrop-blur-lg border-b border-orange-100 sticky top-0 z-10">
        <div className="px-4 py-4 flex items-center">
          <button 
            onClick={() => router.back()}
            className="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-4 hover:bg-orange-200 transition-colors"
          >
            <svg className="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <h1 className="text-xl font-bold text-gray-800">Checkout</h1>
        </div>
      </div>

      <div className="p-4 pb-32">
        {/* Order Summary */}
        <div className="bg-white rounded-3xl shadow-xl p-6 mb-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>
          
          <div className="space-y-3 mb-4">
            {orderData.items.map((item, index) => (
              <div key={index} className="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                <div className="flex-1">
                  <h3 className="font-semibold text-gray-800">{item.name}</h3>
                  <p className="text-sm text-gray-600">{item.price} x {item.quantity}</p>
                </div>
                <p className="font-bold text-orange-600">
                  {formatPrice(parseInt(item.price.replace('Rp', '').replace('.', '')) * item.quantity)}
                </p>
              </div>
            ))}
          </div>
          
          <div className="border-t pt-3">
            <div className="flex justify-between items-center text-lg font-bold text-gray-800">
              <span>Total:</span>
              <span className="text-orange-600">{formatPrice(orderData.total)}</span>
            </div>
          </div>
        </div>

        {/* Customer Information */}
        <div className="bg-white rounded-3xl shadow-xl p-6 mb-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4">Informasi Pembeli</h2>
          
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-2">
                Nama Lengkap *
              </label>
              <input
                type="text"
                value={customerInfo.name}
                onChange={(e) => setCustomerInfo({...customerInfo, name: e.target.value})}
                placeholder="Masukkan nama lengkap"
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent"
              />
            </div>
            
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-2">
                Nomor Telepon *
              </label>
              <input
                type="tel"
                value={customerInfo.phone}
                onChange={(e) => setCustomerInfo({...customerInfo, phone: e.target.value})}
                placeholder="Masukkan nomor telepon"
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent"
              />
            </div>
            
            <div>
              <label className="block text-sm font-semibold text-gray-700 mb-2">
                Catatan (Opsional)
              </label>
              <textarea
                value={customerInfo.notes}
                onChange={(e) => setCustomerInfo({...customerInfo, notes: e.target.value})}
                placeholder="Tambahkan catatan untuk pesanan"
                rows={3}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-transparent resize-none"
              />
            </div>
          </div>
        </div>

        {/* Payment Method */}
        <div className="bg-white rounded-3xl shadow-xl p-6 mb-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4">Metode Pembayaran</h2>
          
          <div className="grid grid-cols-2 gap-3">
            {paymentMethods.map((method) => (
              <button
                key={method.id}
                onClick={() => setPaymentMethod(method.id)}
                className={`p-4 rounded-2xl border-2 transition-all duration-200 ${
                  paymentMethod === method.id
                    ? 'border-orange-500 bg-orange-50'
                    : 'border-gray-200 bg-gray-50 hover:border-orange-300'
                }`}
              >
                <div className="text-center">
                  <div className="text-2xl mb-2">{method.icon}</div>
                  <p className="font-semibold text-sm text-gray-800">{method.name}</p>
                  {method.fee > 0 && (
                    <p className="text-xs text-gray-500">+{formatPrice(method.fee)}</p>
                  )}
                </div>
              </button>
            ))}
          </div>
        </div>

        {/* Payment Summary */}
        <div className="bg-white rounded-3xl shadow-xl p-6 mb-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4">Rincian Pembayaran</h2>
          
          <div className="space-y-2 text-sm">
            <div className="flex justify-between">
              <span className="text-gray-600">Subtotal:</span>
              <span className="font-semibold">{formatPrice(orderData.total)}</span>
            </div>
            
            <div className="flex justify-between">
              <span className="text-gray-600">Biaya Admin:</span>
              <span className="font-semibold">
                {formatPrice(paymentMethods.find(method => method.id === paymentMethod)?.fee || 0)}
              </span>
            </div>
            
            <div className="border-t pt-2 flex justify-between text-lg font-bold text-orange-600">
              <span>Total Pembayaran:</span>
              <span>{formatPrice(calculateTotal())}</span>
            </div>
          </div>
        </div>

        {/* Process Order Button */}
        <button
          onClick={handleProcessOrder}
          disabled={isProcessing || !customerInfo.name || !customerInfo.phone}
          className={`w-full py-4 rounded-2xl font-bold text-white shadow-lg transition-all transform hover:scale-105 active:scale-95 ${
            isProcessing || !customerInfo.name || !customerInfo.phone
              ? 'bg-gray-400 cursor-not-allowed'
              : 'bg-gradient-to-r from-orange-400 to-red-400 hover:shadow-xl'
          }`}
        >
          {isProcessing ? (
            <div className="flex items-center justify-center">
              <div className="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-2"></div>
              Memproses Pesanan...
            </div>
          ) : (
            `Bayar Sekarang - ${formatPrice(calculateTotal())}`
          )}
        </button>
      </div>
    </div>
  )
}