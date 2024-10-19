# cool-kids-network
WP-based User Management System

## Description
Cool Kids Network is a WordPress plugin that implements a user management system with role-based access control. It automatically generates a fictional character for users upon signup and allows users with special roles to view data of other users.

## Features
- **User Sign-up**: Users can register with their email, and a fictional character (first name, last name, country) is automatically created using the randomuser.me API.
- **Role-based Access**:
  - **Cool Kid**: Users can see only their own character data.
  - **Cooler Kid**: Users can view the names and countries of other users.
  - **Coolest Kid**: Users can view the names, countries, emails, and roles of other users.
- **Login**: Users can log in using their email address (passwords are not checked for this proof of concept).
- **REST API**: Admins can assign special roles (Cool Kid, Cooler Kid, Coolest Kid) to users via a REST API endpoint.

## Installation
1. Download the plugin zip file.
2. Go to your WordPress admin dashboard.
3. Navigate to **Plugins > Add New**.
4. Click **Upload Plugin** and upload the plugin zip file.
5. Click **Activate**.

## Shortcodes
### 1. Signup Form
`[cool_kids_signup]`  
Displays a form that allows users to sign up. A random character is generated upon successful registration.

### 2. Login Form
`[cool_kids_login]`  
Displays a login form where users can log in using their email.

### 3. Profile View
`[cool_kids_profile]`  
Displays the logged-in user's character profile, including name, country, and other data.

### 4. User List
`[cool_kids_user_list]`  
Displays a list of all registered users. Only accessible to users with the **Cooler Kid** or **Coolest Kid** roles.

## API Endpoints

### Update User Role
**Endpoint**: `/wp-json/cool-kids/v1/update-role`  
**Method**: `POST`

**Description**: Allows a maintainer to update a user's role using either their email or their first and last name.

**Authentication**: Requires an Application Password or admin user credentials.

#### Example Request (using email)
```bash
curl -X POST https://yourdomain.com/wp-json/cool-kids/v1/update-role \
-u admin_username:application_password \
-H "Content-Type: application/json" \
-d '{
    "email": "user@example.com",
    "role": "coolest_kid"
}'
