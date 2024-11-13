# NetBack
NetBack is a PHP library designed for backing up and restoring data from network devices and applications. It provides an easy-to-use interface for managing backups across various platforms, including IBSng, Mikrotik, and xui.

---

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Example](#examples)
- [Available Methods](#available-methods)
- [License](#license)

---

## Features
- Backup and restore functionality for network devices.
- Support for multiple device types: IBSng, Mikrotik, and xui.
- Logging capabilities to track backup operations.

## Requirements
- PHP 7.4 or higher
- Composer
- phpseclib3 library
- EasyLog library

## Installation
You can install NetBack using Composer. Run the following command in your terminal:

```bash
composer require imafaz/netback
```

## Usage
To use the NetBack library, you need to create instances of the classes corresponding to the devices you want to back up. Below are examples of how to use each class.

### Examples
#### Example for IBSng
```php
require __DIR__ . '/vendor/autoload.php';

use NetBack\IBSng;

$ibsng = new IBSng('IBSngDevice', '192.168.1.1', 'username', 'password', 22);
$ibsng->backup('/path/to/local/backup.sql');
```

#### Example for Mikrotik
```php
require __DIR__ . '/vendor/autoload.php';

use NetBack\Mikrotik;

$mikrotik = new Mikrotik('MikrotikDevice', '192.168.1.2', 'username', 'password', 22);
$mikrotik->backup('backupName', '/path/to/local/backup.backup');
```

#### Example for xui
```php
require __DIR__ . '/vendor/autoload.php';

use NetBack\xui;

$xui = new xui('xuiDevice', '192.168.1.3', 'username', 'password', 22);
$xui->backup('/path/to/local/xui.db');
```

## Available Methods

### IBSng
### `__construct`

#### Description:

Initializes the IBSng object with connection parameters.

#### Signature:

```php
$ibsng = new IBSng(string $name, string $ip, string $username, string $password, int $port);
```

#### Attributes:

| Attribute    | Description                   | Type   | Required | Default |
| ------------ | ----------------------------- | ------ | -------- | ------- |
| $name        | Name of the IBSng device     | string | Yes      | -       |
| $ip          | IP address of the device      | string | Yes      | -       |
| $username    | Username for authentication    | string | Yes      | -       |
| $password    | Password for authentication    | string | Yes      | -       |
| $port        | Port for SSH connection       | int    | Yes      | 22      |

---

### `backup`

#### Description:

Performs a backup of the IBSng database.

#### Signature:

```php
$ibsng->backup(string $localPath);
```

#### Attributes:

| Attribute    | Description                   | Type   | Required | Default |
| ------------ | ----------------------------- | ------ | -------- | ------- |
| $localPath   | Path to save the backup file  | string | Yes      | -       |

---

### Mikrotik

### `__construct`

#### Description:

Initializes the Mikrotik object with connection parameters.

#### Signature:

```php
$mikrotik = new Mikrotik(string $name, string $ip, string $username, string $password, int $port);
```

#### Attributes:

| Attribute    | Description                   | Type   | Required | Default |
| ------------ | ----------------------------- | ------ | -------- | ------- |
| $name        | Name of the Mikrotik device   | string | Yes      | -       |
| $ip          | IP address of the device      | string | Yes      | -       |
| $username    | Username for authentication    | string | Yes      | -       |
| $password    | Password for authentication    | string | Yes      | -       |
| $port        | Port for SSH connection       | int    | Yes      | 22      |

---

### `backup`

#### Description:

Creates a backup of the Mikrotik device.

#### Signature:

```php
$mikrotik->backup(string $backupName, string $localPath);
```

#### Attributes:

| Attribute    | Description                   | Type   | Required | Default |
| ------------ | ----------------------------- | ------ | -------- | ------- |
| $backupName  | Name of the backup file       | string | Yes      | -       |
| $localPath   | Path to save the backup file  | string | Yes      | -       |

---

### xui

### `__construct`

#### Description:

Initializes the xui object with connection parameters.

#### Signature:

```php
$xui = new xui(string $name, string $ip, string $username, string $password, int $port);
```

#### Attributes:

| Attribute    | Description                   | Type   | Required | Default |
| ------------ | ----------------------------- | ------ | -------- | ------- |
| $name        | Name of the xui device        | string | Yes      | -       |
| $ip          | IP address of the device      | string | Yes      | -       |
| $username    | Username for authentication    | string | Yes      | -       |
| $password    | Password for authentication    | string | Yes      | -       |
| $port        | Port for SSH connection       | int    | Yes      | 22      |

---

### `backup`

#### Description:

Downloads the xui database file.

#### Signature:

```php
$xui->backup(string $localPath);
```

#### Attributes:

| Attribute    | Description                   | Type   | Required | Default |
| ------------ | ----------------------------- | ------ | -------- | ------- |
| $localPath   | Path to save the database file | string | Yes      | -       |

---

## License
This project is licensed under the MIT License. See the [LICENSE](https://github.com/imafaz/NetBack/blob/main/LICENSE) file for details.