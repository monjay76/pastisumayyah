# Login Page Implementation

## Completed Tasks
- [x] Create LoginController with index and login methods
- [x] Update routes to use LoginController for root and POST login
- [x] Create login.blade.php with form for role selection, username (ID), and password
- [x] Implement authentication logic to check against respective tables (pentadbir, guru, ibubapa)
- [x] Redirect users to their respective dashboards based on role
- [x] Update login form to have only username and password inputs (removed role dropdown)
- [x] Make login form centered and in the middle of the page with modern styling
- [x] Update controller to automatically determine role based on username
- [x] Update login page layout to match the vibe of app.blade.php (green gradient background, same font, logo, colors, and Malay language)
- [x] Implement logout functionality for all user types (pentadbir, guru, ibubapa) to redirect to login page

## Notes
- Username is the ID (ID_Admin for pentadbir, ID_Guru for guru, ID_Parent for ibubapa)
- Password is checked against 'kataLaluan' field in each table
- Uses session to store user and role
- Redirects to appropriate routes: pentadbir.index, guru.index, ibubapa.profilMurid
- Login form now has the same green gradient background and styling as the main app layout
- Role is automatically determined by checking username against each table in order
- Interface is in Malay to match the application language
- Logout button clears session and redirects to login page for all user types
