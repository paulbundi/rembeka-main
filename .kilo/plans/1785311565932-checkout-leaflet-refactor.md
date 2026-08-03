# Fix best-sellers price display showing Ksh 0.00

## Root cause
`resources/views/e-commerce/sliders/best-seller.blade.php` renders the price from the wrong source.

For ADORN products, `HomeController::index()` fetches `$adornProducts` as `ProviderPricing` records and eager-loads only `product.attachments.media` and `product.category`. The Blade view then reads `$product->final_price` directly from the `Product` model.

However, the actual product page (`ProductDetails.vue`) does **not** use `product.final_price`. It uses `product.supplier_price[0].amount` (from `ProductPricing`). For this product, `products.final_price` is effectively empty/null while the real price lives in `product_pricings.amount`, which is why the card shows Ksh 0.00.

## Changes

### 1. `app/Http/Controllers/HomeController.php`
In the `$adornProducts` query inside `index()`, add `product.supplierPrice` to the eager-load list:

```php
->with(['product.attachments.media', 'product.category', 'product.supplierPrice'])
```

### 2. `resources/views/e-commerce/sliders/best-seller.blade.php`
Change the price display from:
```blade
<span class="text-accent">Ksh {{ $product->final_price }}</span>
```

To:
```blade
@php
  $displayPrice = optional(optional($product->supplierPrice)->first())->amount ?? $product->final_price;
@endphp
<span class="text-accent">Ksh {{ $displayPrice }}</span>
```

This mirrors what `ProductDetails.vue` uses (`supplier_price[0].amount`) and falls back to `final_price` if no supplier pricing exists.

## Validation
- The ADORN eyeshadow palette card in "Best Sellers" shows the same Ksh price as its product page
- No null/0.00 fallback when `supplierPrice` is populated
- If a product truly has no pricing, it still falls back gracefully to `final_price`
