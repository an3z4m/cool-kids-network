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

1. **Clone the repository**:
   ```bash
   git clone https://github.com/an3z4m/cool-kids-network.git
