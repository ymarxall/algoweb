# Development Plan - Algo Coffee POS System

## Phase 1: Authentication & Role-based Access (CURRENT)
- [x] Add role & status columns to users table
- [ ] Update User model with role methods
- [ ] Create middleware: CheckRole, EnsureKasir, EnsureAdmin
- [ ] Create register form for kasir
- [ ] Modify login to include last_login_at tracking
- [ ] Create auth controllers for kasir login

## Phase 2: Kasir Dashboard
- [ ] Create DashboardController
- [ ] Build dashboard layout with sidebar navigation
- [ ] Create views: dashboard.home, dashboard.orders, dashboard.history, dashboard.revenue
- [ ] Add order management panel (accept, reject, update status)
- [ ] Add estimasi waktu setter

## Phase 3: Order Management
- [ ] Create OrderController (kasir side)
- [ ] Implement order status workflow
- [ ] Create order-statuses history tracking
- [ ] Real-time order list updates
- [ ] Order details modal

## Phase 4: History & Revenue Reports
- [ ] Create ReportController
- [ ] Build history with monthly grouping
- [ ] Build revenue dashboard
- [ ] Export to PDF/Excel (optional)
- [ ] Monthly breakdown charts

## Phase 5: Customer Side Enhancements
- [ ] Add QR code support to waiting page
- [ ] Implement real-time order status polling
- [ ] Improve menu UI/UX

## Phase 6: Optimization & Deployment
- [ ] Setup caching for frequently accessed data
- [ ] Add API versioning
- [ ] Security audit
- [ ] Performance optimization
- [ ] Deployment configuration

---

## Database Structure Overview

```
users
├── id, name, email, password
├── role: enum(customer, kasir, admin, manager)
├── status: enum(active, inactive, suspended)
├── last_login_at, phone

orders
├── id, order_number
├── table_id, customer_name, payment_method
├── total_price, discount_amount, additional_charge, final_total
├── status (pending/accepted/preparing/ready/completed/cancelled)
├── estimated_completion_at, actual_completion_at
├── created_at, updated_at

order_statuses (history)
├── id, order_id, status, notes, changed_by, status_at

order_details (items)
├── id, order_id, menu_id, quantity, price

admin_logs (audit trail)
├── id, user_id, action, model, model_id, old_values, new_values

categories, menus, tables (sudah ada)
```

---

## API Endpoints to Create

### Kasir/Admin Routes
```
POST /kasir/register - Register kasir
POST /kasir/login - Login kasir
GET /kasir/logout - Logout

GET /dashboard - Dashboard home
GET /dashboard/orders - Pending orders
GET /dashboard/history - Order history
GET /dashboard/revenue - Revenue reports

POST /api/orders/{id}/accept - Accept order
POST /api/orders/{id}/reject - Reject order
POST /api/orders/{id}/status - Update status
POST /api/orders/{id}/estimate - Set estimate time
```

### Customer Routes (Enhanced)
```
GET /meja/{no} - Menu page (already exists)
POST /cart/add - Add to cart (already exists)
POST /checkout - Checkout (already exists)
GET /waiting/{orderId} - Waiting page
GET /api/order/{orderId}/status - Get status
```

---

## Authentication Flow

1. **Kasir Register**
   - username, email, password
   - Role set to 'kasir' by admin
   - Status 'inactive' until approved

2. **Kasir Login**
   - Check role = kasir AND status = active
   - Update last_login_at
   - Redirect to /dashboard

3. **Admin/Manager**
   - Similar but with role = admin or manager
   - Full access to all features

---

## Next Steps
1. Create User model methods for role checking
2. Create middleware for role protection
3. Create Kasir authentication controllers
4. Build dashboard layout and main page
5. Implement order management panel

---

## Timeline
- Phase 1: 2-3 hours
- Phase 2: 3-4 hours
- Phase 3: 2-3 hours
- Phase 4: 2-3 hours
- Phase 5: 1-2 hours
- Phase 6: 1-2 hours

**Total Estimated: 12-18 hours**
