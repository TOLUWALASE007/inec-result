# INEC Results Portal

A PHP application for displaying and managing INEC (Independent National Electoral Commission) election results for Delta State.

## 🌐 Live Demo

**Frontend (GitHub Pages)**: [View Live Demo](https://toluwalase007.github.io/inec-result)

**Backend (Railway)**: Coming soon...

## Features

- **Individual Polling Unit Results (Q1)**: View detailed results for any specific polling unit
- **LGA Total Results (Q2)**: View summed totals of all polling units within a Local Government Area
- **Add New Results (Q3)**: Store results for all parties for a new polling unit

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. **Clone or download this repository**
   ```bash
   git clone <repository-url>
   cd inec-results
   ```

2. **Set up the database**
   - Create a MySQL database named `bincomphptest`
   - Import the SQL dump:
     ```bash
     mysql -u root -p bincomphptest < sql/bincom_test.sql
     ```

3. **Configure database connection**
   - Copy `.env.example` to `.env`
   - Update the database credentials in `.env`:
     ```
     DB_HOST=127.0.0.1
     DB_NAME=bincomphptest
     DB_USER=root
     DB_PASS=your_mysql_password
     ```

4. **Set up web server**
   - Point your web server document root to the `public/` directory
   - Ensure PHP has PDO MySQL extension enabled

## Project Structure

```
inec-results/
├── public/                  # Web root directory
│   ├── index.php           # Home page
│   ├── show_polling_unit.php # Q1: Individual polling unit results
│   ├── show_lga_sum.php    # Q2: LGA total results
│   ├── add_polling_unit.php # Q3: Add new polling unit results
│   └── api/                # API endpoints for chained selects
│       ├── get_wards.php
│       └── get_polling_units.php
├── src/                    # Application logic
│   ├── db.php             # Database connection
│   └── functions.php      # Helper functions
├── templates/             # Reusable templates
│   ├── header.php
│   └── footer.php
├── assets/               # Static assets
│   ├── js/
│   └── css/
├── sql/
│   └── bincom_test.sql   # Database dump
├── .env.example          # Environment configuration template
└── README.md
```

## Usage

1. **View Individual Polling Unit Results**
   - Navigate to the "Polling Unit Results" page
   - Select LGA → Ward → Polling Unit
   - View detailed party results with vote counts and percentages

2. **View LGA Total Results**
   - Navigate to the "LGA Totals" page
   - Select a Local Government Area
   - View aggregated results across all polling units in the LGA

3. **Add New Polling Unit Results**
   - Navigate to the "Add Results" page
   - Select LGA → Ward → Polling Unit
   - Enter vote counts for each political party
   - Save the results to the database

## Database Schema

The application uses the following key tables:

- `polling_unit`: Contains polling unit information (uniqueid, name, ward_id, lga_id)
- `announced_pu_results`: Contains individual party results per polling unit
- `lga`: Contains Local Government Area information
- `ward`: Contains ward information

## Technical Details

- **Backend**: PHP with PDO for database operations
- **Frontend**: HTML5, Tailwind CSS (CDN), Vanilla JavaScript
- **Database**: MySQL with prepared statements for security
- **Architecture**: Simple MVC-like structure with separation of concerns

## Security Features

- Prepared statements to prevent SQL injection
- Input validation and sanitization
- CSRF protection through form validation
- Error handling without exposing sensitive information

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- JavaScript enabled for chained select functionality

## 🚀 GitHub Pages Deployment

This repository is configured for GitHub Pages deployment:

1. **Frontend**: The `index.html` file in the root directory serves as the main GitHub Pages site
2. **Backend**: Deploy the PHP backend to Railway or similar service
3. **Configuration**: Update the `API_BASE_URL` in `index.html` with your backend URL

### Quick Setup:
1. Go to repository **Settings** → **Pages**
2. Select **Source**: Deploy from a branch
3. Select **Branch**: main
4. Select **Folder**: / (root)
5. Click **Save**

Your site will be available at: `https://toluwalase007.github.io/inec-result`

## License

This project is for educational purposes only.
