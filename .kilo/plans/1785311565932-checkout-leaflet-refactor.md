# Landing Page: BRANDS nav + Partner Brands teaser

## Goal
- Remove unused **OFFERS** tab from main navbar
- Keep **BRANDS** tab pointing to `/brands`
- Convert hardcoded "Partner Brands" footer section into a dynamic teaser using the `Brand` model, with a **View All Brands** link to `/brands`

## Current state
- Nav links live in `resources/views/e-commerce/nav-bars/horizontal-menu-bar.blade.php`
- OFFERS is an anchor to `#offers` (in-page section)
- BRANDS links to `route('brands.index')`
- Partner Brands section is hardcoded in `resources/views/e-commerce/sliders/our-partners.blade.php`
- `HomeController::index()` already fetches `$brands` but does **not** pass it to `welcome.blade.php`

## Changes

### 1. Navbar — `horizontal-menu-bar.blade.php`
- Remove the **OFFERS** `<li>` block entirely
- Keep BRANDS as-is (it already links to `route('brands.index')`)

### 2. Partner Brands teaser — `our-partners.blade.php`
- Replace the 3 hardcoded partner cards with a loop over brands passed from the controller
- Keep the same card styling (`hover-lift`, image constrained to `max-height: 120px`)
- Each brand card links to `route('search.index', ['search' => $brand->name])` (same as the `/brands` page)
- Add a **View All Brands** CTA button/link below the grid pointing to `route('brands.index')`
- If no brands exist, show a simple fallback message or hide the section gracefully

### 3. HomeController — `app/Http/Controllers/HomeController.php`
- In `index()`, add `'brands' => $brands` to the view data (the query already exists)

### 4. Welcome page — `resources/views/e-commerce/welcome.blade.php`
- Ensure the `@include('e-commerce.sliders.our-partners')` passes the `$brands` variable:
  ```blade
  @include('e-commerce.sliders.our-partners', ['brands' => $brands])
  ```

## Validation
- Navbar shows BRANDS tab, no OFFERS tab
- `/brands` page still works
- Footer "Partner Brands" section renders brand cards dynamically from DB
- Clicking a brand card searches for that brand
- "View All Brands" link goes to `/brands`
- Works when `$brands` is empty (no errors)
