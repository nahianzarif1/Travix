# SSLCommerz Payment Integration Setup

## Environment Variables

Add these to your `.env` file:

```env
# SSLCommerz Configuration
SSLCOMMERZ_STORE_ID=your_store_id_here
SSLCOMMERZ_STORE_PASSWORD=your_store_password_here
SSLCOMMERZ_API_URL=https://sandbox.sslcommerz.com/gwprocess/v4/api.php
SSLCOMMERZ_SUCCESS_URL=/payment/success
SSLCOMMERZ_FAIL_URL=/payment/fail
SSLCOMMERZ_CANCEL_URL=/payment/cancel
```

## For Testing (Sandbox)

Use these test credentials:
- Store ID: `testbox`
- Store Password: `qwerty`
- API URL: `https://sandbox.sslcommerz.com/gwprocess/v4/api.php`

## For Production

1. Get your credentials from SSLCommerz dashboard
2. Update the environment variables
3. Change API URL to: `https://securepay.sslcommerz.com/gwprocess/v4/api.php`

## Features Implemented

✅ **Payment Processing**
- Real-time booking totals calculation
- SSLCommerz integration
- Payment success/failure handling
- Payment history tracking

✅ **Database Tables**
- `payments` - Main payment records
- `payment_items` - Individual booking items in payments
- User mobile number and address fields

✅ **Payment Flow**
1. User books flights/hotels/tours
2. Bookings are marked as 'confirmed'
3. User goes to Payments section
4. System calculates totals by category
5. User initiates payment via SSLCommerz
6. Payment success updates booking status to 'paid'
7. Payment history is tracked

✅ **Real Customer Data**
- Mobile number validation
- Address collection
- Customer info passed to SSLCommerz
- Payment method tracking

## Testing the System

1. Login with test user (test@example.com / password)
2. Book some flights, hotels, or tours
3. Go to Payments section
4. Fill in payment form
5. Submit payment (will redirect to SSLCommerz sandbox)
6. Complete payment process
7. Check Payment History for records

## Security Features

- CSRF protection on all forms
- Secure payment data handling
- No card details stored locally
- SSLCommerz handles all sensitive data
- Payment verification on success/failure
