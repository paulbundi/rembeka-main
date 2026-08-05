# Provider Inquiries - CRUD Actions Fix

## Goal

Make the CRUD actions (Edit/View/Delete) appear in the actions dropdown and work correctly on the `/providers-inquiries` page.

## Root Causes

1. `app/Models/ProviderInquiry.php`:
    - `getFormRequestClass()` references `ProviderInquiryFormRequest::class` without a `use` import → resolves to non-existent class → breaks API store/update.
    - Method is `protected` instead of `public` → `AbstractApiController::getRequest()` can't access it.
    - `getServiceOfferedAttribute()` uses `Menu` class without import → breaks the appended `serviceOffered` attribute.
2. `ProviderInquiryCreate.vue` has no Services multi-select → `services` JSON column can't be populated/edited from UI.
3. `ProviderInquiryIndex.vue` has no Services column → services not shown in list.

## Steps

1. Fix `ProviderInquiry.php`:
    - Add `use App\Http\Requests\ProviderInquiryFormRequest;`
    - Add `use App\Models\Menu;`
    - Change `getFormRequestClass()` to `public static`.
2. Add Services multi-select to `ProviderInquiryCreate.vue` (use `Menus` module via RemoteSelector/MultipleSelector).
3. Add Services column to `ProviderInquiryIndex.vue`.
4. Verify dropdown actions appear (permission-gated already works with Admin role).
