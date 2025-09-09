# Railway Deployment Guide

## 🚀 Deploy INEC Results Portal Backend to Railway

### Step 1: Create Railway Account
1. Go to [railway.app](https://railway.app)
2. Sign up with GitHub
3. Connect your GitHub account

### Step 2: Deploy from GitHub
1. Click **"New Project"**
2. Select **"Deploy from GitHub repo"**
3. Choose your repository: `TOLUWALASE007/inec-result`
4. Click **"Deploy Now"**

### Step 3: Add MySQL Database
1. In your project dashboard, click **"+ New"**
2. Select **"Database"** → **"MySQL"**
3. Wait for MySQL to provision
4. Note the connection details

### Step 4: Set Environment Variables
1. Go to your service → **"Variables"** tab
2. Add these environment variables:

```env
MYSQL_HOST=your-mysql-host
MYSQL_DATABASE=railway
MYSQL_USER=root
MYSQL_PASSWORD=your-password
CORS_ORIGIN=https://toluwalase007.github.io
```

### Step 5: Import Database
1. Get your MySQL connection details from Railway
2. Import the SQL dump:

```bash
mysql -h your-host -u root -p railway < sql/bincom_test.sql
```

Or use Railway's MySQL console:
1. Go to your MySQL service
2. Click **"Query"**
3. Copy and paste the contents of `sql/bincom_test.sql`

### Step 6: Test Deployment
1. Your backend will be available at: `https://your-app.railway.app`
2. Test health check: `https://your-app.railway.app/api/health.php`
3. Test Question 1: `https://your-app.railway.app/show_polling_unit.php`
4. Test Question 2: `https://your-app.railway.app/show_lga_sum.php`
5. Test Question 3: `https://your-app.railway.app/add_polling_unit.php`

### Step 7: Update Frontend
1. Get your Railway URL (e.g., `https://inec-results-production-abc123.up.railway.app`)
2. Update `index.html` in your GitHub repository:
   ```javascript
   const API_BASE_URL = 'https://your-actual-railway-url.railway.app';
   ```
3. Commit and push to GitHub

### Step 8: Verify Complete Setup
1. **Frontend**: `https://toluwalase007.github.io/inec-result`
2. **Backend**: `https://your-app.railway.app`
3. **Health Check**: Should show green status
4. **All Questions**: Should work with live data

## 🔧 Troubleshooting

### Database Connection Issues
- Check environment variables are set correctly
- Verify MySQL service is running
- Test connection with Railway's MySQL console

### CORS Issues
- Ensure `CORS_ORIGIN` is set to your GitHub Pages URL
- Check that CORS headers are included in PHP files

### File Not Found
- Verify `railway.json` is in the root directory
- Check that `public/` directory contains all PHP files

## 📊 Expected Results

After successful deployment:
- **Health Check**: Returns database stats and endpoint list
- **Question 1**: Shows polling unit selection and results
- **Question 2**: Shows LGA selection and summed results
- **Question 3**: Shows form to add new polling unit results

## 💰 Cost
- **Railway Free Tier**: 500 hours/month
- **MySQL Free Tier**: 1GB storage
- **Total Cost**: $0/month (within free limits)
