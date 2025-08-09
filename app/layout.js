// app/layout.js
import './globals.css'

export const metadata = {
  title: 'Algo - Coffee Shop',
  description: 'Coffee so good, your taste buds will love it.',
}

export default function RootLayout({ children }) {
  return (
    <html lang="id">
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
      </head>
      <body className="flex justify-center bg-gray-100">
        <div className="w-full max-w-[375px] min-h-screen bg-white relative">
          {children}
        </div>
      </body>
    </html>
  )
}