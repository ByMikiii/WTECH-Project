# 👟 NaNohu.sk – Laravel e-shop s obuvou

**NaNohu.sk** je jednoduchý e-shop s obuvou vytvorený ako semestrálny projekt pre predmet **Základy webových technológií**. Aplikácia je postavená na **Laravel frameworku** a využíva **PostgreSQL** databázu.


### 1. fáza projektu

Responzívne šablóny: [WTECH-Project/wtech/public/html/](https://github.com/ByMikiii/WTECH-Project/tree/main/wtech/public/html)

CSS: [WTECH-Project/wtech/public/css/](https://github.com/ByMikiii/WTECH-Project/tree/main/wtech/public/css)

Skice: [Wireframe](https://github.com/ByMikiii/WTECH-Project/blob/main/wireframe.jpg)

Návrh fyzického dátového modelu: [Class Diagram](https://github.com/ByMikiii/WTECH-Project/blob/main/class_diagram.png)

### Zdroje
#### Obrazky

Obrazky použité v tomto projekte sú voľne dostupné na stránke [Pexels](https://www.pexels.com) od používateľov:

- **Melvin Buezo**: [Pexels profil](https://www.pexels.com/@melvin-buezo-1253763/)
- **Perfect Lens**: [Pexels profil](https://www.pexels.com/@perfect-lens/)


#### Ikony

Ikony použité v tomto projekte sú voľne dostupné na stránke [Heroicons](https://heroicons.dev/).


### 2. fáza projektu
#### Blade šablóny a SSR logika
Projekt bol rozšírený o server-side rendering pomocou Laravelu. Boli vytvorené Blade šablóny a implementovaná aplikačná logika podľa prípadov použitia.

- Blade šablóny: [`resources/views/`](https://github.com/ByMikiii/WTECH-Project/tree/main/wtech/resources/views)

- Laravel Controllers: [`app/Http/Controllers/`](https://github.com/ByMikiii/WTECH-Project/tree/main/wtech/app/Http/Controllers)

- Laravel routes: [`routes/web.php`](https://github.com/ByMikiii/WTECH-Project/blob/main/wtech/routes/web.php)

- Migrations [`database/migrations`](https://github.com/ByMikiii/WTECH-Project/tree/main/wtech/database/migrations)

#### Funkcionality
- **Autentifikácia:** Vlastné riešenie prihlasovania a registrácie (bez použitia Breeze), možnosť úpravy údajov, zmena a obnova hesla (bez emailu, priamy reset).
- **Košík:** Podpora pre prihlásených aj neprihlásených používateľov. Dáta sa ukladajú buď do databázy (autentifikovaný používateľ), alebo do `localStorage` (neprihlásený).
- **Objednávky:** Vyplnenie údajov, výber spôsobu platby a dopravy.
- **Kategórie a filtrovanie:** Možnosť výberu z predvolených kategórií (Muži, Ženy, Novinky) a taktiež vlastného filtrovania, vyhľadávania a zoradenia.
- **Recenzie:** Registrovaní používatelia môžu pridať jednu recenziu na produkt. Zobrazenie priemerného hodnotenia a všetkých recenzií.
- **Administrácia:** Administrátorský účet umožňuje pridávať, upravovať a mazať produkty. Tieto možnosti sú viditeľné iba pre administrátora.

---

## Postup na spustenie

### 1. Stiahnutie projektu
```bash
git clone https://github.com/ByMikiii/WTECH-Project
cd WTECH-Project/wtech
```

### 2. Inštalácia PHP závislostí
```bash
composer install
```

### 3. Vytvorenie `.env` súboru
```bash
cp .env.example .env
```

Následne je v `.env` súbore potrebné nastaviť údaje databázy, napríklad:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=wtech
DB_USERNAME=postgres
DB_PASSWORD=pass
```

### 4. Vytvorenie aplikačného kľúča
```bash
php artisan key:generate
```

### 5. Spustenie migrácií a seederu
```bash
php artisan migrate:fresh --seed
```

### 6. Spustenie samotnej aplikácie
```bash
php artisan serve
```

Aplikácia by mala byť defaulne na: [http://localhost:8000](http://localhost:8000)

---

## Testovacie účty

Pre účely testovania boli pomocou seederu vytvorené 2 účty:

### Administrátor
- **E-mail:** `admin@admin.admin`
- **Heslo:** `adminn`

### Zákazník
- **E-mail:** `user@user.user`
- **Heslo:** `userrr`
