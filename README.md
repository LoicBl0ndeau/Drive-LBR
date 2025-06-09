# Drive‑LBR

A lightweight web-based media management platform designed to serve as a “drive” for organizing, viewing, and storing event multimedia content.
> This project was originally developed as a **student initiative** to support the [**Les Briques Rouges**](https://www.lesbriquesrouges.fr/) music event in managing, viewing, and organizing their media content in a simple and collaborative way.

---

## 📦 Table of Contents

1. [🚀 Features](#-features)

   * [👤 User Accounts](#-user-accounts)
   * [🛠️ Account Management](#️-account-management)
   * [🏷️ Classification](#-classification)
   * [🔎 Search](#-search)
   * [🖼️ Media Handling](#-media-handling)
   * [🗑️ Trash (Recycle Bin)](#-trash-recycle-bin)
   * [💾 Storage Usage](#-storage-usage)
   * [📜 Modification History](#-modification-history)
   * [📧 Email Notifications](#-email-notifications)
   * [⚠️ Missing Features](#-missing-features)

2. [Getting Started](#getting-started)

   * [Prerequisites](#prerequisites)

3. [Installation](#installation)

4. [Configuration](#configuration)

5. [Usage](#usage)

6. [Deployment](#deployment)

7. [Project Structure](#project-structure)

8. [Contributing](#contributing)

9. [Disclaimer](#disclaimer)

---

## 🚀 Features

### 👤 User Accounts

* 🔒 Secure access to the storage area via username and hashed password.
* 📝 Each account stores: first name, last name, email (used as login), description, and role.
* 🎭 Four user roles implemented exactly as specified in the requirements.
* 📊 Profile page shows number of photos/videos uploaded and storage space used (in MB). Also includes logout and home navigation buttons.
* 🖼️ Users can personalize profiles by uploading a profile picture.
* 🔑 Users can update their password, first name, and last name once logged in.
* 🔄 Password reset available in case of forgotten passwords.

### 🛠️ Account Management

* 📋 View the full list of active user accounts.
* ➕ Add new users with mandatory fields and password strength validation.
* ❌ Deleted users become inactive: cannot log in but their uploaded data stays in the database.
* ✏️ Edit user details: first name, last name, email, password, description, and role.
* 🔍 Search to quickly find users.
* 🔄 Toggle button to view only inactive (deleted) accounts.

### 🏷️ Classification

* ➕✏️❌ Add, edit, and delete tag categories — except the default “Autre” (Other).
* ➕✏️↔️❌ Add, edit, move, or delete tags except the special “sans tags” tag belonging to “Autre.”
* 🆕 Uploaded files get the “sans tags” tag automatically; it disappears when other tags are assigned but can return if all tags are removed.
* ⚙️ Tag and category management accessible via gear icon on homepage.
* ➕ Categories and tags can be added, renamed, deleted (moving tags to “Autre”), or rearranged.

### 🔎 Search

* 🔤 Filter media by extension, date, and author with AND/OR logic (e.g., `.mp4;.jpg;24/06/2021`).
* 📂 Tag navigation menu filters media by selecting categories and tags, supports multiple tag selections with AND filtering.
* ↕️ Sort media by date (default) or author.
* 📸 “My photos” button shows only logged-in user’s uploads.
* 🔁 Toggle ascending/descending display order.

### 🖼️ Media Handling

* 👈 Left-click opens media in larger view.
* ▶️ Videos show play icon and only play after click.
* 👉 Right-click opens context menu: view info, add/remove tags, delete (move to trash), download.

### 🗑️ Trash (Recycle Bin)

* 🔎 Same search and sort as main view.
* 👉 Right-click menu: view info, restore file, permanently delete, download.
* 👈 Left-click opens media preview; videos behave the same as main.

### 💾 Storage Usage

* 📊 Displays space used by each user.
* 🔍 Search users by name.
* 📈 Shows total storage used by all media.

### 📜 Modification History

* 📧 Logs sent emails.
* 👥 Tracks user account creation, modification, and deletion.
* 📤 Logs uploaded files with counts.
* 🔐 Records user login events.

### 📧 Email Notifications

* ✉️ Sends emails when accounts are created, modified, or deleted.
* 🔑 Sends password reset emails with new login info.

---

### ⚠️ Missing Features

* ❌ No multi-file selection yet.
* ❌ Admins can’t assign tags visible to guests beyond their own photos.

---

## Getting Started

Follow these steps to run Drive‑LBR locally or on your own server.

### Prerequisites

* A web server with **PHP** (e.g., Apache or Nginx + PHP‑FPM)
* **MySQL** or **MariaDB** database

---

## Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/YourOrg/Drive-LBR.git
   cd Drive-LBR
   ```

2. **Initialize the database**:
   Import the schema to create required tables:

   ```bash
   mysql -u root -p drive_lbr < lbr.sql
   ```

   (Use `drive.sql` or relevant `.txt` file that contains table structure)&#x20;

3. **Install media directories**:
   Ensure the `storage/` (or `uploads/`) folder exists and is writable:

   ```bash
   mkdir -p storage
   chmod 755 storage
   ```

---

## Configuration

Edit `connect.php` to configure the database connection.

```php
<?php
  $user = 'root';
  $pass='';
  try{
    $PDO = new PDO ('mysql:host=localhost;dbname=lbr', $user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
  }
  catch (PDOException $e){
    print "Erreur :" . $e->getMessage() . "<br/>";
    die;
  }
 ?>
```

---

## Usage

1. **Run locally** via built-in PHP server (for testing only):

   ```bash
   php -S localhost:8000 -t public/
   ```

2. **Navigate to** `http://localhost:8000/`

   * Log in with seeded credentials (set in database or via seed script).
   * Upload media from the interface.
   * Browse, preview, and manage your uploads.

3. **Admin panel**:

   * View logs of uploads and user sessions.
   * Manage storage and clean up outdated files.

---

## Deployment

* Deploy to any PHP-compatible hosting.
* Ensure `storage/` is protected or placed outside the web root.
* HTTPS is strongly recommended.
* Setup cronjobs if desired for maintenance.

---

## Project Structure

```
.
├── account_Manager_accueil.php         ─ Main dashboard for user management
├── account_Manager_add_user.php        ─ Form to add new users
├── account_Manager_delete_user.php     ─ Interface to delete users
├── account_Manager_edit_user.php       ─ Edit existing user details
├── account_Manager_header.php          ─ Header template for admin pages
├── account_Manager_header_lite.php     ─ Lightweight header for mobile views
├── account_Manager_submit_delete_user.php ─ Handles user deletion requests
├── account_Manager_submit_edit_user.php   ─ Processes user edits
├── account_Manager_submit_user.php         ─ Processes new user submissions
├── account_Manager_variables.php       ─ Contains variables for user management
├── accueil.php                         ─ Main user dashboard
├── fichiers supplémentaires/           ─ Additional files containing a database file
├── images/                             ─ Image assets
├── js/                                 ─ JavaScript files
├── pdp/                                ─ Personal Profile Picture
├── police/                             ─ Font files
├── style/                              ─ CSS stylesheets
├── upload/                             ─ Directory for uploaded files
├── .gitignore                          ─ Git ignore file
├── README.md                           ─ Project documentation
```

---

## Contributing

1. Fork the repo ✂️
2. Create a feature branch (`git checkout -b feature/awesome`)
3. Commit your changes (`git commit -m "Add awesome feature"`)
4. Push to the branch (`git push origin feature/awesome`)
5. Open a pull request

---

## ⚠️ Disclaimer

> This project was developed by students as part of a learning experience and is no longer actively maintained. It may contain outdated code and potential security vulnerabilities.
>
> **Use only in a local or trusted environment for personal or demonstration purposes. Do not deploy it in production or expose it to the internet without a full security review.**
