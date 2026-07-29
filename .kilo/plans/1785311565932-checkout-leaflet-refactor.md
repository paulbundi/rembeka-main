# Refactor Checkout Leaflet Maps — Full NurseNourish Pattern

## Goal
Apply the full NurseNourish checkout delivery UX to Rembeka's checkout map:
- PICKUP / DELIVERY toggle
- Click-to-set-location with reverse geocoding
- Forward geocoding from search input
- Haversine-based delivery fee + distance display
- Backend API endpoints for geocoding and fee calculation
- Correct Nairobi default coordinates

## Scope
- **In:** `checkout-details` flow (both authenticated and guest), `addresslocation` partial, account address creation map, payment-mode totals, order creation
- **Out:** Store-locator page, dashboard maps, non-checkout address flows

## Files to Change

### Backend
1. **`app/Http/Controllers/DeliveryController.php`** (new)
   - `calculate(Request $request)`: Haversine distance from warehouse, returns `{fee, distanceKm}`
   - `geocode(Request $request)`: Forward geocode via Nominatim
   - `reverseGeocode(Request $request)`: Reverse geocode via Nominatim
   - All endpoints set `User-Agent: Rembeka/1.0`

2. **`routes/public.php`**
   - Register `POST /delivery/calculate`
   - Register `POST /delivery/geocode`
   - Register `POST /delivery/reverse-geocode`

3. **`config/services.php`**
   - Add `delivery` config block: `warehouse_lat`, `warehouse_lng`, `base_fee`, `per_km_rate`, `free_threshold_km`, `free_minimum_spend`
   - Add corresponding `.env` entries

4. **`app/Http/Controllers/CartController.php`**
   - `paymentMode()`: read `delivery_method`, `delivery_fee`, `latitude`, `longitude` from request; store in session
   - `createAccount()`: read delivery fields from `CheckOutRequest`; store in session

5. **`app/Http/Requests/CheckOutRequest.php`**
   - Add rules: `delivery_method`, `delivery_fee`, `latitude`, `longitude`

6. **`app/Repository/Cart/CartRepository.php`**
   - `createOrder()` and `createPaystackOrder()`: set `delivery_amount` from session

### Frontend
7. **`resources/views/e-commerce/checkouts/partials/addresslocation.blade.php`** (major refactor)
   - Correct default view to `[-1.2921, 36.8219]`
   - Add `scrollWheelZoom={false}`, `inertia`, `zoomSnap: 0.5`, `zoomDelta: 0.5`, `doubleClickZoom: false`
   - Add click-to-set-location → reverse geocode → call `/delivery/reverse-geocode`
   - Add PICKUP/DELIVERY toggle radio/buttons below search
   - On address select or map click, call `/delivery/calculate` with coordinates
   - Show distance and delivery fee inline under the map
   - Replace `lat_long` hidden input with separate `latitude`, `longitude`, `delivery_fee`, `delivery_method` hidden inputs
   - Move Leaflet CSS/JS to the layout or ensure they load only once (currently duplicated across views)

8. **`resources/views/e-commerce/checkouts/checkout-details.blade.php`**
   - Update sidebar `order-summary-details` to show delivery fee and updated total (via Vue data populated from session)

9. **`resources/views/e-commerce/checkouts/payment-mode.blade.php`**
   - Update all displayed totals to include `session('delivery_fee', 0)`
   - Update Paystack initialization amount
   - Update manual M-Pesa amount display

10. **`resources/views/e-commerce/account/addresses/create.blade.php`**
    - Apply same map improvements (correct coords, click-to-set, reverse geocode, `User-Agent` header)

11. **`resources/e-commerce/views/cart/OrderSummaryDetails.vue`**
    - Add delivery fee row and updated total (read from `window.checkout.deliveryFee` or session)

12. **`resources/e-commerce/views/cart/CartCreateSummaryDetails.vue`**
    - Show delivery fee if present in session/globals

## Implementation Order
1. Backend config + `DeliveryController` + routes
2. Update `CheckOutRequest` validation
3. Update `CartController` to persist delivery data to session
4. Update `CartRepository` to add `delivery_amount` to orders
5. Refactor `addresslocation.blade.php` map + toggle + fee display
6. Update `checkout-details`, `payment-mode`, Vue summaries
7. Update account address map for consistency

## Validation
- Map loads centered on Nairobi with correct latitude
- Clicking map places marker and populates address via reverse geocoding
- Searching autocompletes and sets marker + calculates fee
- Selecting DELIVERY shows fee; PICKUP shows zero
- Fee persists through guest/authenticated checkout to payment page
- `order.amount` includes `delivery_amount`
- Existing `updateOrderPricing` still works with `delivery_amount`
- Store locator and account address creation maps also reflect improvements
