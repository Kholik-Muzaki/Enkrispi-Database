# CRUD Users with AES Encryption

This project is a CRUD (Create, Read, Update, Delete) application for managing user data with AES encryption for sensitive information. It is built using PHP and Bootstrap for a responsive and user-friendly interface.

## Features

- Add new users with encrypted data.
- View user details with decrypted data.
- Edit user information with decryption and re-encryption.
- Delete users from the database.
- Decrypt data manually using a decryption form.

## Technologies Used

- PHP
- Bootstrap 4.5
- MySQL
- AES Encryption

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/Kholik-Muzaki/Enkrispi-Database.git
    ```

2. **Navigate to the project directory:**
    ```bash
    cd your-repository
    ```

3. **Setup your database:**
    - Create a MySQL database.
    - Import the `database.sql` file to create the necessary tables.
    - Update `koneksi.php` with your database credentials.

4. **Setup environment variables:**
    - Create a `.env` file in the project root directory.
    - Add your AES encryption key in the `.env` file:
        ```plaintext
        AES_KEY=your_secret_key
        ```

5. **Run the application:**
    - Place the project in your web server's root directory.
    - Open the application in your browser.

## Usage

### Add User

1. Navigate to the Add User page.
2. Fill in the user's details.
3. Click the "Simpan" button to save the encrypted user data.

### View Users

1. Navigate to the main page to view the list of users.
2. Click on "Detail" to view the decrypted user details.

### Edit User

1. Navigate to the main page to view the list of users.
2. Click on "Edit" to modify the user details.
3. Update the information and click "Simpan" to save the changes with encryption.

### Delete User

1. Navigate to the main page to view the list of users.
2. Click on "Hapus" to remove the user from the database.

### Decrypt Data Manually

1. Navigate to the Decrypt Data page.
2. Enter the encrypted data and IV (Base64).
3. Click the "Dekripsi" button to view the decrypted information.

