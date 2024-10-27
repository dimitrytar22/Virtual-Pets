# Virtual Pets

<div align="center">
    <img src="readme-logo.jpg" alt="Logo" width="300"/>
</div>

## Description
Virtual Pets is a card game where users can collect and interact with virtual pets. Each pet has unique attributes such as name, strength, hunger, and experience.

## Features
- Collectible pets
- Unique cards with attributes
- Gameplay mechanics for interacting with pets

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/dimitrytar22/Virtual-Pets.git
2. Install dependencies:
    ```bash
   composer install
3. Install ngrok:
    ```bash
    https://ngrok.com/
4. Start ngrok:
   ```bash
   ngrok http 8000 
5. Set ngrok URL to .env APP_URL=
    ```
    example APP_URL=https://f828-92-253-236-33.ngrok-free.app/
6. Unset and set webhook
    ```bash
   php artisan telegraph:unset-webhook
   php artisan telegraph:set-webhook

## License
This project is licensed under the MIT License.
