# aspire-app
Aspire app is mini digital loan management system.
## SETUP

# Step 1:
git clone https://github.com/mohdkaif/aspire-app.git

# Step 2:
cd aspire-app


# Step 3:
create .env file in root directory if .env not exist 
copy from .env.example and paste in .env
change database configuration accordingly

# Step 4:
 run command 
# Step 5:
 composer install
# Step 6:
 php artisan key:generate
# Step 7:
 php artisan migrate
# Step 8:
 php artisan passport:install
# Step 9:
 php artisan serve

 ## Api End Point

 http://localhost:8000/api

 postman collection added in this directory

 ## Features

Aspire-App  API provide the restful api with two scope are admin and customer as follows:

Admin API: /admin/

Customer API: /user/

### Admin API definition
**Users**
- Can register as admin, login as admin

**Loans**
- Can see the loan request of users.
- Can approved or decline users loans request
- can see list of loans
- can see details of loans

### Customer  API definition
**User**
- Can register an account.- Can login, logout system.- Can get user's profile.- Can list all of their loans.- Can pay for repayment of their loans.
### Logic
Loan  logic
- When admin Approved loan request , also create next payment Date schedule for that loan.
Payment Transactions
- When a user make a success payment its store in payment_history column as json in loan table and update next payment date column.
- when user will pay last payment its will display message "Loan payment Comppleted successfull"
- and also status will change as Completed. 
