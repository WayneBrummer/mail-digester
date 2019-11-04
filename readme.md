# Laravel Mail Digester

Mail Digester will schedule and run a daily, weekly or monthly summary of unread emails from the default notifications table of Laravel.

Basically for those people who like to ignore broadcasts or slack messages...

## Install

Via Composer:

```bash
composer require waynebrummer/mail-digester
```

Publish the config file:

```bash
php artisan vendor:publish --provider="Pace\MailDigester\ServiceProvider"
```

---

## Usage Config

Once installed, it will collect all unread emails from the notifications table.

WIP Group together common items from the data attribute.

The following config options are available in `config/mail-digester.php`:

- **enabled**: Set to `true` or `false` to enable the sending of the mails.
  
- **frequency**: Array set to `daily`, `weekly` or `monthly`  to schedules for mail digestion.

- **occurrence**: Physical time to the server or when to trigger summarized mails.
  - `daily` will use `hh:mm`
  - `weekly` will use e.g `1` , `2` etc `7`
  - `monthly` will use `1` , `2` etc `last_day`

- **mark_read**: Will automatically update the unread status of the mail once the summary mail has been sent.

---

## Usage Middleware

Padding the `config` requested middleware id a lot with the
notification id will render the notification read.

`identifier`

''
{url}/notification_id={notification_id}
''

---

## ***Note on local development testing***

Make sure to use mailtrap.io or Telescope or something.

---

## Contributing WIP

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email @wayne.brummer instead of using the issue tracker.

## Credits

-- None

## License

The Apache License (Apache 2.0). Please see [License File](LICENSE.md) for more information.
