

# Installtion

 - Run `php artisan migrate --seed` 

# Notes
- Updated `.env.example` database crendetials for pstgres.
- Added ext-pdo_pgsql as requirement to `composer.json`.
- Created middleware for Orgonization verification `AuthOrganizationMiddleware`.
- Added global scope to events to make sure all request to database has authorization in body.
- See `RequireContentTypeJsonTest` for phpunit test with data provider.
- See `EventPutTest` and `EventPatchTest` for use of `worksome/request-factories` in tests.

# Comments
 - Not fan of `organization_id` column in `events` table refering to `authorization` table.
 - There is no create api end point 
 
# Changes to the original task
 - Changed routes to:
   - GET `/api/list` > `/api/events/list`
   - GET|PUT|PATCH|DELETE `/api/{id}` > `/api/events/{id}`
 - Changed `authorization` table to `organizations`
 - Not fan of naming columns like `even_title` in the `events` table should be just title. So changed them:
   - `event_title` > `title`
   - `event_start_date` > `start_date`
   - `event_end_date` > `end_date`

