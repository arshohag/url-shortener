# URL Shortener

![URL Shortener](https://github.com/arshohag/url-shortener/blob/develop/url-shortener.gif?raw=true)

## Introduction

This is a URL shortener featuring a Laravel backend and a a Vue.js frontend.

It's main features are:

- Shorten links
- Short URL format: example.com/[hash].
- The Short URL Validation & Duplicate Check.
- Input URL validation.
- The URL shortened till 6 symbols hash, which contains alphanumeric symbols.
- List for previously created URLs.
- Scan Input URL for Malware.
- Short URL redirection to the original URL.
- Vue frontend interacting with the Laravel API

## Installation

1. Clone this repository

```bash
git clone git@github.com:arshohag/url-shortener.git
```

2. Install dependencies

```bash
composer install
```

3. Copy .env.example to .env

```bash
cp .env.example .env
```

4. Generate app key

```bash
php artisan key:generate
```

4. Set these keys in .env.

```bash
APP_URL
MIX_APP_URL
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
CLOUDMERSIVE_API_KEY
CLOUDMERSIVE_BASE_URL
```

5. Install dependencies

```bash
npm install
```

6. Compile dependencies

```bash
npm run dev
```

## 3rd Party API

For scanning safe URL, [cloudmersive](https://account.cloudmersive.com/documentation?selected=%2fvirus%2fscan%2fwebsite&api=linkVirus&language=linkCurl)) is used. Check their documentaion and create a free account to get an API key.

## Contributing

Pull requests are welcome. Please open an issue to discuss.

## License

GPL-3.0-only. Please see the [license file](LICENSE.md) for more information.
