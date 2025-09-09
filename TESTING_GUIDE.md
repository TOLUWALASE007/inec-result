# INEC Results Portal - Testing Guide

## Prerequisites Setup

### 1. Database Setup
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE bincomphptest CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import data
mysql -u root -p bincomphptest < sql/bincom_test.sql
```

### 2. PHP Configuration
Ensure PHP has PDO MySQL extension enabled:
```bash
php -m | findstr pdo_mysql
```

If not enabled, uncomment in php.ini:
```ini
extension=pdo_mysql
```

## Testing Methods

### Method 1: XAMPP/WAMP (Easiest)
1. Install XAMPP
2. Copy project to `C:\xampp\htdocs\inec-results\`
3. Start Apache & MySQL
4. Import database (see above)
5. Visit: `http://localhost/inec-results/public/show_polling_unit.php`

### Method 2: PHP Built-in Server
1. Run: `start_server.bat`
2. Visit: `http://localhost:8000/public/show_polling_unit.php`

### Method 3: Command Line Testing
```bash
# Test database connection
php test_connection.php

# Test quick setup
php quick_test.php
```

## Step-by-Step Testing

### Test 1: Database Connection
- [ ] Run `php test_connection.php`
- [ ] Should show "Database connection successful!"
- [ ] Should show count of LGAs, polling units, and results

### Test 2: LGA Loading
- [ ] Open `show_polling_unit.php` in browser
- [ ] LGA dropdown should populate with Delta State LGAs
- [ ] Should see options like "Aniocha North", "Aniocha South", etc.

### Test 3: Chained Selects
- [ ] Select an LGA from dropdown
- [ ] Ward dropdown should populate automatically
- [ ] Select a ward
- [ ] Polling Unit dropdown should populate automatically

### Test 4: Results Display
- [ ] Select a polling unit
- [ ] Click "Show Results"
- [ ] Should see a table with party results
- [ ] Should show parties like PDP, DPP, ACN, etc. with vote counts

### Test 5: AJAX Endpoints
Test these URLs directly:
- `http://localhost/inec-results/src/ajax.php?action=getWards&lga_id=1`
- `http://localhost/inec-results/src/ajax.php?action=getPUs&ward_id=1`

Should return JSON data.

## Expected Results

### Sample LGA List
- Aniocha North
- Aniocha South
- Bomadi
- Burutu
- Ethiope East
- Ethiope West
- Ika North East
- Ika South
- Isoko North
- Isoko South
- Ndokwa East
- Ndokwa West
- Okpe
- Oshimili North
- Oshimili South
- Patani
- Sapele
- Udu
- Ughelli North
- Ughelli South
- Ukwuani
- Uvwie
- Warri North
- Warri South
- Warri South West

### Sample Results Format
| Party | Score |
|-------|-------|
| PDP   | 802   |
| DPP   | 719   |
| ACN   | 416   |
| PPA   | 107   |
| CDC   | 96    |
| JP    | 68    |
| ANPP  | 59    |
| LABO  | 14    |
| CPP   | 10    |

## Troubleshooting

### Database Connection Issues
- Check MySQL is running
- Verify database exists: `SHOW DATABASES;`
- Check credentials in `src/db.php`

### AJAX Not Working
- Check browser console for errors
- Verify `src/ajax.php` is accessible
- Test AJAX endpoints directly

### No Results Found
- Verify polling unit has results in database
- Check `announced_pu_results` table
- Try different polling units

## Success Criteria
✅ LGA dropdown loads with 25 Delta State LGAs
✅ Ward dropdown populates when LGA is selected
✅ Polling Unit dropdown populates when ward is selected
✅ Results table displays when polling unit is selected
✅ AJAX calls work without page refresh
✅ Clean, responsive UI with Tailwind CSS
