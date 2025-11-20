# 🚀 Quick Start Guide - Algo Coffee POS

## ⚡ Start the Application

1. **Open Laragon** (if not already open)
2. **Click "Start All"** to start Apache + MySQL
3. **Navigate** to: `http://localhost/algo`
4. **Laravel** auto-runs at `http://localhost/algo` (via Laragon)

---

## 👥 Test Accounts

### Kasir Login
```
Email: kasir@algocoffee.com
Password: password123
```

### Admin Login
```
Email: admin@algocoffee.com
Password: password123
```

### Register New Account
- Visit: `/register`
- Select role (Kasir, Admin, Manager)
- Enter phone number
- Accept terms

---

## 🎯 Quick Test Flow

### Customer Journey (5 minutes)
1. Go to: `http://localhost/algo/meja/1`
2. **See QR Code** at the top
3. **Browse Menu** - Use categories or search
4. **Add Items** - Click "+ Tambah" on menu items
5. **Open Cart** - Click the floating cart button
6. **Checkout**:
   - Enter your name (e.g., "Budi")
   - Select payment method (e.g., OVO)
   - Click "Pesan Sekarang"
7. **See Waiting Page** - Shows status timeline
8. **Watch Real-time Updates** - Wait 2 seconds for AJAX poll

### Kasir Journey (5 minutes)
1. Go to: `http://localhost/algo/login`
2. Login as kasir@algocoffee.com
3. **Dashboard** - See stats and recent orders
4. **Find Order** - Click "Lihat Pesanan" or go to "Pesanan"
5. **Accept Order** - Click "✓ Terima" button
6. **Update Status** - Change to "Diproses" or "Siap"
7. **Check Waiting Page** - Customer sees status update in 2 seconds!

---

## 🧪 What to Test

### ✅ Functional Tests

- [ ] **QR Code** displays on menu page
- [ ] **Menu** loads from database (12 items)
- [ ] **Search** filters items in real-time
- [ ] **Categories** filter correctly
- [ ] **Cart** adds/removes items
- [ ] **Checkout** creates order in database
- [ ] **Waiting Page** loads with order details
- [ ] **AJAX Polling** updates status (watch Network tab)
- [ ] **Kasir Dashboard** shows stats
- [ ] **Order List** filters by status
- [ ] **Status Update** changes in database + on waiting page

### ✅ Design Tests

- [ ] **No Laravel branding** anywhere
- [ ] **Orange theme** (#ff6b35) visible
- [ ] **Responsive** on mobile (use browser DevTools)
- [ ] **Animations** smooth (no jank)
- [ ] **Colors consistent** across pages
- [ ] **Text is Indonesian** throughout

### ✅ Data Tests

- [ ] **15 Orders** exist in database
- [ ] **12 Menus** load correctly
- [ ] **3 Users** can login
- [ ] **Status History** shows timeline
- [ ] **Revenue Reports** calculate correctly

---

## 📱 Device Testing

### Desktop (1920×1080)
- Sidebar visible
- Full menu grid (4-5 columns)
- All buttons clickable

### Tablet (768×1024)
- Responsive sidebar
- Menu grid (2-3 columns)
- Touch-friendly buttons

### Mobile (375×667)
- Hamburger menu
- Menu grid (1 column)
- Floating cart centered
- Bottom cart modal

---

## 🔍 Debug Tips

### Check Menu Data
Visit: `http://localhost/algo/api/menus`
Should see JSON array with 12 items

### Check Order Status
Visit: `http://localhost/algo/api/orders/1`
Should see order details with status

### View Database
```bash
cd c:\laragon\www\algo
php artisan tinker
# Then type: Order::with('menus')->first();
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
```

### Check Routes
```bash
php artisan route:list
```

---

## 🎨 URLs by Feature

| Feature | URL |
|---------|-----|
| Customer Menu (Table 1) | `/meja/1` |
| Customer Menu (Table 2) | `/meja/2` |
| Waiting Page (Order 1) | `/waiting/1` |
| Kasir Login | `/login` |
| Kasir Dashboard | `/kasir/dashboard` |
| Kasir Orders | `/kasir/orders` |
| Kasir History | `/kasir/history` |
| Kasir Revenue | `/kasir/revenue` |
| Register | `/register` |
| Menu API | `/api/menus` |
| Order API | `/api/orders/1` |

---

## ⚠️ Common Issues & Fixes

### "Page not found"
- Check URL spelling
- Verify Laravel server is running
- Try: `php artisan serve` in terminal

### "Database error"
- Check MySQL is running (Laragon)
- Verify `.env` file has correct DB credentials
- Run: `php artisan migrate --fresh --seed`

### "QR Code not showing"
- Check console for JS errors
- Verify `https://cdnjs.cloudflare.com/` is accessible
- Try: Hard refresh (Ctrl+Shift+R)

### "Real-time updates not working"
- Check browser Network tab
- Look for `/api/orders/{id}` requests every 2 seconds
- Check console for JavaScript errors
- Verify order exists in database

### "Can't login"
- Verify user exists: `php artisan tinker` → `User::all()`
- Check password is `password123`
- Try: Clear cookies and cache

---

## 📊 Test Data Included

### Users
```
kasir@algocoffee.com (role: kasir) - password123
kasir2@algocoffee.com (role: kasir) - password123
admin@algocoffee.com (role: admin) - password123
```

### Menus (12 items)
- Espresso, Cappuccino, Latte, Americano
- Nasi Goreng, Burger, Pasta, Sandwich
- Cheesecake, Tiramisu, French Fries, Chicken Wings

### Orders (15 items)
- Various statuses (pending, accepted, preparing, ready)
- Different payment methods
- Complete status histories

### Tables
- 10 tables (Meja 1-10) all available

---

## 🎓 Code Structure

```
Customer Flow:
/meja/{number} 
  → Menu page loads
  → Add to cart (session)
  → POST /checkout
  → Create order (DB)
  → Redirect /waiting/{id}
  → AJAX polls /api/orders/{id}
  → Status updates in real-time

Kasir Flow:
/login
  → Authenticate (session)
  → /kasir/dashboard
  → View stats + orders
  → Click order → /kasir/orders/{id}
  → POST /kasir/orders/{id}/status
  → Customer sees update!
```

---

## 🚀 Performance Notes

- **AJAX Polling Interval**: 2 seconds (responsive but not overloading)
- **Dashboard Auto-refresh**: 30 seconds
- **Database Queries**: Optimized with eager loading
- **CSS/JS**: Minified and inline (no external dependencies except CDN)
- **Mobile**: Fully responsive (CSS Grid + Flexbox)

---

## ✅ Verification Checklist

Before showing to client, verify:

- [ ] Login page works (no Laravel styling)
- [ ] Register page works (role selection)
- [ ] Menu page shows (with QR code)
- [ ] Cart functionality works
- [ ] Checkout creates order
- [ ] Waiting page shows status timeline
- [ ] Kasir dashboard loads
- [ ] Order filtering works
- [ ] Status updates propagate in real-time
- [ ] Revenue reports calculate correctly
- [ ] Mobile responsive
- [ ] No console errors
- [ ] Database populated with test data
- [ ] All 13 migrations applied

---

## 📞 Support

**Server**: http://localhost/algo (Laragon)  
**Database**: MySQL via Laragon  
**Language**: Indonesian (Bahasa Indonesia)  
**Theme**: Orange + Dark  
**Status**: Production Ready ✅

---

**Happy Testing! 🎉**

Any issues? Check console (F12) for errors and refer to detailed docs in `IMPLEMENTATION_COMPLETE.md`
