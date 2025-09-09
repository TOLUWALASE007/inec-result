# INEC Results Portal - Deployment Guide

## Architecture Overview
- **Frontend**: GitHub Pages (Static HTML/CSS/JS)
- **Backend**: Railway (PHP + MySQL)

## Step 1: Deploy Backend to Railway

### 1.1 Prepare Backend
```bash
# Add CORS headers to all PHP files
# Include cors_headers.php at the top of each PHP file
```

### 1.2 Deploy to Railway
1. **Create Railway Account**: Go to [railway.app](https://railway.app)
2. **Connect GitHub**: Link your repository
3. **Create New Project**: Select your repository
4. **Add Database**: Add MySQL service
5. **Set Environment Variables**:
   ```
   DB_HOST=your-mysql-host
   DB_NAME=your-database-name
   DB_USER=your-username
   DB_PASS=your-password
   CORS_ORIGIN=https://your-github-username.github.io
   ```

### 1.3 Import Database
```bash
# Import your SQL dump to Railway MySQL
mysql -h your-host -u your-user -p your-database < sql/bincom_test.sql
```

### 1.4 Test Backend
- Visit: `https://your-app.railway.app/api/health`
- Should return: `{"status":"success","message":"Backend is running"}`

## Step 2: Deploy Frontend to GitHub Pages

### 2.1 Create GitHub Repository
```bash
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/your-username/inec-results.git
git push -u origin main
```

### 2.2 Enable GitHub Pages
1. Go to repository **Settings**
2. Scroll to **Pages** section
3. Select **Source**: Deploy from a branch
4. Select **Branch**: main
5. Select **Folder**: /public/github_pages
6. Click **Save**

### 2.3 Update API URL
Edit `public/github_pages/index.html`:
```javascript
const API_BASE_URL = 'https://your-railway-app.railway.app';
```

### 2.4 Custom Domain (Optional)
- Add `CNAME` file in `/public/github_pages/`
- Configure DNS settings

## Step 3: Test Complete Setup

### 3.1 Frontend URL
- GitHub Pages: `https://your-username.github.io/inec-results`
- Custom Domain: `https://your-domain.com`

### 3.2 Backend URLs
- Health Check: `https://your-app.railway.app/api/health`
- Question 1: `https://your-app.railway.app/show_polling_unit.php`
- Question 2: `https://your-app.railway.app/show_lga_sum.php`
- Question 3: `https://your-app.railway.app/add_polling_unit.php`

## Step 4: Environment Configuration

### 4.1 Railway Environment Variables
```env
DB_HOST=containers-us-west-xxx.railway.app
DB_NAME=railway
DB_USER=root
DB_PASS=your-password
CORS_ORIGIN=https://your-username.github.io
```

### 4.2 GitHub Pages Configuration
- Repository: `your-username/inec-results`
- Branch: `main`
- Folder: `/public/github_pages`
- Custom Domain: (optional)

## Troubleshooting

### Backend Issues
- Check Railway logs
- Verify database connection
- Test API endpoints directly
- Check CORS configuration

### Frontend Issues
- Check browser console for errors
- Verify API_BASE_URL is correct
- Test GitHub Pages deployment
- Check CORS headers

### Database Issues
- Verify MySQL service is running
- Check connection credentials
- Import SQL dump completely
- Test queries directly

## Cost Breakdown
- **GitHub Pages**: Free
- **Railway**: Free tier available (500 hours/month)
- **Custom Domain**: ~$10-15/year (optional)

## Security Considerations
- CORS is configured for your domain
- Database credentials are environment variables
- No sensitive data in frontend code
- API endpoints are public (consider authentication for production)

## Monitoring
- Railway provides built-in monitoring
- GitHub Pages shows deployment status
- Use browser dev tools for debugging
- Monitor API response times
