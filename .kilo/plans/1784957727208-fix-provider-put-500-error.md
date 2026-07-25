# Fix Provider PUT 500 Internal Server Error

## Root Cause

`Api\ProviderController::assignProductsByMenu` overwrites its `$menus` array parameter with a single `Menu` model instance inside the `foreach` loop, causing a `TypeError` on the second iteration → 500 response. The frontend `catchValidationErrors` then crashes on the non-validation 500 response because `response.data.errors` is undefined.

## Changes

### 1. Fix `assignProductsByMenu` in `app/Http/Controllers/Api/ProviderController.php` (lines 162-200)

Three bugs in this method:

- **Bug 1**: `$menus` parameter overwritten on line 167-168 (`$menus = Menu::with(...)`) — on the second loop iteration, `foreach` tries to iterate over a `Menu` model (or null), causing TypeError
- **Bug 2**: `$selectedIds = []` reset inside the loop on line 165 — only the last menu's tree is collected
- **Bug 3**: No null check on `$menus->children` if `Menu::where('id', $menu)->first()` returns null

Fix:
- Rename the query result variable (e.g., `$menuModel`) so the original `$menus` array is preserved
- Move `$selectedIds = []` before the `foreach` loop so IDs accumulate across all menus
- Add null check: skip the menu if `Menu::where('id', $menu)->first()` returns null

### 2. Fix `catchValidationErrors` in `resources/dashboard/utils/catchValidationErrors.js`

Currently assumes `response.data.errors` always exists. On a 500 error, the response has `data.message` but no `data.errors`, causing `Object.values(undefined)` → TypeError.

Fix: guard against missing `response.data.errors` — if it doesn't exist, just show `response.data.message` as an error toast and return early.

## Verification

1. PUT `/system/providers/14` with `assign_service_by: '1'` and `provider_styles` containing multiple menu IDs — should return 200, not 500
2. PUT with a single menu ID — should still work correctly
3. PUT with `provider_styles` containing a menu ID that doesn't exist — should not crash
4. Frontend should display a user-friendly error toast on 500 instead of crashing with `TypeError: can't convert undefined to object`