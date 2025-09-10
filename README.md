# INEC Results Portal

A complete PHP-based web application for displaying and managing INEC (Independent National Electoral Commission) election results. This project implements all three required questions with a modern, responsive interface.

## 🚀 Live Demo

**Complete Application (Vercel):** https://inec-results-portal.vercel.app

## 📋 Project Requirements

### Question 1: Individual Polling Unit Results
- Display results for any individual polling unit
- Chained selects: LGA → Ward → Polling Unit
- Results displayed in table format
- Delta State only (state_id = 25)

### Question 2: LGA Summed Results
- Display summed total results for all polling units under any LGA
- LGA selection using dropdown
- **Important:** Uses `announced_pu_results` table (NOT `announced_lga_results`)
- Aggregates data from individual polling units

### Question 3: Add New Polling Unit Results
- Store results for ALL parties for a new polling unit
- Chained selects: LGA → Ward → Polling Unit
- Input fields for all 9 political parties
- Inserts data into `announced_pu_results` table

## ✨ Features

- **Modern UI** - Beautiful Tailwind CSS interface
- **Real Data** - Uses actual data from `sql/bincom_test.sql`
- **Responsive Design** - Works on all devices
- **API-First** - RESTful API endpoints for all functionality
- **CORS Enabled** - Frontend and backend can communicate
- **Form Validation** - Client and server-side validation
- **Real-time Updates** - Dynamic form loading

## 🛠️ Technology Stack

- **Frontend:** HTML5, Tailwind CSS, JavaScript (Vanilla)
- **Backend:** PHP 8.3, PDO
- **Database:** MySQL (sample data from SQL file)
- **Hosting:** Vercel (Complete Application)
- **API:** RESTful endpoints with JSON responses

## 📊 Real Data Included

- **25 LGAs** from Delta State (Aniocha North, Aniocha - South, etc.)
- **Real Ward Names** (Ezi, Idumuje - Unor, Issele - Azagba, etc.)
- **Real Polling Units** (Sapele Ward 8 PU, Primary School in Aghara, etc.)
- **Actual Election Results** from 2011 elections
- **9 Political Parties** (PDP, DPP, ACN, PPA, CDC, JP, ANPP, LABO, CPP)

## 🚀 Quick Start

### Option 1: Use Live Demo
1. Visit https://inec-results-portal.vercel.app
2. All three questions are fully functional
3. No setup required!

### Option 2: Local Development
1. Clone the repository
2. Set up XAMPP/WAMP
3. Import `sql/bincom_test.sql` to MySQL
4. Configure database in `src/db.php`
5. Access via `http://localhost/inec-results`

## 📁 Project Structure

```
inec-results/
├── api/                    # Vercel API endpoints
│   ├── config.php         # Real data configuration
│   ├── question1.php      # Individual polling unit results
│   ├── question2.php      # LGA summed results
│   └── question3.php      # Add new polling unit results
├── src/                   # PHP source files
│   ├── db.php            # Database connection
│   └── functions.php     # Helper functions
├── sql/
│   └── bincom_test.sql   # Original database dump
├── index.html            # Main frontend page
├── vercel.json          # Vercel configuration
└── README.md            # This file
```

## 🔌 API Endpoints

### Question 1: Individual Polling Unit Results
- `GET /api/question1.php?action=lgas` - Get all LGAs
- `GET /api/question1.php?action=wards&lga_id=X` - Get wards for LGA
- `GET /api/question1.php?action=polling_units&ward_id=X` - Get polling units
- `GET /api/question1.php?action=results&polling_unit_id=X` - Get results

### Question 2: LGA Summed Results
- `GET /api/question2.php?action=lgas` - Get all LGAs
- `GET /api/question2.php?action=results&lga_id=X` - Get summed results

### Question 3: Add New Polling Unit Results
- `GET /api/question3.php?action=lgas` - Get all LGAs
- `GET /api/question3.php?action=wards&lga_id=X` - Get wards
- `GET /api/question3.php?action=polling_units&ward_id=X` - Get polling units
- `GET /api/question3.php?action=parties` - Get all parties
- `POST /api/question3.php?action=add_results` - Add new results

## 🎯 How to Use

### Question 1: View Individual Results
1. Select an LGA from dropdown
2. Select a ward (automatically loads)
3. Select a polling unit (automatically loads)
4. View results table with party scores

### Question 2: View LGA Summed Results
1. Select an LGA from dropdown
2. Click "Get Summed Results"
3. View aggregated results from all polling units

### Question 3: Add New Results
1. Select LGA → Ward → Polling Unit
2. Enter vote counts for all parties
3. Click "Add Results"
4. View success confirmation

## 📋 Database Schema

The application uses these main tables from `bincom_test.sql`:
- `lga` - Local Government Areas (25 LGAs in Delta State)
- `ward` - Wards within LGAs
- `polling_unit` - Polling units within wards
- `party` - Political parties (9 parties)
- `announced_pu_results` - Individual polling unit results
- `announced_lga_results` - LGA-level results (not used for Question 2)

## 🔧 Requirements

- **PHP:** 7.4 or higher
- **MySQL:** 5.7 or higher (for local development)
- **Web Server:** Apache/Nginx (for local development)
- **Modern Browser:** Chrome, Firefox, Safari, Edge

## 📝 Notes

- **Question 2 Requirement:** Uses `announced_pu_results` table, NOT `announced_lga_results`
- **Real Data:** All data comes from the original `bincom_test.sql` file
- **Single Deployment:** Frontend and backend on same Vercel domain
- **No Database Required:** Vercel version uses sample data arrays

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

MIT License - see LICENSE file for details

## 👨‍💻 Author

**Toluwalase** - [GitHub](https://github.com/TOLUWALASE007)

---

**Live Demo:** https://inec-results-portal.vercel.app