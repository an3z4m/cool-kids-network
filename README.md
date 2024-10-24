# cool-kids-network
WP-based User Management System

## Description
Cool Kids Network is a WordPress plugin that implements a user management system with role-based access control. It automatically generates a fictional character for users upon signup and allows users with special roles to view data of other users. It also introduces a custom role called **'Network Maintainer'** for safely managing authenticated API requests without needing admin-level permissions.

## Features
- **User Sign-up**: Users can register with their email, and a fictional character (first name, last name, country) is automatically created using the randomuser.me API.
- **Role-based Access**:
  - **Cool Kid**: Users can see only their own character data.
  - **Cooler Kid**: Users can view the names and countries of other users.
  - **Coolest Kid**: Users can view the names, countries, emails, and roles of other users.
- **Login**: Users can log in using their email address (passwords are not checked for this proof of concept).
- **Custom Role - Network Maintainer**: A new role specifically for safely managing API requests, allowing users to perform role updates without requiring full admin access.
- **REST API**: Admins or Network Maintainers can assign special roles (Cool Kid, Cooler Kid, Coolest Kid) to users via a REST API endpoint.

## Download Ready-to-Use Versions

The role-based features are integral to the Cool Kids Network plugin, which is designed to work seamlessly with any WordPress theme. For an enhanced user experience, we’ve also created a custom, clean theme that complements the plugin’s functionality.

You can choose to use the plugin with your existing theme, or, for optimal design consistency, you can use our custom theme. Both the plugin and theme are available for download from the **releases** folder:

- [Download Cool Kids Network Plugin](releases/cool-kids-network.zip)
- [Download Cool Kids Theme](releases/cool-kids-theme.zip)


## Installation
1. Download the plugin zip file.
2. Go to your WordPress admin dashboard.
3. Navigate to **Plugins > Add New**.
4. Click **Upload Plugin** and upload the plugin zip file.
5. Click **Activate**.
6. Create the **Network Maintainer** role:
    - After activating the plugin, a new role **'Network Maintainer'** will be automatically created with permission to manage API requests securely.

## Shortcodes
### Signup Form
Add the shortcode `[cool_kids_network]` to display:
- The profile and the list of users if the user is logged in.
- The login and signup forms for anonymous users.

## API Endpoints

### Update User Role
**Endpoint**: `/wp-json/cool-kids/v1/update-role`  
**Method**: `POST`

**Description**: Allows a **Network Maintainer** to update a user's role using either their email or their first and last name.

**Authentication**: Requires **Network Maintainer** credentials or admin user credentials. For security, avoid using admin credentials and use the dedicated **Network Maintainer** role.

#### Example Request (using email)
```bash
curl -X POST https://yourdomain.com/wp-json/cool-kids/v1/update-role \
-u maintainer_username:application_password \
-H "Content-Type: application/json" \
-d '{
    "email": "user@example.com",
    "role": "coolest_kid"
}'
```

## Live Demo Website
[Cool Kids Network Demo](https://cool-kids-network.wpdevcloud.com/)

### Request to the live demo installation (using email)
```bash
curl -X POST https://cool-kids-network.wpdevcloud.com/wp-json/cool-kids/v1/update-role \
-u api_manager_username:"pgFb IOQB DAC1 vq7u 2jPd 1AYj" \
-H "Content-Type: application/json" \
-d '{
    "email": "user1@gmail.com",
    "role": "coolest_kid"
}'
```

If the request is successful, you will get a response similar to this:

```bash
{"status":"success","message":"User role updated successfully.","user":{"ID":4,"email":"user1@gmail.com","role":"coolest_kid"}}
```