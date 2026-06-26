# TODO - Home page fixes (separate commits per item)

## Item 1: ADORN products in Best Sellers

-   [x] Update/confirm carousel section shows products whose brand name = 'ADORN'
-   [ ] Ensure ADORN products render correctly (pricing -> product -> attachments.media)
-   [ ] Commit: `feat(home): show ADORN products in best sellers`

## Item 2: Beauty equipment links to correct equipment page

-   [ ] Identify the wrong routing for equipment (e.g. menu id 10)
-   [ ] Update link generation so equipment routes to the correct page
-   [ ] Commit: `fix(menu): correct beauty equipment links`

## Item 3: Partner Salons -> Partner brands + logos

-   [ ] Rename section text to “Partner brands”
-   [ ] Ensure brands shown with their logos from Brand attachments media
-   [ ] Commit: `feat(home): partner brands section uses brand logos`

## Item 4: Clicking Brands link goes to /filter

-   [ ] Find where Brands link/button is generated/intercepted
-   [ ] Fix link to route('brands.index')
-   [ ] Commit: `fix(nav): brands link routes to /brands`

## Item 5: Beauty services link points to blank page

-   [ ] Update beauty-services blade to be blank/minimal
-   [ ] Ensure service links route to that blank page
-   [ ] Commit: `fix(services): beauty services link to blank page`
