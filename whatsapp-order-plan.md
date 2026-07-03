# WhatsApp after Order Creation — Feasibility & Implementation Plan

## What exists now

-   Order creation calls `OrderController@notifyClient()`.
-   `notifyClient()` sends:
    -   SMS via `SmsNotification` (using `SmsChannel` / Africa’s Talking)
    -   Email via `OrderCreated` mailable
-   There is **no WhatsApp channel** implemented in the notification flow.

## Can it be done?

Yes—by adding a WhatsApp sending channel and wiring it into the post-order notifications.

## Implementation approach (recommended)

### 1) Add a WhatsApp notification channel

-   Create something like `app/Channels/WhatsAppChannel.php`.
-   Implement `send($notifiable, Notification $notification)`.
-   Use a WhatsApp provider (common options):
    -   Meta Cloud API (WhatsApp Business Platform)
    -   Twilio WhatsApp
    -   Any other provider you already use

### 2) Add a WhatsApp message builder to the existing notification

-   Update `app/Notifications/SmsNotification.php`:
    -   either rename/generalize it (e.g., `ClientOrderNotification`)
    -   or add a `toWhatsApp($notifiable)` method returning the WhatsApp text
    -   update `via()` to include `WhatsAppChannel::class` when WhatsApp is enabled

### 3) Decide enablement rules

Typical flags:

-   if `notifiable->phone` exists
-   and `notifiable->whatsapp_blocked != 1` (if you add such a field)
-   or based on existing `sms_blocked` (if you want to reuse)

### 4) Wire into `notifyClient()`

-   Either keep `notify(new SmsNotification($message))` and let the notification deliver both SMS and WhatsApp
-   Or explicitly call WhatsApp separately from `notifyClient()`.

### 5) Environment variables + config

-   Add provider credentials to `.env`.
-   Add to `config/services.php` (or provider-specific config).

## What to verify before coding

-   Where the customer phone number is sourced from (`users.phone`).
-   Whether the customer has WhatsApp enabled / verified.
-   Which WhatsApp provider you want to use.

## Files likely to be edited/added

-   `app/Channels/WhatsAppChannel.php` (new)
-   `app/Notifications/SmsNotification.php` (update)
-   `app/Http/Controllers/Api/OrderController.php` (optional; only if you don’t want notification to handle routing)
-   `config/services.php` (add WhatsApp provider credentials)
-   `.env.example` (if present)

## Testing checklist

-   Create an order in staging/dev.
-   Confirm SMS + WhatsApp are both sent (or only WhatsApp, depending on rules).
-   Check logs for provider errors.
