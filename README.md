# Delivery Management & Tracking System

A full-stack parcel delivery management system built for the Client-Server Systems module (University of Salford). Delivery staff log in to manage delivery records, look up deliveries in real time, and view delivery points plotted on an interactive map.

## Features

- **Authentication with role-based routing** — session-based login verified with `password_verify()`; users are redirected to different dashboards depending on `usertype` (standard delivery staff vs. supervisor view).
- **Delivery record CRUD** — create, read, update, and delete delivery records (`newDelivery.php`, `updateRecord.php`, `deleteRecord.php`, `getRecord.php`).
- **Live search** — an AJAX-driven live search box (vanilla JS `XMLHttpRequest`) that queries `IndexLiveSearch.php` on keystroke and renders matching delivery users without a page reload.
- **Interactive delivery map** — built with OpenLayers (`ol`) and OpenStreetMap tiles, plotting each delivery point as a marker centred on Manchester. Clicking a marker opens a popup that generates a scannable **QR code** on the fly linking back to that delivery record.
- **Image handling** — delivery/parcel photo uploads via `images/createImage.php`.

## Tech Stack

- **Backend:** PHP (OOP, namespaced `Models` layer), PDO with **prepared statements** throughout (protects against SQL injection)
- **Database:** MySQL
- **Architecture:** Lightweight MVC — `Models/` (`Database`, `DeliveryUsers`, `DeliveryUsersDataset`, `DeliveryPoint`, `DeliveryPointDataset`), `Views/` (`.phtml` templates), controllers as top-level PHP scripts
- **Frontend:** Bootstrap, vanilla JavaScript (AJAX/XHR), OpenLayers (interactive maps), QRCode.js
- **Security:** Password hashing/verification (`password_verify`), parameterised PDO queries, server-side input sanitisation on GET/session parameters

## Skills Demonstrated

Full-stack PHP/MySQL development · OOP & namespaced MVC design · secure authentication (hashed passwords, prepared statements) · AJAX/live search implementation · third-party API/library integration (OpenLayers mapping, QR code generation) · session management · form validation & secure data handling

## Running Locally

1. Set up a MySQL database and import your schema (delivery users / delivery points tables referenced in `Models/`).
2. Copy `config.example.php` to `config.php`, fill in your real database credentials, and `require` it at the top of `index.php` before any model classes load.
3. Serve the folder with PHP's built-in server for local testing:
   ```bash
   php -S localhost:8000
   ```

## Note

This was originally built against a university-hosted MySQL server with hardcoded credentials in `Models/Database.php`. Before publishing, the connection was refactored to read from environment variables (`DB_USERNAME`, `DB_PASSWORD`, `DB_HOST`, `DB_NAME`) via `config.php`, which is gitignored — no real credentials are in this repo.
