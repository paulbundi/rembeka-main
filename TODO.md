# Leaflet Migration Plan for Google Maps (Awaiting API Key)

**Current Issue**: InvalidKeyMapError from `key={key}` placeholder.

**Files to Update**:
1. `config/services.php` - Add Google Maps API key config
2. `resources/views/e-commerce/checkouts/partials/addresslocation.blade.php` - Replace Google with Leaflet, comment Google
3. `resources/views/e-commerce/account/addresses/create.blade.php` - Leaflet + comment Google
4. `resources/views/e-commerce/checkouts/checkout-details.blade.php` - Update @include

**Plan**:
- Leaflet + Nominatim (free geocoding) active
- Google Maps code commented (ready for key)
- Test checkout/details map/search

**Steps**:
- [ ] 1. Update config/services.php ✅
- [ ] 2. Update addresslocation.blade.php
- [ ] 3. Update addresses/create.blade.php 
- [ ] 4. Update checkout-details.blade.php
- [ ] 5. php artisan config:clear view:clear
- [ ] 6. Test https://rembekaonline.com/checkout/details
- [ ] 7. Commit to blackboxai/maps-leaflet branch

**Future**: Add `GOOGLE_MAPS_API_KEY` to .env, uncomment Google scripts

