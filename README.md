# The Curve Expenses

## "The Curve" - Work Experience 2024

### Dates: 1st July - 5th July

This is created using:
  - Hypertext Preprocessor (PHP)
  - Hyper Text Markup Language (HTML)
  - Cascading Style Sheets (CSS)
  - JavaScript (JS)


## Install Guide
1) Clone the repo.
2) Re-name the .env_example file the .env and fill out the infomation. It's located in the /private folder
3) Run the following command inside the root directory
```bash
chmod 777 ./private/pages/api/form/submit/images/
```
4) Setup a WebServer in the `./public` folder.
5) To install the database, create a database and run the following SQL on it
```SQL
CREATE TABLE `records` (
  `id` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `reason` text NOT NULL,
  `details` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` timestamp NOT NULL,
  `dateAfter` timestamp NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `expenses` text NOT NULL,
  `receipts` text NOT NULL,
  `assistance` tinyint(4) NOT NULL,
  `comment` text NOT NULL
)
```

```SQL
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `manager` bigint(20) NOT NULL,
  `notification` int(11) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `password` text NOT NULL,
  `session` text NOT NULL,
  `password_token` text NOT NULL,
  `hash` text NOT NULL,
  `verify_token` text NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT 0
)
```

```SQL
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);
```
```SQL
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
```
