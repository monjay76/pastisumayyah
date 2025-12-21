# TODO: Add Profile Picture Upload for Students in Guru ProfilMurid Page

## Steps to Complete:

1. **Create Migration**: Generate and edit a new migration to add 'gambar_profil' column to 'murid' table.
2. **Update Murid Model**: Add 'gambar_profil' to the $fillable array in Murid.php.
3. **Modify profilMurid.blade.php**: Add display for current profile picture and upload form.
4. **Update GuruPageController**: Add updateProfilePicture method to handle file upload.
5. **Update Routes**: Add POST route for profile picture update in web.php.
6. **Run Migration**: Execute the migration to update the database.
7. **Test Functionality**: Verify image upload and display works correctly.

## Progress:
- [x] Step 1: Create Migration
- [x] Step 2: Update Murid Model
- [x] Step 3: Modify View
- [x] Step 4: Update Controller
- [x] Step 5: Update Routes
- [x] Step 6: Run Migration
- [x] Step 7: Test Functionality (Storage link confirmed)
